
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            店別月別売上<br>
        </h2>

        <span class="items-center text-sm mt-2" >　※店舗を選択してください　　　</span>

        <form method="get" action="{{ route('user.shop.s_search_m_form')}}" class="mt-4">
        <div class="flex">
        <select class="w-40 h-8 text-sm items-center" id="sh_id" name="sh_id" type="number" class="border">
        <option value="0" @if(\Request::get('sh_id') == '0') selected @endif >全社</option>
        @foreach ($companies as $company)
            <optgroup  label = "{{ $company->co_name }}" class="text-indigo-700 font-weight:bold">
                @foreach ($company->shop as $shop )
                <option  value="{{ $shop->id }}" @if(\Request::get('sh_id') == $shop->id) selected @endif >{{ $shop->shop_name }}</option>
                @endforeach
        @endforeach
         </select>

         {{-- <div>
            <button  class="w-24 h-8 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-400 rounded ">検索</button>
        </div> --}}
        <div>
            <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">SHOP一覧</button>
            </div>
        </div>
        </form>

        @if(\Request::get('sh_id') =='0')

        {{-- <div class="ml-16 py-2 border"> --}}
            <div class=" w-full  sm:px-0 lg:px-0 border mt-4 ml-0">
                <div class='border bg-gray-100 h-6'>
                    @foreach ($all_stocks as $all_stock)
                    　現在庫　：　{{ number_format(round($all_stock->zaikogaku)/1000) }}千円　　{{ number_format($all_stock->pcs) }}枚　
                    @endforeach
                </div>
            </div>
        {{-- </div> --}}

        @else

            {{-- <div class="ml-16 py-2 border"> --}}
                <div class=" w-full  sm:px-0 lg:px-0 border mt-4 ml-0">
                <div class='border bg-gray-100 h-6'>
                    @foreach ($s_stocks as $s_stock)
                    　現在庫　：　{{ number_format(round($s_stock->zaikogaku)/1000) }}千円　　{{ number_format($s_stock->pcs) }}枚　
                    @endforeach
                </div>
            </div>
            {{-- </div> --}}

        @endif
    </x-slot>

    {{-- @if(\Request::get('sh_id') =='0') --}}

    {{-- <div class="py-6 border"> --}}
        {{-- <div class=" w-1/2  sm:px-4 lg:px-4 border">
            <table class="table-auto bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead >
                <tr>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年月</th>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">月売上</th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($m_sales_all as $m_sale)
                <tr>
                    <td class="w-1/4 md:px-4 py-1">{{ $m_sale->YM }}</td>
                    <td class="w-1/4 md:px-4 py-1 text-right">{{ number_format($m_sale->kingaku)}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div> --}}

    {{-- @else --}}

        <div class="py-6 border">
        <div class="md:w-1/2 sm:px-4 lg:px-4 border">
            <table class="mx-auto table-auto bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead >
                <tr>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年月</th>

                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">月売上(千円)</th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($m_sales as $m_sale)
                <tr>
                    <td class="w-1/4 md:px-4 py-1">{{ $m_sale->YM }}</td>

                    <td class="w-1/4 pr-24 md:px-4 py-1 text-right">{{ number_format(round($m_sale->kingaku)/1000)}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        </div>
    {{-- @endif --}}

    <script>
        const shop = document.getElementById('sh_id')
        shop.addEventListener('change', function(){
        this.form.submit()
        })


    </script>

</x-app-layout>



