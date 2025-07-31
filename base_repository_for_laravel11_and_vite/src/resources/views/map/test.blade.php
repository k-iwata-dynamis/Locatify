<x-app-layout>
    <div class="py-4">
        <div class="w-full">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm">
                <div class="p-4 text-gray-900 dark:text-gray-100">
                    <h2 class="text-xl font-bold mb-4">Google Maps テスト</h2>
                    
                    <!-- APIキー確認 -->
                    <div class="mb-4 p-4 bg-gray-100 dark:bg-gray-700 rounded">
                        <h3 class="font-semibold mb-2">APIキー確認:</h3>
                        <p id="apiKeyCheck">APIキー: {{ $googleMapsApiKey ? 'あり' : 'なし' }}</p>
                        <p>APIキー値: <span class="font-mono text-sm">{{ substr($googleMapsApiKey, 0, 20) }}...</span></p>
                    </div>

                    <!-- 地図表示エリア -->
                    <div class="mb-4">
                        <h3 class="font-semibold mb-2">地図:</h3>
                        <div id="map" class="w-full h-96 bg-gray-200 rounded-lg border-2 border-dashed border-gray-400"></div>
                    </div>

                    <!-- エラー表示エリア -->
                    <div id="errorDisplay" class="mb-4 p-4 bg-red-100 dark:bg-red-800 rounded hidden">
                        <h3 class="font-semibold mb-2 text-red-800 dark:text-red-200">エラー:</h3>
                        <pre id="errorMessage" class="text-sm text-red-600 dark:text-red-300"></pre>
                    </div>

                    <!-- ステータス表示 -->
                    <div id="status" class="p-4 bg-blue-100 dark:bg-blue-800 rounded">
                        <p id="statusMessage">初期化中...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // エラーハンドリング
        window.addEventListener('error', function(e) {
            console.error('JavaScript Error:', e);
            showError('JavaScript Error: ' + e.message + '\nFile: ' + e.filename + '\nLine: ' + e.lineno);
        });

        // Google Maps関連のエラーをキャッチ
        window.gm_authFailure = function() {
            showError('Google Maps API認証エラー: APIキーが無効または制限されています');
        };

        function showError(message) {
            const errorDisplay = document.getElementById('errorDisplay');
            const errorMessage = document.getElementById('errorMessage');
            errorMessage.textContent = message;
            errorDisplay.classList.remove('hidden');
            updateStatus('エラーが発生しました');
        }

        function updateStatus(message) {
            document.getElementById('statusMessage').textContent = message;
        }

        // Google Maps初期化
        function initMap() {
            try {
                updateStatus('Google Maps APIが読み込まれました');
                
                // 基本的な地図を作成（Map IDなし）
                const map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 15,
                    center: { lat: 35.6595, lng: 139.7034 }, // 渋谷
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                // マーカーを追加
                const marker = new google.maps.Marker({
                    position: { lat: 35.6595, lng: 139.7034 },
                    map: map,
                    title: "テスト位置（渋谷）"
                });

                updateStatus('地図の初期化が完了しました');
                
            } catch (error) {
                console.error('Map initialization error:', error);
                showError('地図の初期化エラー: ' + error.message);
            }
        }

        // APIキーの確認
        console.log('Google Maps API Key:', '{{ $googleMapsApiKey }}');
        updateStatus('APIキーを確認中...');
    </script>

    <!-- Google Maps API読み込み -->
    <script async defer 
            src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&v=bete&libraries=places&callback=initMap"
            onerror="showError('Google Maps APIスクリプトの読み込みに失敗しました')">
    </script>
</x-app-layout>
