
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            会社一覧
        </h2>
    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto sm:px-4 lg:px-4">
            {{-- <x-flash-message status="session('status')" /> --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-1 text-gray-900 dark:text-gray-100  ">
                    @foreach ($companies as $company)
                    <div class="p-1 mb-1 ">

                        <div class="flex-auto justify-around  w-1/2 text-sm text-blue-800 border bg-gray-100">
                            {{ $company->id }} --
                            {{ $company->co_name }}
                            <div class="flex-auto p-1 text-gray-900 dark:text-gray-100  ">
                            <button type="button" onclick="location.href='{{ route('user.company.shoplist',['company'=>$company->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">SHOP一覧</button>
                            <button type="button" onclick="location.href='{{ route('user.company.monthrysales',['company'=>$company->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">月別売上</button>
                            <button type="button" onclick="location.href='{{ route('user.company.weeklysales',['company'=>$company->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">週別売上</button>
                            </div>
                            <div class="flex-auto p-1 text-gray-900 dark:text-gray-100  ">
                            <button type="button" onclick="location.href='{{ route('user.company.ch_sales',['company'=>$company->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">品番売上</button>
                            <button type="button" onclick="location.href='{{ route('user.company.cu_sales',['company'=>$company->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">UNIT売上</button>
                            <button type="button" onclick="location.href='{{ route('user.company.c_season_sales',['company'=>$company->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">Season売上</button>
                            </div>
                            <div class="flex-auto p-1 text-gray-900 dark:text-gray-100  ">
                            <button type="button" onclick="location.href='{{ route('user.company.ch_stock',['company'=>$company->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">品番在庫</button>
                            <button type="button" onclick="location.href='{{ route('user.company.cu_stock',['company'=>$company->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">UNIT在庫</button>
                            <button type="button" onclick="location.href='{{ route('user.company.c_season_stock',['company'=>$company->id]) }}'" class="w-24 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded ">Season在庫</button>
                            </div>
                        </div>
                    </div>
                    @endforeach


                </div>
            </div>
        </div>

</x-app-layout>
