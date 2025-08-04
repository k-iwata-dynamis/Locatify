<!-- 全体 -->
<footer class="bg-blue-100 w-full">
   
       <div class="w-full px-4 mb-12 py-12">
        <div class="mb-8">
            <div class="bg-gradient-to-r from-yellow-300 via-orange-300 to-red-300 p-6 rounded-lg border-l-4 border-yellow-500">
                <div class="flex flex-col lg:flex-row items-start justify-between gap-8">
                    
                    <!-- 左半分レイアウト -->
                    <div class="flex-1 text-center lg:text-left w-full lg:w-auto">
                        <p class="text-gray-800 text-lg font-bold mb-4">「もっとランチタイムにゆっくりしたいなぁ・・・」</p>
                        <p class="text-gray-800 text-lg font-semibold mb-2">ランチタイムを増やすために</p>
                        <p class="text-gray-800 text-lg font-semibold">紙媒体や手入力している業務をDX化し効率化しませんか?</p>
                    </div>
                    
                    <!-- 右半分レイアウト -->
                    <div class="flex-shrink-0 w-full lg:w-auto lg:min-w-[250px] text-center min-w-[250px] items-center justify-center">
                        <p class="text-gray-800 text-lg font-bold mb-6">
                            デュナミスで補助金を活用した<br>
                            DX化の無料相談はこちら
                        </p>
                        <a href="https://www.dynamis.llc/contact" target="_blank" rel="noopener noreferrer"
                           class="inline-flex items-center justify-center rounded-full p-5 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 hover:-translate-y-1"
                           style="background: white !important; background-image: none !important;">
                            <img src="{{ asset('images/mail-icom.png') }}" alt="メールアイコン" class="w-8 h-8">
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
        
       <!-- 会社情報部分 -->
       <div class="bg-white bg-opacity-80 backdrop-blur-sm rounded-lg p-6 shadow-sm">
           <div class="flex flex-col sm:flex-row justify-between items-center gap-6 max-w-7xl mx-auto">
               <div class="flex-1 text-center sm:text-left">
                   <h4 class="text-xl font-bold text-gray-800 mb-4">株式会社デュナミス</h4>
                   <ul class="space-y-3 text-gray-700">
                       <li class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-3">
                           <span class="font-semibold text-gray-800 min-w-[60px]">代表者</span>
                           <span>土佐 雅人</span>
                       </li>
                       <li class="flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-3">
                           <span class="font-semibold text-gray-800 min-w-[60px]">所在地</span>
                           <span class="break-words">〒981-0913 宮城県仙台市青葉区昭和町4-9-307</span>
                       </li>
                   </ul>
               </div>
               <!-- ロゴ部分 -->
               <div class="flex-shrink-0">
                   <img src="{{ asset('images/Dynamis_logo_small-removebg-preview.png') }}" 
                        alt="dynamisロゴ" 
                        class="h-20 lg:h-24 w-auto rounded-lg bg-white p-3 shadow-sm">
               </div>
           </div>
       </div>
       
   </div>
   <div class="h-4 md:h-0"></div>
</footer>
<!-- 全体終わり -->