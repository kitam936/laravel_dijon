
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            SHOP一覧
            <button type="button" onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">戻る</button>
        </h2>
    </x-slot>

    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            {{-- <x-flash-message status="session('status')" /> --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 text-gray-900 dark:text-gray-100  ">
                    @foreach ($shops as $shop)
                    <div class="p-1 mb-1 ">

                        <div class="flex-auto justify-around  w-1/2 text-sm text-blue-800 border bg-gray-100">
                            {{ $shop->id }} --
                            {{ $shop->shop_name }}
                            <div class="flex-auto p-1 text-gray-900 dark:text-gray-100  ">
                            <button type="button" onclick="location.href='{{ route('user.shop.shopmonthrysales',['shop'=>$shop->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded  ">月別売上</button>
                            <button type="button" onclick="location.href='{{ route('user.shop.shopweeklysales',['shop'=>$shop->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded  ">週別売上</button>
                            <button type="button" onclick="location.href='{{ route('user.shop.shopweeklysales',['shop'=>$shop->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded  ">週別売上</button>
                            </div>
                            <div class="flex-auto p-1 text-gray-900 dark:text-gray-100  ">
                            <button type="button" onclick="location.href='{{ route('user.shop.sh_sales',['shop'=>$shop->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">品番売上</button>
                            <button type="button" onclick="location.href='{{ route('user.shop.su_sales',['shop'=>$shop->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">UNIT売上</button>
                            <button type="button" onclick="location.href='{{ route('user.shop.s_season_sales',['shop'=>$shop->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">Season売上</button>
                            </div>
                            <div class="flex-auto p-1 text-gray-900 dark:text-gray-100  ">
                            <button type="button" onclick="location.href='{{ route('user.shop.sh_stock',['shop'=>$shop->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded  ">品番在庫</button>
                            <button type="button" onclick="location.href='{{ route('user.shop.su_stock',['shop'=>$shop->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded  ">UNIT在庫</button>
                            <button type="button" onclick="location.href='{{ route('user.shop.s_season_stock',['shop'=>$shop->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded  ">Season在庫</button>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
        </div>

</x-app-layout>
