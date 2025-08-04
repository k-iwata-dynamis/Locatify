<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MapController extends Controller
{
    /**
     * Display the map view
     */
    public function index()
    {
        $googleMapsApiKey = config('services.google.google_maps_api_key');
        
        return view('map.index', compact('googleMapsApiKey'));
    }
    
    /**
     * Display the test map view
     */
    public function test()
    {
        $googleMapsApiKey = config('services.google.google_maps_api_key');
        
        return view('map.test', compact('googleMapsApiKey'));
    }
    
    /**
     * Get current location (for testing purposes)
     */
    public function getCurrentLocation(Request $request)
    {
        // In a real application, you might want to store user locations
        // or perform some server-side processing with the location data
        
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        
        return response()->json([
            'success' => true,
            'message' => '現在地を取得しました',
            'location' => [
                'latitude' => $latitude,
                'longitude' => $longitude
            ]
        ]);
    }


    public function searchNearByRestaurants(Request $request)
    {
        //周辺のレストランを検索するためのメソッド
        
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $radius = $request->input('radius', 1000); // Default radius 1000 meters
        
        $apikey = config('services.google.google_maps_api_key');
        
        // レストランに特化した検索パラメータを追加
        $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?" . http_build_query([
            'location' => "{$latitude},{$longitude}",
            'radius' => $radius,
            'type' => 'restaurant',
            'keyword' => 'restaurant food dining',
            'key' => $apikey
        ]);
        
        try {
            $response = Http::timeout(30)->get($url);
            
            if ($response->successful()) {
                $data = $response->json();
                
                // レスポンスにデバッグ情報を追加
                Log::info('Places API Response', [
                    'status' => $data['status'] ?? 'unknown',
                    'results_count' => count($data['results'] ?? []),
                    'url' => $url
                ]);
                
                return response()->json($data);
            } else {
                Log::error('Places API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return response()->json([
                    'status' => 'REQUEST_DENIED',
                    'error_message' => 'Places API request failed',
                    'results' => []
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Places API Exception', [
                'message' => $e->getMessage(),
                'url' => $url
            ]);
            
            return response()->json([
                'status' => 'REQUEST_DENIED',
                'error_message' => 'Network error occurred',
                'results' => []
            ], 500);
        }
    }

}
