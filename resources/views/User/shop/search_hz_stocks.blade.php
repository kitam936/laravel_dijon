
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            店別品番在庫<br>
        </h2>

        <span class="items-center text-sm mt-2 text-gray-800 dark:text-gray-200 leading-tight" >※店舗を選択してください　</span>

        <form method="get" action="{{ route('user.shop.s_search_hz_form')}}" class="mt-4">
            <div class="flex">
            <div class="flex mb-2">
                {{-- <span class="items-center text-sm mt-2" >店舗： 　</span> --}}
                <select class="w-40 h-8 rounded text-sm items-center pt-1" id="sh_id" name="sh_id" type="number" class="border">
                    <option value="" @if(\Request::get('sh_id') == '0') selected @endif >全社</option>
                    @foreach ($companies as $company)
                        <optgroup  label = "{{ $company->co_name }}" class="text-indigo-700 font-weight:bold">
                            @foreach ($company->shop as $shop )
                            <option  value="{{ $shop->id }}" @if(\Request::get('sh_id') == $shop->id) selected @endif >{{ $shop->shop_name }}</option>
                            @endforeach
                    @endforeach
                </select>

                <div class="ml-8">
                    <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">SHOP一覧</button>
                </div>
            </div>
            <div class="flex">

             {{-- <div>
                <button  class="w-24 h-8 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-400 rounded ">検索</button>
            </div> --}}

            </div>
            </div>
            </form>

            @if(\Request::get('sh_id') =='0')

            {{-- <div class="ml-16 py-2 border"> --}}
                <div class=" w-full  sm:px-0 lg:px-0 border mt-4 ml-0">
                    <div class='border bg-gray-100 h-6'>
                        @foreach ($all_stocks as $all_stock)
                        　現在庫　：　{{ number_format($all_stock->pcs) }}枚　　　　{{ number_format(round($all_stock->zaikogaku)/1000) }}千円　
                        @endforeach
                    </div>
                </div>
            {{-- </div> --}}

            @else

                {{-- <div class="ml-16 py-2 border"> --}}
                <div class=" w-full  sm:px-0 lg:px-0 border mt-4 ml-0">
                    <div class='border bg-gray-100 h-6'>
                        @foreach ($s_stocks as $s_stock)
                        　現在庫　：　{{ number_format($s_stock->pcs) }}枚　　　　{{ number_format(round($s_stock->zaikogaku)/1000) }}千円　
                        @endforeach
                    </div>
                </div>
                {{-- </div> --}}

            @endif
    </x-slot>

    @if(\Request::get('sh_id') =='0')

    <div class="py-4 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="w-full md:w-1/2 bg-white table-auto w-full text-center whitespace-no-wrap">
                <<thead>
                    <tr>
                    <th class="w-1/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">UNIT</th>
                    <th class="w-1/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品番</th>
                    <th class="w-5/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品名</th>
                    <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫数</th>
                    <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫額(千円)</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($h_stocks_all as $h_stock)
                    <tr>
                        <td class="w-1/12 text-sm md:px-4 py-1">{{ $h_stock->unit_id }}</td>
                        <td class="w-2/12 text-sm md:px-4 py-1">{{ $h_stock->hinban_id }}</td>
                        <td class="w-6/12 text-xs md:px-4 py-1 text-left">{{ $h_stock->hinmei }}</td>
                        <td class="w-1/12 text-sm pr-4 md:px-4 py-1 text-right">{{ number_format($h_stock->pcs)}}</td>
                        <td class="w-2/12 text-sm md:px-4 py-1 text-right">{{ number_format(round($h_stock->zaikogaku)/1000)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else

    <div class="py-4 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border">
            <table class="w-full bg-white table-auto md:w-1/2 text-center whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="w-1/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">UNIT</th>
                    <th class="w-1/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品番</th>
                    <th class="w-5/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品名</th>
                    <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫数</th>
                    <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫額(千円)</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($h_stocks as $h_stock)
                <tr>
                    <td class="w-1/12 text-sm md:px-4 py-1">{{ $h_stock->unit_id }}</td>
                    <td class="w-1/12 text-sm md:px-4 py-1">{{ $h_stock->hinban_id }}</td>
                    <td class="w-5/12 text-xs md:px-4 py-1 text-left">{{ $h_stock->hinmei }}</td>
                    <td class="w-2/12 text-sm pr-4 md:px-4 py-1 text-right">{{ number_format($h_stock->pcs)}}</td>
                    <td class="w-3/12 text-sm md:px-4 py-1 text-right">{{ number_format(round($h_stock->zaikogaku)/1000)}}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        @endif

        <script>
            const shop = document.getElementById('sh_id')
            shop.addEventListener('change', function(){
            this.form.submit()
            })

            const YW1 = document.getElementById('YW1')
            YW1.addEventListener('change', function(){
            this.form.submit()
            })

            const YW2 = document.getElementById('YW2')
            YW2.addEventListener('change', function(){
            this.form.submit()
            })


        </script>

</x-app-layout>
