<x-app-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <div class="py-4">
        <!-- パステルカラー背景の全体コンテナ -->
        <div style="background: linear-gradient(135deg, #ff9a56, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57); border-radius: 12px; padding: 20px; min-height: 80vh;" class="min-h-screen sm:min-h-100vh]">
            
           <!-- 現在地情報表示エリア -->
            <div id="locationInfo" class="mb-4 p-4 bg-white bg-opacity-90 backdrop-filter blur-sm rounded-lg shadow-lg hidden">
                <h3 class="font-semibold mb-2 text-gray-800">📍 現在地情報:</h3>
                <p id="coordinates" class="text-gray-600"></p>
            </div>

            <!-- ボタンエリア - 地図の上に独立して配置 -->
            <div class="mb-4">
                <div style="background: rgba(255, 255, 255, 0.9); 
                            backdrop-filter: blur(15px); 
                            border-radius: 20px; 
                            padding: 20px; 
                            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
                            border: 2px solid rgba(255, 255, 255, 0.3);">
                    <div class="flex justify-center items-center gap-3 flex-wrap mb-4">
                        <button id="btn-restaurant" class="flex-1 min-w-[120px] bg-gradient-to-r from-orange-400 to-orange-500 hover:from-orange-500 hover:to-orange-600 text-white font-bold py-3 px-4 rounded-xl whitespace-nowrap transition-all shadow-lg transform hover:scale-105">
                            🍽️ レストラン
                        </button>
                        <button id="btn-cafe" class="flex-1 min-w-[120px] bg-gradient-to-r from-pink-400 to-red-500 hover:from-pink-500 hover:to-red-600 text-white font-bold py-3 px-4 rounded-xl whitespace-nowrap transition-all shadow-lg transform hover:scale-105">
                            ☕ カフェ
                        </button>
                        <button id="btn-smoking" class="flex-1 min-w-[120px] bg-gradient-to-r from-green-400 to-teal-500 hover:from-green-500 hover:to-teal-600 text-white font-bold py-3 px-4 rounded-xl whitespace-nowrap transition-all shadow-lg transform hover:scale-105">
                            🚬 タバコ
                        </button>
                    </div>
                    <div class="flex flex-col lg;flex-row sm:flex-row justify-center items-center gap-3">
                        <!-- 検索ボックス -->
                        <div class="relative w-full sm:w-[400px] max-w-xl bg-white rounded-full shadow-xl border-2 border-white">
                            <input class="rounded-full w-full h-16 bg-white py-2 pl-8 pr-32 outline-none border-0 text-gray-800 placeholder-gray-500 hover:shadow-lg focus:ring-4 focus:ring-blue-200 focus:shadow-xl transition-all text-lg" 
                                   type="text" 
                                   name="query" 
                                   id="query"
                                   placeholder="場所を検索...">
                            <button type="submit" class="absolute inline-flex items-center h-12 px-6 py-2 text-sm font-bold text-cyan-500 transition duration-150 ease-in-out rounded-full outline-none right-2 top-2 bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-lg transform hover:scale-105">
                                <svg class="-ml-0.5 mr-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                検索
                            </button>
                        </div>
                        <!-- 現在地取得ボタン -->
                        <button id="getCurrentLocationBtn" class="hidden sm:block bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-bold py-4 px-6 rounded-full whitespace-nowrap transition-all shadow-lg transform hover:scale-105">
                            📍 現在地を取得
                        </button>
                    </div>
                </div>
            </div>

                        <!-- メインコンテンツエリア -->
                <div class="flex flex-col lg:flex-row gap-4 h-[75vh] sm:h-[80] lg:h-[50vh]" style="overflow-y: auto; overflow-x: hidden;">
                    <!-- 地図エリア（左側） -->
                    <div class="relative flex-1 order-2 lg:order-1" id="mapContainer">
                        <div id="map" class="w-full h-[70vh] lg:h-full sm:h-[75vh]  rounded-lg shadow-lg border-2 border-white"></div>


                                         <!-- モーダル-->
                                        <div id="rouletteModal" class="absolute inset-0 hidden">

                                                <!-- モーダル背景 -->
                                            <div class="absolute inset-0 bg-black bg-opacity-50 rounded-l " onclick="hideRouletteModal()"> </div>
                                                <!-- モーダル背景終章 -->
                                                    
                                                
                                                <!-- モーダルコンテンツ -->
                                                 <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 rounded-2xl p-6 w-80 max-w-[90%] shadow-2xl text-center modal-content" style="z-index: 10;">
                                               
                                            

                                                <!-- モーダルを閉じるボタン -->
                                                <button onclick="hideRouletteModal()" class="absolute top-2 right-2 text-red-600 hover:text-red-800 text-2xl" >
                                                <img src="images/red-delete-button.png" alt="キャンセル">
                                                </button>
                                            
                                                    <h3>ランチルーレット</h3>
                                                    
                                                    <!-- ルーレット表示 -->
                                                    <div id="rouletteArea">

                                                    
                                                        <ul id="rouletteList">
                                                            <li>ラーメン</li>
                                                            <li>うどん</li>
                                                            <li>そば</li>
                                                            <li>パスタ</li>
                                                            <li>牛丼</li>
                                                            <li>親子丼</li>
                                                            <li>かつ丼</li>
                                                            <li>海鮮丼</li>
                                                            <li>寿司</li>
                                                            <li>ハンバーガー</li>
                                                            <li>カレー</li>
                                                            <li>チャーハン</li>
                                                            <li>焼肉</li>
                                                            <li>焼き魚</li>
                                                        
                                                        </ul>
                                                    </div>

                                                        <!-- ルーレットの結果を表示-->
                                                        <div id="RouletteResult" class="hidden">

                                                        </div>
                                                        
                                                                
                                                    </div>
                                                    <!-- モーダルコンテンツ終了 -->
                                           
                                            </div>
                                            <!-- モーダル本体終了 -->
                                        </div>
                
                    <!-- レストラン一覧パネル（右側） -->
                    <div id="restaurantListPanel" class="bg-gradient-to-br from-orange-50 via-pink-50 to-red-50 rounded-xl hidden shadow-2xl border-2 border-orange-200 order-1 lg:order-2 w-full lg:max-w-[350px]  sm:max-h-[69vh] lg:w-[350px] h-[50vh] lg:h-full">
                        <div class="h-full flex flex-col">
                            <div class="p-4 border-b border-orange-200 flex justify-between items-center bg-gradient-to-r from-orange-100 via-pink-100 to-red-100 rounded-t-xl flex-shrink-0">
                                <h3 class="text-lg font-semibold text-orange-800" id="restaurantListTitle">🍽️ 近くのレストラン</h3>
                                <button class="text-orange-500 hover:text-orange-700 text-xl font-bold hover:scale-110 transition-transform" onclick="closeRestaurantList()">✕</button>
                            </div>
                            <div id="restaurantListContent" class="flex-1 overflow-y-auto p-4">
                            </div>
                        </div>
                    </div>
                    
                    <!-- 店舗情報パネル（右側） -->
                    <div id="infoPanel" class="bg-gradient-to-br from-teal-50 via-green-50 to-blue-50 rounded-xl hidden shadow-2xl border-2 border-teal-200 order-1 lg:order-2 w-full lg:max-w-[350px] lg:w-[350px] h-[45vh] lg:h-full">
                        <div class="h-full flex flex-col">
                            <div class="p-4 border-b border-teal-200 flex justify-between items-center bg-gradient-to-r from-teal-100 via-green-100 to-blue-100 rounded-t-xl flex-shrink-0">
                                <h3 class="text-lg font-semibold text-teal-800">🏪 店舗情報</h3>
                                <button id="closePanelBtn" class="text-teal-500 hover:text-teal-700 text-xl font-bold hover:scale-110 transition-transform" onclick="closeInfoPanel()">✕</button>
                            </div>
                            <div id="websiteContent" class="flex-1 overflow-y-auto">
                            </div>
                        </div>
                    </div>
                </div>

                

                     
            <!-- ステータスメッセージ -->
            <div id="status" class="mt-4 p-4 bg-white bg-opacity-90 backdrop-filter blur-sm rounded-lg hidden">
                <p id="statusMessage" class="text-gray-800"></p>
            </div>
        </div>
    </div>

    <!-- スロット表示ボタンエリア -->
                 <div id="slotMachineArea" class="text-center mb-4">
                    <h2 class="text-x1">食べたいものが決まらない...</h2>
                    <div >
                        <button onclick="showRouletteModal(); closeRestaurantList()" class="bg-gradient-to-r from-purple-400 to-purple-500 hover:from-purple-500 hover:to-purple-600 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-lg transform hover:scale-105">今日のランチをランダムに決める</button>
                     </div>
                 </div>

                 
             
                       
                   
                         
                        
                   

                
   
    <script>
        
        // エラーハンドリング
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e);
        });

        // Google Maps関連のエラーをキャッチ
        window.gm_authFailure = function() {
            console.error('Google Maps API認証エラー: APIキーが無効または制限されています');
            showStatus('Google Maps API認証エラー: APIキーが無効です', 'error');
        };
    </script>

    <script>
        // --- 1. グローバル変数の宣言 ---
        let map;
        let marker;
        let currentFilterMode = 'default'; // 現在のフィルターモードを保持
        let placeMarkers = []; // 地図上で複数のマーカーを管理するための配列
        let currentInfoWindow = null; // 現在開いているInfoWindowを保持する変数
        let lastPlaceDetails = null; // 最後に選択された場所の詳細を保存（戻るボタン用）
        let mapInitialized = false; // 地図が初期化されたかどうかを示すフラグ
       
       

        // --- 2. ヘルパー関数の定義 ---

        // 営業時間の状態を取得する関数 (Place オブジェクト対応)
        function getOpeningStatus(regularOpeningHours) {
            if (!regularOpeningHours) return '営業時間情報なし';

            const isOpen = regularOpeningHours.isOpen ? regularOpeningHours.isOpen() : undefined;

            if (isOpen === true) {
                return '<span style="color: #28a745; font-weight: bold;">営業中</span>';
            } else if (isOpen === false) {
                return '<span style="color: #dc3545; font-weight: bold;">閉店中</span>';
            } else {
                if (regularOpeningHours.weekdayDescriptions && regularOpeningHours.weekdayDescriptions.length > 0) {
                    return regularOpeningHours.weekdayDescriptions.join('<br>');
                }
                return '営業時間情報なし';
            }
        }

        // 写真のHTMLを生成する関数 (Place オブジェクト対応)
        function generatePhotosHtml(photos) {
            console.log('写真生成開始:', {
                photosCount: photos ? photos.length : 0,
                photos: photos
            });

            if (!photos || photos.length === 0) {
                console.log('写真がありません');
                return '<div style="text-align: center; padding: 20px; background: #f8f9fa; border-radius: 8px; margin-bottom: 12px;"><span style="color: #6c757d;">写真がありません</span></div>';
            }

            let photoHtml = '<div style="display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 16px;">';
            let validPhotosCount = 0;

            photos.slice(0, 4).forEach((photo, index) => {
                console.log(`写真 ${index + 1}:`, photo);

                let photoUrl = null;
               if(photo && typeof photo.getUrl === 'function'){
                photoUrl = photo.getUrl({maxWidth: 400, maxHeight: 300});
               } else if(photo && photo.name){
                photoUrl = `https://places.googleapis.com/v1/${photo.name}/media?maxWidthPx=400&maxHeightPx=300&key={{$googleMapsApiKey}}`
               } else {
                console.warn('photo object format not recognized:', photo);
               }


                if (photoUrl) {
                    photoHtml += `
                        <div style="position: relative; width: 160px; height: 120px; flex-shrink: 0;">
                            <img src="${photoUrl}"
                                 style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px; border: 1px solid #dee2e6; cursor: pointer; transition: transform 0.2s;"
                                 alt="店舗写真${index + 1}"
                                 onmouseover="this.style.transform='scale(1.05)'"
                                 onmouseout="this.style.transform='scale(1)'"
                                 onerror="
                                     console.error('写真の読み込みに失敗:', '${photoUrl}');
                                     this.parentElement.innerHTML = '<div style=\\'width: 160px; height: 120px; background: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 12px; flex-direction: column;\\'>📷<br>読み込み失敗</div>';
                                 "
                                 onload="console.log('写真読み込み成功:', '${photoUrl}');" />
                        </div>
                    `;
                    validPhotosCount++;
                } else {
                    console.warn('Photo URL が不足:', photo);
                    photoHtml += `
                        <div style="width: 160px; height: 120px; background: #f8f9fa; border-radius: 8px; border: 1px solid #dee2e6; display: flex; align-items: center; justify-content: center; color: #6c757d; font-size: 12px; flex-direction: column; flex-shrink: 0;">
                            📷<br>写真なし
                        </div>
                    `;
                }
            });

            photoHtml += '</div>';
            console.log(`有効な写真数: ${validPhotosCount}`);
            return photoHtml;
        }

        // 距離を計算する関数（ハバーサイン公式）
        function calculateDistance(lat1, lng1, lat2, lng2) {
            const R = 6371; // 地球の半径（km）
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLng = (lng2 - lng1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                Math.sin(dLng / 2) * Math.sin(dLng / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const distance = R * c;
            return Math.round(distance * 1000); // メートル単位で返す
        }

        // 価格レベルを文字列に変換する関数
        function getPriceLevelText(priceLevel) {
            switch (priceLevel) {
                case 0: return '無料';
                case 1: return '￥ (リーズナブル) - 1,000円以下';
                case 2: return '￥￥ (普通) - 1,000円〜3,000円';
                case 3: return '￥￥￥ (高め) - 3,000円〜5,000円';
                case 4: return '￥￥￥￥ (高級) - 5,000円以上';
                default: return '価格情報なし';
            }
        }

        // 星評価のHTMLを生成する関数
        function generateStarRating(rating) {
            if (!rating) return '評価なし';

            const fullStars = Math.floor(rating);
            const hasHalfStar = rating % 1 >= 0.5;
            let starsHtml = '';

            for (let i = 0; i < fullStars; i++) {
                starsHtml += '★';
            }

            if (hasHalfStar) {
                starsHtml += '☆';
            }

            const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
            for (let i = 0; i < emptyStars; i++) {
                starsHtml += '☆';
            }

            return `<span style="color: #ffa500; font-size: 16px;">${rating.toFixed(1)} ${starsHtml}</span>`;
        }

        // 料理ジャンルを日本語に変換する関数
        function getCuisineType(types) {
            const cuisineMap = {
                'restaurant': 'レストラン', 'food': '飲食店', 'meal_takeaway': 'テイクアウト',
                'meal_delivery': 'デリバリー', 'cafe': 'カフェ', 'bakery': 'ベーカリー', 'bar': 'バー',
                'japanese_restaurant': '和食', 'chinese_restaurant': '中華料理', 'italian_restaurant': 'イタリアン',
                'french_restaurant': 'フレンチ', 'korean_restaurant': '韓国料理', 'thai_restaurant': 'タイ料理',
                'indian_restaurant': 'インド料理', 'mexican_restaurant': 'メキシカン', 'american_restaurant': 'アメリカン',
                'pizza': 'ピザ', 'sushi_restaurant': '寿司', 'ramen_restaurant': 'ラーメン',
                'yakiniku_restaurant': '焼肉', 'izakaya': '居酒屋', 'fast_food_restaurant': 'ファストフード',
                'seafood_restaurant': 'シーフード', 'steakhouse': 'ステーキハウス',
                'barbecue_restaurant': 'バーベキュー', 'vegetarian_restaurant': 'ベジタリアン',
                'vegan_restaurant': 'ビーガン'
            };
            if (!types || types.length === 0) return '飲食店';
            const specificTypes = types.filter(type =>
                cuisineMap[type] && !['restaurant', 'food', 'meal_takeaway', 'meal_delivery'].includes(type)
            );
            if (specificTypes.length > 0) { return cuisineMap[specificTypes[0]]; }
            const generalTypes = types.filter(type => cuisineMap[type]);
            return generalTypes.length > 0 ? cuisineMap[generalTypes[0]] : '飲食店';
        }

        // マーカーをクリアする関数
        function clearMarkers() {
            console.log("DEBUG: clearMarkers called");
            console.log("Current marker count before clearing:", placeMarkers.length);
            
            placeMarkers.forEach((marker, index) => {
                if (marker) {
                    try {
                        if (marker.map !== undefined) {
                            marker.map = null;
                        } else if (marker.setMap) {
                            marker.setMap(null);
                        }
                        console.log(`Marker ${index} cleared`);
                    } catch (error) {
                        console.error(`Error clearing marker ${index}:`, error);
                    }
                }
            });
            
            placeMarkers = [];
            console.log("Current marker count after clearing:", placeMarkers.length);
        }

        // カテゴリ別のマーカー色を取得する関数
        function getMarkerColor(filterMode) {
            switch (filterMode) {
                case 'restaurant':
                case 'default':
                    return '#FFAA00';
                case 'cafe':
                    return '#FF5579';
                case 'smoking':
                    return '#89D063';
                default:
                    return '#4285F4';
            }
        }

        // カスタムマーカーを作成する関数
        function createCustomMarker(position, title, color) {
            const markerElement = document.createElement('div');
            markerElement.style.cssText = `
                width: 24px;
                height: 24px;
                background-color: ${color};
                border: 2px solid white;
                border-radius: 50%;
                box-shadow: 0 2px 4px rgba(0,0,0,0.3);
                cursor: pointer;
                position: relative;
            `;
            
            const innerDot = document.createElement('div');
            innerDot.style.cssText = `
                width: 8px;
                height: 8px;
                background-color: white;
                border-radius: 50%;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            `;
            markerElement.appendChild(innerDot);
            
            return markerElement;
        }

        // レストラン一覧をクリアする関数（修正版）
        function clearRestaurantList() {
            const restaurantListContent = document.getElementById('restaurantListContent');
            if (restaurantListContent) { 
                restaurantListContent.innerHTML = ''; 
            }
            const restaurantListPanel = document.getElementById('restaurantListPanel');
            if (restaurantListPanel) {
                restaurantListPanel.classList.add('hidden');
            }
        }

        // レストラン一覧パネルを閉じる関数（修正版）
        function closeRestaurantList() {
            const restaurantListPanel = document.getElementById('restaurantListPanel');
            if (restaurantListPanel) {
                restaurantListPanel.classList.add('hidden');
            }

           
        }

        // パネルを表示する関数（修正版）
        function showInfoPanel() {
            const infoPanel = document.getElementById('infoPanel');
            if (infoPanel) {
                infoPanel.classList.remove('hidden');
            }
        }

        // パネルを非表示にする関数（修正版）
        function closeInfoPanel() {
            const infoPanel = document.getElementById('infoPanel');
            if (infoPanel) {
                infoPanel.classList.add('hidden');
            }
        }

        // ステータスメッセージを表示する関数
        function showStatus(message, type) {
            const statusDiv = document.getElementById('status');
            const statusMessage = document.getElementById('statusMessage');
            statusMessage.textContent = message;
            statusDiv.classList.remove('hidden');
            setTimeout(() => { statusDiv.classList.add('hidden'); }, 3000);
        }

        // マーカーをハイライトする関数
        function highlightMarker(placeId) {
            placeMarkers.forEach(marker => {
                if (marker.placeId === placeId) {
                    const markerElement = marker.content;
                    if (markerElement) {
                        markerElement.style.transform = 'scale(1.3)';
                        markerElement.style.zIndex = '1000';
                        markerElement.style.boxShadow = '0 4px 12px rgba(0,0,0,0.5)';
                        
                        const position = marker.position;
                        if (position) {
                            map.panTo(position);
                        }
                    }
                    console.log('Highlighting marker:', placeId);
                }
            });
        }

        // マーカーのハイライトを解除する関数
        function unhighlightMarker(placeId) {
            placeMarkers.forEach(marker => {
                if (marker.placeId === placeId) {
                    const markerElement = marker.content;
                    if (markerElement) {
                        markerElement.style.transform = 'scale(1)';
                        markerElement.style.zIndex = '1';
                        markerElement.style.boxShadow = '0 2px 4px rgba(0,0,0,0.3)';
                    }
                    console.log('Unhighlighting marker:', placeId);
                }
            });
        }

        // リストアイテムをクリックした時にマーカーを強調表示する関数
        function selectMarkerFromList(placeId) {
            placeMarkers.forEach(marker => {
                if (marker.placeId === placeId) {
                    const position = marker.position;
                    if (position) {
                        map.setCenter(position);
                        map.setZoom(17);
                    }
                    
                    google.maps.event.trigger(marker, 'click');
                }
            });
        }

        // ルートを開く関数 (Place オブジェクト対応)
        function openRoute(lat, lng, placeName) {
            if (currentLocation) {
                const routeUrl = `https://www.google.com/maps/dir/?api=1&origin=${currentLocation.lat},${currentLocation.lng}/${lat},${lng}/data=!3m1!4b1!4m2!4m1!3e0?travelmode=driving`;
                window.open(routeUrl, '_blank');
            } else {
                const routeUrl = `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(placeName)}&query_place_id=${lat},${lng}`;
                window.open(routeUrl, '_blank');
            }
        }

        // レストラン一覧から公式サイトを表示する関数 (Place オブジェクト対応)
        function showWebsiteFromList(websiteUrl, placeName) {
            console.log('公式サイト表示:', websiteUrl, placeName);
            closeRestaurantList();
            showInfoPanel();
            loadWebsiteInPanel(websiteUrl, placeName);
        }

        // 右側パネルに店舗情報を表示する関数 (Place オブジェクト対応)
        function displayRestaurantInfo(status, placeName, place = null) {
            const websiteContent = document.getElementById('websiteContent');
            showInfoPanel();

            if (status === 'loading') {
                websiteContent.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full p-4">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mb-4"></div>
                        <p class="text-black text-center">${placeName}の情報を読み込み中...</p>
                    </div>
                `;
                return;
            }

            if (status === 'error') {
                websiteContent.innerHTML = `
                    <div class="flex flex-col items-center justify-center h-full text-center">
                        <div class="text-red-500 text-4xl mb-4">⚠️</div>
                        <h3 class="font-semibold mb-2">${placeName}</h3>
                        <p class="text-red-600 mb-4">情報の取得に失敗しました</p>
                        <p class="text-sm text-gray-500">しばらく時間をおいて再度お試しください</p>
                    </div>
                `;
                return;
            }

            if (status === 'success' && place) {
                let infoHtml = `
                    <div class="h-full overflow-y-auto p-4">
                        ${generatePhotosHtml(place.photos)}
                        <div class="mb-6">
                            <h3 class="text-lg font-bold mb-3 text-gray-800 dark:text-gray-600">${place.displayName || placeName}</h3>
                            <div class="space-y-2 text-sm">
                                <div class="flex items-center">
                                    <span class="text-yellow-500 mr-2">${generateStarRating(place.rating)}</span>
                                    ${place.userRatingCount ? `<span class="text-gray-500">(${place.userRatingCount}件)</span>` : ''}
                                </div>
                                <div class="text-green-600 font-medium">
                                    ${getPriceLevelText(place.priceLevel)}
                                </div>
                                <div>
                                    ${getOpeningStatus(place.regularOpeningHours)}
                                </div>
                                ${place.formattedAddress ? `
                                    <div class="flex items-start">
                                        <span class="mr-2">📍</span>
                                        <span class="text-gray-600 dark:text-gray-400">${place.formattedAddress}</span>
                                    </div>
                                ` : ''}
                                ${place.internationalPhoneNumber ? `
                                    <div class="flex items-center">
                                        <span class="mr-2">📞</span>
                                        <a href="tel:${place.internationalPhoneNumber}" class="text-blue-600 hover:underline">${place.internationalPhoneNumber}</a>
                                    </div>
                                ` : ''}
                            </div>
                        </div>
                        <div class="mb-6 space-y-2">
                            <a href="${place.googleMapsURI || `https://www.google.com/maps/search/?api=1&query=${encodeURIComponent(place.displayName || placeName)}&query_place_id=${place.id}`}" target="_blank"
                               class="block w-full bg-blue-500 hover:bg-blue-600 text-white text-center py-2 px-4 rounded text-sm font-medium">
                                Googleマップで開く
                            </a>
                            ${place.websiteURI ? `
                                <button onclick="loadWebsiteInPanel('${place.websiteURI}', '${place.displayName || placeName}')"
                                        class="block w-full bg-green-500 hover:bg-green-600 text-white text-center py-2 px-4 rounded text-sm font-medium">
                                    公式サイトを表示
                                </button>
                            ` : `
                                <div class="block w-full bg-gray-300 text-gray-500 text-center py-2 px-4 rounded text-sm">
                                    公式サイト情報なし
                                </div>
                            `}
                        </div>
                        ${place.reviews && place.reviews.length > 0 ? `
                            <div class="border-t pt-4">
                                <h4 class="font-semibold mb-3 text-gray-800 dark:text-gray-600">最新のレビュー</h4>
                                <div class="bg-gray-50 dark:bg-gray-600 p-3 rounded">
                                    <div class="font-medium text-sm mb-1 text-white">${place.reviews[0].author_name}</div>
                                    <div class="text-yellow-500 text-sm mb-2">${generateStarRating(place.reviews[0].rating)}</div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300">${place.reviews[0].text.length > 150 ? place.reviews[0].text.substring(0, 150) + '...' : place.reviews[0].text}</p>
                                </div>
                            </div>
                        ` : ''}
                    </div>
                `;
                websiteContent.innerHTML = infoHtml;
            }
            console.log('Place displayName:', place.displayName);
            console.log('PlaceName:', placeName);
        }

        // 公式サイトをパネル内に読み込む関数
        function loadWebsiteInPanel(websiteUrl, placeName) {
            const websiteContent = document.getElementById('websiteContent');
            websiteContent.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full p-4">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-green-500 mb-4"></div>
                    <p class="text-gray-600 text-center">${placeName}の公式サイトを読み込み中...</p>
                </div>
            `;

            setTimeout(() => {
                const iframeId = `iframe-${Date.now()}`;
                websiteContent.innerHTML = `
                    <div class="h-full flex flex-col">
                        <div class="flex items-center justify-between p-3 bg-gray-200 dark:bg-gray-600 rounded-t border-b">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium truncate">${placeName}</span>
                                <span class="text-xs text-gray-500">公式サイト</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <button onclick="window.open('${websiteUrl}', '_blank')"
                                        class="text-blue-600 hover:text-blue-800 text-xs underline"
                                        title="新しいタブで開く">
                                    新しいタブで開く
                                </button>
                                <button onclick="displayRestaurantInfo('success', '${placeName}', lastPlaceDetails)"
                                        class="text-gray-500 hover:text-gray-700 text-sm px-2 py-1 rounded hover:bg-gray-300">
                                    ← 戻る
                                </button>
                            </div>
                        </div>
                        <div class="flex-1 relative">
                            <iframe id="${iframeId}"
                                    src="${websiteUrl}"
                                    class="w-full h-full border-0"
                                    sandbox="allow-scripts allow-same-origin allow-forms allow-popups allow-popups-to-escape-sandbox"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    loading="lazy">
                            </iframe>
                            <div id="error-${iframeId}" class="hidden absolute inset-0 flex flex-col items-center justify-center bg-gray-50 dark:bg-gray-700 p-6 text-center">
                                <div class="text-red-500 text-4xl mb-4">🚫</div>
                                <h3 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-200">サイトの表示に失敗しました</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    このサイトはフレーム内での表示を許可していません。<br>
                                    下のボタンから新しいタブで開いてください。
                                </p>
                                <div class="space-y-2">
                                    <button onclick="window.open('${websiteUrl}', '_blank')"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium">
                                        新しいタブで開く
                                    </button>
                                    <button onclick="displayRestaurantInfo('success', '${placeName}', lastPlaceDetails)"
                                            class="block bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded text-sm font-medium">
                                        店舗情報に戻る
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                const iframe = document.getElementById(iframeId);
                const errorDiv = document.getElementById(`error-${iframeId}`);

                const timeoutId = setTimeout(() => {
                    if (iframe && errorDiv) {
                        iframe.style.display = 'none';
                        errorDiv.classList.remove('hidden');
                    }
                }, 5000);

                iframe.onload = function() {
                    clearTimeout(timeoutId);
                    try {
                        iframe.contentDocument;
                    } catch (e) {
                        iframe.style.display = 'none';
                        errorDiv.classList.remove('hidden');
                    }
                };

                iframe.onerror = function() {
                    clearTimeout(timeoutId);
                    iframe.style.display = 'none';
                    errorDiv.classList.remove('hidden');
                };

            }, 500);
        }

        // --- 3. 主要なロジックを担う関数の定義 ---

        // Google Maps初期化
        async function initMap() {
            try {
                const defaultLocation =  {lat: 35.6658, lng:139.7589}; //新橋

                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: defaultLocation,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    scrollwheel: true,
                    gestureHandling: 'greedy',
                    mapId: 'ae5de99ca8083dbe3f3b309'
                });

                // AdvancedMarkerElementを使用
                const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
                marker = new AdvancedMarkerElement({
                    position: defaultLocation,
                    map: map,
                    title: "現在地"
                });

                // 地図が初期化されたことを示すフラグを立てる
                mapInitialized = true; 

                showStatus("地図が読み込まれました。", "success");
                
            } catch (error) {
                console.error('Map initialization error:', error);
                showStatus('地図の初期化に失敗しました: ' + error.message, 'error');
            }
        }

        // 現在地を取得する関数（修正版：レストラン検索を削除）
        function getCurrentLocation() {
            // 地図が初期化されているか確認
            if (!mapInitialized) {
                showStatus("地図の読み込みが完了していません。しばらくお待ちください。", "info");
                return;
            }

            if (navigator.geolocation) {
                showStatus("現在地を取得中...", "info");
                
                navigator.geolocation.getCurrentPosition(
                    function(position) {

                       const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        
                        
                        currentLocation = { lat: lat, lng: lng };
                        map.setCenter(currentLocation);
                        map.setZoom(16);
                        marker.position = currentLocation;

                        displayLocationInfo(lat, lng);
                        sendLocationToServer(lat, lng);
                        
                        showStatus("現在地を取得しました！", "success");
                    },
                    function(error) {
                        let errorMessage = "現在地の取得に失敗しました: ";
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += "位置情報の使用が拒否されました。";
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += "位置情報が利用できません。";
                                break;
                            case error.TIMEOUT:
                                errorMessage += "位置情報の取得がタイムアウトしました。";
                                break;
                            default:
                                errorMessage += "不明なエラーが発生しました。";
                                break;
                        }
                        showStatus(errorMessage, "error");
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                showStatus("このブラウザは位置情報をサポートしていません。", "error");
            }
        }

        // 現在地情報を表示する関数
        function displayLocationInfo(lat, lng) {
            document.getElementById('coordinates').textContent =
                `緯度: ${lat.toFixed(6)}, 経度: ${lng.toFixed(6)}`;
            document.getElementById('locationInfo').classList.remove('hidden');
        }

        // サーバーに位置情報を送信する関数（テスト用）
        function sendLocationToServer(lat, lng) {
            fetch('{{ route("dashboard.location") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    latitude: lat,
                    longitude: lng
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('サーバーレスポンス:', data);
            })
            .catch(error => {
                console.error('エラー:', error);
            });
        }

        // カテゴリ別にフィルタリングする関数
        function searchNearbyByType(placeType) {
            if(!mapInitialized){
                showStatus("地図の読み込みが完了していません。しばらくお待ちください", "info");
                return;
            }
            if(navigator.geolocation){
                showStatus("現在地を取得中...", "info");

                navigator.geolocation.getCurrentPosition(
                    function(position){
                        clearMarkers();
                        clearRestaurantList();

                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        

                        currentLocation = {lat: lat, lng: lng};
                        map.setCenter(currentLocation);
                        map.setZoom(16);
                        marker.position = currentLocation;

                        fetchNearbyPlacesByType(lat, lng, placeType);
                    },
                    function(error){
                        showStatus('現在地の取得に失敗しました: ' + error.message ,'error');
                    }
                );
            }else{
                showStatus("このブラウザは位置情報をサポートしていません。", "error");
            }
        }

        // タイプ別で取得した情報をリストと地図に追加（Place.searchByText 対応版）
        async function fetchNearbyPlacesByType(lat, lng, placeType) {
            const { Place } = await google.maps.importLibrary("places");
            const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");

            const request = {
                textQuery: '',
                fields: ['displayName', 'location', 'photos', 'businessStatus', 'rating', 'userRatingCount', 'priceLevel', 'types'],
                locationBias: { center: { lat: lat, lng: lng }, radius: 800 },
                isOpenNow: true,
                language: 'ja',
                maxResultCount: 20,
                minRating: 3.5,
                region: 'jp',
            };

            if (placeType === 'cafe') {
                request.textQuery = 'カフェ';
               
            } else if (placeType === 'restaurant') {
                request.textQuery = 'レストラン';
               
            } else if (placeType === 'smoking') {
                request.textQuery = '喫煙所';
            } else {
                request.textQuery = placeType;
            }

            try {
                console.log('DEBUG: searchByText request:', request);
                const { places } = await Place.searchByText(request);
                console.log('DEBUG: searchByText response places:', places);

                if (places && places.length > 0) {
                    clearMarkers();
                    clearRestaurantList();

                    displayRestaurantsOnMap(places);
                    showStatus(`近くの${request.textQuery}を取得しました`, "success");
                } else {
                    console.log('No Results found for:', request.textQuery);
                    showStatus(`近くの${request.textQuery}が見つかりません`, "info");
                }
            } catch (error) {
                console.error('Places API searchByText Error:', error);
                showStatus(`近くの${request.textQuery}の取得に失敗しました。エラー: ${error.message}`, "error");
            }
        }

        // フィルター表示名を取得するヘルパー関数を追加
        function getFilterDisplayName(placeType) {
             switch(placeType) {
                 case 'cafe': return 'カフェ';
                 case 'restaurant': return 'レストラン';
                 case 'smoking': return '喫煙所';
                default: return placeType;
                }
            }

        // 自動で喫煙可のキーワードで検索（Place.searchByText 対応版）
        async function searchNearbyByKeyword(keyword) {
            if(!mapInitialized){
                showStatus("地図の読み込みが完了していません。しばらくお待ちください", "info");
                return;
            }

            if (navigator.geolocation) {
                showStatus("現在地を取得中...", "info");

                navigator.geolocation.getCurrentPosition(
                    async function(position) {
                        clearMarkers();
                        clearRestaurantList();

                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        
                        currentLocation = { lat: lat, lng: lng };
                        map.setCenter(currentLocation);
                        map.setZoom(16);
                        marker.position = currentLocation;

                        const { Place } = await google.maps.importLibrary("places");
                        const request = {
                            textQuery: keyword,
                            fields: ['displayName', 'location', 'photos', 'businessStatus', 'rating', 'userRatingCount', 'priceLevel', 'types'],
                            locationBias: { center: { lat: lat, lng: lng }, radius: 800 },
                            isOpenNow: true,
                            language: 'ja',
                            maxResultCount: 20,
                            minRating: 3.5,
                            region: 'jp',
                        };

                        try {
                            const { places } = await Place.searchByText(request);
                            if (places && places.length > 0) {
                                displayRestaurantsOnMap(places);
                                showStatus("喫煙可能な場所を取得しました！", "success");
                            } else {
                                showStatus("喫煙可能な場所が見つかりませんでした。", "info");
                            }
                        } catch (error) {
                            console.error('Places API searchByText (keyword) Error:', error);
                            showStatus("喫煙可能な場所の取得に失敗しました。", "error");
                        }
                    },
                    function(error) {
                        showStatus('現在地の取得に失敗しました: ' + error.message, 'error');
                    }
                );
            } else {
                showStatus("このブラウザは位置情報をサポートしていません。", "error");
            }
        }

        // レストランの料理ジャンルを取得する関数 (Place オブジェクト対応)
        async function displayRestaurantsOnMap(places) {
            const { AdvancedMarkerElement} = await google.maps.importLibrary("marker");
            const {LatLngBounds} = await google.maps.importLibrary("core");
            const bounds = new google.maps.LatLngBounds();

            places = places.filter(place => {
                let isFoodRelated = true;
                if (currentFilterMode === 'default' || currentFilterMode === 'smoking') {
                    isFoodRelated = place.types && place.types.some(type =>
                        ['restaurant', 'cafe', 'meal_takeaway', 'food', 'bakery', 'bar', 'meal_delivery'].includes(type)
                    );
                } else if (currentFilterMode === 'cafe') {
                    isFoodRelated = place.types && place.types.some(type =>
                        ['cafe', 'bakery','coffee_shop'].includes(type)
                    );
                }

                let hasValidRating = true;
                if (currentFilterMode === 'default' || currentFilterMode === 'food') {
                    hasValidRating = place.rating && place.rating >= 3.8;
                } else if (currentFilterMode === 'cafe') {
                    hasValidRating = place.rating && place.rating >= 3.5;
                } else if (currentFilterMode === 'smoking') {
                    hasValidRating = place.rating ? place.rating >= 3.0 : true;
                }

                const isOpenNow = currentFilterMode === 'open_now'
                    ? place.regularOpeningHours?.isOpen() === true
                    : true;
                
                console.log('Place filter check:', {
                    name: place.displayName,
                    types: place.types,
                    rating: place.rating,
                    hasValidRating,
                    isFoodRelated,
                    currentFilterMode,
                    isOpenNow
                });
                
                return hasValidRating && isFoodRelated && isOpenNow;
            });
            
            console.log(`フィルタリング後の場所数: ${places.length}`);

            // 現在地からの距離を計算して追加
            if (currentLocation) {
                places.forEach(place => {
                    const loc = place.location;

                    let latValue = null;
                    let lngValue = null;

                    

                    if (loc) {
                        if (typeof loc.lat === 'function' && typeof loc.lng === 'function') {
                            latValue = loc.lat();
                            lngValue = loc.lng();
                        } else if (typeof loc.lat === 'number' && typeof loc.lng === 'number') {
                            latValue = loc.lat;
                            lngValue = loc.lng;
                        }
                    }

                    if (typeof latValue === 'number' && typeof lngValue === 'number') {
                        place.distance = calculateDistance(
                            currentLocation.lat, currentLocation.lng, latValue, lngValue
                        );
                        bounds.extend({lat: latValue, lng:lngValue});
                    } else {
                        console.warn('Place missing valid location (or unexpected format):', place);
                        place.distance = Infinity;
                    }
                });

                places.sort((a, b) => (a.distance || Infinity) - (b.distance || Infinity));
            }

            
                places = places.filter(place => place.distance <= 1000);
                console.log('1km以内のフィルタリング:${places.length}県')
            

            // レストラン一覧を表示
            displayRestaurantList(places);

            places.forEach(place => {
                const loc = place.location;

                let latValue = null;
                let lngValue = null;

                if (loc) {
                    if (typeof loc.lat === 'function' && typeof loc.lng === 'function') {
                        latValue = loc.lat();
                        lngValue = loc.lng();
                    } else if (typeof loc.lat === 'number' && typeof loc.lng === 'number') {
                        latValue = loc.lat;
                        lngValue = loc.lng;
                    }
                }

                if (typeof latValue !== 'number' || typeof lngValue !== 'number') {
                    console.warn('Invalid location for place (or unexpected format) in marker creation:', place);
                    return;
                }

                const position = { lat: latValue, lng: lngValue };
                
                // カテゴリ別の色を取得
                const markerColor = getMarkerColor(currentFilterMode);
                
                // カスタムマーカー要素を作成
                const customMarkerElement = createCustomMarker(position, place.displayName, markerColor);
                
                const marker = new AdvancedMarkerElement({
                    map: map,
                    position: position,
                    title: place.displayName,
                    content: customMarkerElement
                });
                
                marker.placeId = place.id;
                const cuisineType = getCuisineType(place.types);
                const priceText = getPriceLevelText(place.priceLevel);
                const rating = place.rating ? place.rating.toFixed(1) : '評価なし';

                const quickInfoContent = `
                    <div style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; min-width: 200px; padding: 8px;">
                        <div style="font-weight: bold; font-size: 14px; margin-bottom: 6px; color: #333;">
                            ${place.displayName}
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 4px; font-size: 12px;">
                            <div style="display: flex; align-items: center;">
                                <span style="color: #666; margin-right: 6px;">🍽️</span>
                                <span style="color: #444; font-weight: 500;">${cuisineType}</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span style="color: #666; margin-right: 6px;">💰</span>
                                <span style="color: #28a745; font-weight: 500;">${priceText}</span>
                            </div>
                            <div style="display: flex; align-items: center;">
                                <span style="color: #666; margin-right: 6px;">⭐</span>
                                <span style="color: #ffa500; font-weight: 500;">${rating}</span>
                            </div>
                        </div>
                        <div style="margin-top: 8px; padding-top: 6px; border-top: 1px solid #eee; font-size: 11px; color: #666; text-align: center;">
                            クリックで詳細情報を表示
                        </div>
                    </div>
                `;

                const quickInfoWindow = new google.maps.InfoWindow({
                    content: quickInfoContent
                });

                marker.addListener('mouseover', function() {
                    if (currentInfoWindow && currentInfoWindow !== quickInfoWindow) {
                        currentInfoWindow.close();
                    }
                    quickInfoWindow.open(map, marker);
                });

                marker.addListener('mouseout', function() {
                    setTimeout(() => {
                        quickInfoWindow.close();
                    }, 100);
                });

                marker.addListener('click', function() {
                    if (currentInfoWindow) {
                        currentInfoWindow.close();
                    }
                    quickInfoWindow.close();
                    displayRestaurantInfo('loading', place.displayName);
                    selectRestaurantFromList(place.id, place.displayName);
                });

                placeMarkers.push(marker);
                bounds.extend(position);
            });
        }

        // レストランの詳細情報を取得する関数 (Place オブジェクト対応)
        async function getRestaurantDetails(place) {
            if (!place.id) {
                console.warn('Cannot fetch details: missing place ID', place);
                return place;
            }

            try {
                await place.fetchFields({
                    fields: [
                        'formattedAddress', 'internationalPhoneNumber', 'websiteURI', 'googleMapsURI',
                        'regularOpeningHours', 'reviews', 'photos'
                    ]
                });
                return place;

            } catch (error) {
                console.error('Failed to fetch place details for:', place.id, error);
                return place;
            }
        }

        // レストラン一覧から選択された店舗の詳細を表示 (Place オブジェクト対応)
        async function selectRestaurantFromList(placeId, placeName) {
            closeRestaurantList();
            displayRestaurantInfo('loading', placeName);

            const { Place } = await google.maps.importLibrary("places");
            const place = new Place({ id: placeId });
            
            try {
                await place.fetchFields({
                    fields: [
                        'displayName', 'formattedAddress', 'internationalPhoneNumber', 'websiteURI', 'googleMapsURI',
                        'rating', 'userRatingCount', 'priceLevel', 'regularOpeningHours', 'photos', 'reviews',
                         'types', 'location', 'businessStatus'
                    ]
                });

                lastPlaceDetails = place;
                displayRestaurantInfo('success', place.displayName || placeName, place);

            } catch (error) {
                console.warn('Place detailsの取得に失敗:', error);
                displayRestaurantInfo('error', placeName, null);
                showStatus("場所の詳細情報の取得に失敗しました。", "error");
            }
        }

        // レストラン一覧を表示する関数（修正版）
        function displayRestaurantList(places) {
            const restaurantListPanel = document.getElementById('restaurantListPanel');
            const restaurantListContent = document.getElementById('restaurantListContent');
            const restaurantListTitle = document.getElementById('restaurantListTitle');

          
            

            let title = '🍽️ 近くのレストラン';
            if (currentFilterMode === 'cafe') {
                title = '☕ 近くのカフェ';
            } else if (currentFilterMode === 'smoking') {
                title = '🚬 喫煙可能な場所';
            } else if(currentFilterMode === 'food'){
                title = '近くのお店'
            }
            restaurantListTitle.textContent = title;

            // パネルを表示（width調整は削除）
            restaurantListPanel.classList.remove('hidden');

            if (places.length === 0) {
                restaurantListContent.innerHTML = `
                    <div class="text-center py-8">
                        <div class="text-gray-500 text-4xl mb-4">🍽️</div>
                        <p class="text-gray-600">近くに${title}が見つかりませんでした</p>
                    </div>
                `;
                return;
            }

            restaurantListContent.innerHTML = '<div class="text-center py-4">情報読み込み中...</div>';

            Promise.all(places.map(place => getRestaurantDetails(place)))
                .then(detailedPlaces => {
                    let listHtml = '';
                    detailedPlaces.forEach((place, index) => {
                        if (!place) return;

                        const cuisineType = getCuisineType(place.types);
                        const priceText = getPriceLevelText(place.priceLevel);
                        const rating = place.rating ? place.rating.toFixed(1) : '評価なし';
                        const distance = place.distance ?
                            (place.distance < 1000 ? `${place.distance}m` : `${(place.distance / 1000).toFixed(1)}km`) :
                            '距離不明';

                        const latestReview = (place.reviews && Array.isArray(place.reviews) && place.reviews.length > 0) ?
                            place.reviews[0] : null;

                        let lat = null;
                        let lng = null;

                        if (place.location) {
                            if (typeof place.location.lat === 'function') {
                                lat = place.location.lat();
                                lng = place.location.lng();
                            } else if (typeof place.location.lat === 'number') {
                                lat = place.location.lat;
                                lng = place.location.lng;
                            }
                        }

                        //写真をリストに追加する方法
                        let photoUrl = null;
                        if(place.photos && place.photos.length > 0){
                            try{
                               const photoResourceName = place.photos[0].name;
                               if(photoResourceName){
                                photoUrl = `https://places.googleapis.com/v1/${photoResourceName}/media?maxHeightPx=200&key={{$googleMapsApiKey}}`;
                                console.log('新しい写真URL',photoUrl);
                               }
                            }catch(error){
                                console.warn('写真取得エラー:',error);
                            }
                                    
                                }
                
                        

                        listHtml += `
                            <div class="bg-white rounded-lg p-4 mb-3 shadow-sm border border-gray-200 hover:shadow-md transition-shadow cursor-pointer"
                                    onmouseenter="highlightMarker('${place.id}')"
                                    onmouseleave="unhighlightMarker('${place.id}')"
                                    onclick="selectMarkerFromList('${place.id}')">

                                ${photoUrl ? `<div class="mb-3">
                                ${place.websiteURI ? 
                                        `<img src="${photoUrl}" 
                                         alt="${place.displayName}" 
                                         class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity" 
                                         onclick="showWebsiteFromList('${place.websiteURI.replace(/'/g, "\\'")}', '${place.displayName.replace(/'/g, "\\'")}'); event.stopPropagation();"
                                         title="クリックで公式サイトを表示"
                                         onerror="this.parentElement.innerHTML='<div class=\\'w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500\\'>📷写真読み込み失敗</div>'">` 
                                         : 
                                        `<img src="${photoUrl}" 
                                         alt="${place.displayName}" 
                                         class="w-full h-32 object-cover rounded-lg cursor-not-allowed opacity-70" 
                                         title="公式サイト情報なし"
                                         onerror="this.parentElement.innerHTML='<div class=\\'w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500\\'>📷写真読み込み失敗</div>'">` 
                                         }
                                                </div>` : `
                                        <div class="mb-3">
                                        <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                                         📷写真なし
                                        </div>
                                        </div>`}



                           

                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-semibold text-gray-800 text-sm leading-tight">${place.displayName}</h4>
                                    <span class="text-lg font-bold text-blue-600 ml-2 flex-shrink-0">${distance}</span>
                                </div>

                                <div class="space-y-1 text-xs mb-3">
                                    <div class="flex items-center">
                                        <span class="mr-2">🍽️</span>
                                        <span class="text-gray-600">${cuisineType}</span>
                                    </div>

                                    <div class="flex items-center">
                                        <span class="mr-2">💰</span>
                                        <span class="text-green-600 font-medium">${priceText}</span>
                                    </div>

                                    <div class="flex items-center">
                                        <span class="mr-2">⭐</span>
                                        <span class="text-yellow-600">${rating}</span>
                                    </div>
                                </div>

                                ${latestReview ? `
                                    <div class="bg-gray-50 p-2 rounded text-xs mb-3">
                                        <div class="font-medium text-gray-700 mb-1">💬 最新の口コミ</div>
                                        <div class="text-gray-600 leading-relaxed">
                                           
                                            "${(latestReview.text && typeof latestReview.text === 'string' && latestReview.text.length > 80) ? latestReview.text.substring(0, 80) + '...' : (latestReview.text || '')}"
                                        </div>
                                        <div class="text-gray-500 mt-1">- ${latestReview.author_name}</div>
                                    </div>
                                ` : ''}

                                <div class="flex gap-2">
                                    ${place.websiteURI ? `
                                        <button onclick="showWebsiteFromList('${place.websiteURI.replace(/'/g, "\\'")}', '${place.displayName.replace(/'/g, "\\'")}'); return false;"
                                                    class="flex-1 bg-green-500 hover:bg-green-600 text-white text-xs py-2 px-3 rounded font-medium">
                                            🌐 公式サイト
                                        </button>
                                    ` : `
                                        <button class="flex-1 bg-gray-300 text-gray-500 text-xs py-2 px-3 rounded cursor-not-allowed">
                                            🌐 サイトなし
                                        </button>
                                    `}

                                    <button onclick="openRoute(${lat}, ${lng}, '${place.displayName.replace(/'/g, "\\'")}'); return false;"
                                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white text-xs py-2 px-3 rounded font-medium">
                                        🗺️ ルート
                                    </button>
                                </div>
                            </div>
                        `;
                    });

                    restaurantListContent.innerHTML = listHtml;
                })
                .catch(error => {
                    console.error('場所詳細情報の取得に失敗:', error);
                    restaurantListContent.innerHTML = `
                        <div class="text-center py-8">
                            <div class="text-red-500 text-4xl mb-4">⚠️</div>
                            <p class="text-red-600">場所情報の読み込みに失敗しました</p>
                        </div>
                    `;
                });
        }

        // --- 4. ページの初期化とイベントリスナーの設定 ---
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('getCurrentLocationBtn').addEventListener('click', function() {
                getCurrentLocation();
            });

            document.getElementById('btn-cafe').addEventListener('click', () => {
                currentFilterMode = 'cafe';
                searchNearbyByType('cafe');
            });

            document.getElementById('btn-smoking').addEventListener('click', () => {
                currentFilterMode = 'smoking';
                searchNearbyByKeyword('喫煙可 喫煙所 smoking area');
            });

            document.getElementById('btn-restaurant').addEventListener('click', () =>{
                currentFilterMode = 'restaurant';
                searchNearbyByType('restaurant');
            });

            document.querySelector('#query').closest('div').querySelector('button[type="submit"]').addEventListener('click', () => {
                const queryText = document.getElementById('query').value;
                if (queryText) {
                    currentFilterMode = 'custom_search';
                    searchNearbyByKeyword(queryText);
                }
            });
        });
    </script>

    <!-- Google Maps API読み込み -->
    <script async defer 
            src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&libraries=places,maps,marker,core&callback=initMap"
            onerror="showStatus('Google Maps APIスクリプトの読み込みに失敗しました', 'error')">
    </script>

        <!-- スロットマシーン部分 -->
         <script>
             const foods = ['ラーメン','うどん','そば','パスタ','牛丼','親子丼','かつ丼','海鮮丼','寿司','ハンバーガー','カレー','チャーハン','焼肉','焼き魚']
            

            function foodSlot(){
               
                let foodRoulette = Math.floor(Math.random()*foods.length);
                let selectedFood = foods[foodRoulette];

             
                return selectedFood;

            }

            //モーダル表示
            function showRouletteModal(){
                document.getElementById('rouletteModal').classList.remove('hidden');
                initRoulette();
                // 0.3秒だけ待つ（モーダル表示のアニメーション用）
                setTimeout(() => {
                     startRoulette();
                    }, 300);
                
            }
            //モーダル非表示
            function hideRouletteModal(){
                document.getElementById('rouletteModal').classList.add('hidden');
                 document.getElementById('RouletteResult').classList.add('hidden');
            }

            //ルーレットの初期化
            function initRoulette(){
                const ul = document.querySelector('#rouletteArea ul');
                ul.innerHTML = '';

            //五回繰り返して滑らかな動きに
            for(let i = 0; i<5; i++){
                foods.forEach(food => {
                    const li = document.createElement('li');
                    li.textContent = food;
                    ul.appendChild(li);
                })
            }

            }

            //ルーレット開始
            function startRoulette(){
                const rouletteArea = document.getElementById('rouletteArea');
                const ul = document.querySelector('#rouletteArea ul');

                rouletteArea.classList.add('active');
                //三秒後に停止
               setTimeout(() => {
                rouletteArea.classList.remove('active');
                const randomIndex = Math.floor(Math.random() * foods.length);
                const selectedFood = foods[randomIndex];
                 ul.style.transform = `translateY(-${(randomIndex + foods.length * 2) * 60}px)`

                 //0.5秒後に結果表示
                 setTimeout(() => {
               
                document.getElementById('RouletteResult').classList.remove('hidden');
                document.getElementById('RouletteResult').innerHTML = 
                `<div class="animate-bounce-in">
                <div class="text-lg font-bold text-gray-700">今日のランチは</div>
                 <div class="text-2xl font-bold bg-gradient-to-r from-red-500 to-orange-500 bg-clip-text text-transparent mb-2">${selectedFood}</div>
                 <div class="text-lg font-bold text-gray-700  mb-6">にしませんか?</div>
                 <div class="flex flex-col sm:flex-row justify-center gap-3 mt-4">
                 <button onclick="executeSearch('${selectedFood}')" 
                 class="bg-gradient-to-r from-orange-400 to-red-400 hover:from-orange-500 hover:to-red-500 text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 shadow-lg transform hover:scale-105 hover:shadow-xl whitespace-nowrap text-sm roulette-button">
                 このお店を探す!</button> 
                 <button onclick="hideRouletteResult(); startRoulette();closeRestaurantList()" 
                 class="bg-gradient-to-r from-gray-100 to-gray-200 hover:from-teal-100 hover:to-teal-200 text-gray-700 hover:text-teal-700 font-bold mx-2 py-3 px-6 rounded-xl shadow-lg transform hover:scale-105 transition-all duration-300 border border-gray-300 hover:border-teal-300 whitespace-nowrap text-sm roulette-button">気分じゃない</button>
                 </div>`;
               },500) ;
            }, 3000);
            }

            //ルーレット結果を非表示
            function hideRouletteResult(){
                document.getElementById('RouletteResult').classList.add('hidden');
                initRoulette();
            }

            //検索実行
            function executeSearch(selectedFood){
                currentFilterMode = 'food'
                hideRouletteModal();
                searchNearbyByKeyword(selectedFood);
            }






         </script>

</x-app-layout>