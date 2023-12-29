<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            データINDEX
        </h2>
        <div class="md:flex-auto p-1 text-gray-900 dark:text-gray-100  ">
            <div class="flex px-4 py-4 md:w-2/3">
            <button type="button" class="w-32 h-10 ml-4 border-gray-900 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('admin.data.area_index') }}'" >エリアデータ</button>
            <button type="button" class="w-32 h-10 ml-4 border-gray-900 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('admin.data.company_index') }}'" >会社データ</button>
            <button type="button" class="w-32 h-10 ml-4 border-gray-900 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('admin.data.shop_index') }}'" >店舗データ</button>
            </div>
            <div class="flex px-4 py-4 md:w-2/3">
            <button type="button" class="w-32 h-10 ml-4 border-gray-900 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('admin.data.unit_index') }}'" >UNITデータ</button>
            <button type="button" class="w-32 h-10 ml-4 border-gray-900 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('admin.data.brand_index') }}'" >BRANDデータ</button>
            <button type="button" class="w-32 h-10 ml-4 border-gray-900 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('admin.data.hinban_index') }}'" >品番データ</button>
            </div>
            <div class="flex px-4 py-4 md:w-2/3">
            <button type="button" class="w-32 h-10 ml-4 border-gray-900 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('admin.data.sales_index') }}'" >売上データ</button>
            <button type="button" class="w-32 h-10 ml-4 border-gray-900 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('admin.data.deliv_index') }}'" >納品データ</button>
            <button type="button" class="w-32 h-10 ml-4 border-gray-900 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('admin.data.stock_index') }}'" >在庫データ</button>
            </div>
        </div>

    </x-slot>

</x-app-layout>
