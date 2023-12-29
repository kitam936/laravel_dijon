
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            店別Unit在庫<br>
        </h2>

        <form method="get" action="{{ route('user.shop.s_search_uz_form')}}" class="mt-4">
            <div class="flex">
            <div class="flex mb-2">
                {{-- <span class="items-center text-sm mt-2" >店舗： 　</span> --}}
                <select class="w-40 h-8 text-sm items-center" id="sh_id" name="sh_id" type="number" class="border">
                    <option value="0" @if(\Request::get('sh_id') == '0') selected @endif >全店</option>
                    @foreach ($companies as $company)
                        <optgroup  label = "{{ $company->co_name }}" class="text-indigo-700 font-weight:bold">
                            @foreach ($company->shop as $shop )
                            <option  value="{{ $shop->id }}" @if(\Request::get('sh_id') == $shop->id) selected @endif >{{ $shop->shop_name }}</option>
                            @endforeach
                    @endforeach
                </select>
                <span class="items-center text-sm mt-2" >　※店舗を選択してください　　　</span>
                <div class="ml-8">
                    <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded " onclick="location.href='{{ route('user.shop.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">SHOP一覧</button>
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
                        　現在庫　：　　　{{ number_format(round($all_stock->zaikogaku)/1000) }}千円　　　　　　{{ number_format($all_stock->pcs) }}枚　　　　
                        @endforeach
                    </div>
                </div>
            {{-- </div> --}}

            @else

                {{-- <div class="ml-16 py-2 border"> --}}
                <div class=" w-full  sm:px-0 lg:px-0 border mt-4 ml-0">
                    <div class='border bg-gray-100 h-6'>
                        @foreach ($s_stocks as $s_stock)
                        　現在庫　：　　　{{ number_format(round($s_stock->zaikogaku)/1000) }}千円　　　　　　{{ number_format($s_stock->pcs) }}枚　　　　
                        @endforeach
                    </div>
                </div>
                {{-- </div> --}}

            @endif
    </x-slot>

    @if(\Request::get('sh_id') =='0')

    <div class="py-6 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="md:w-1/2 bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead>
                    <tr>
                        <th class="w-1/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">UNIT</th>
                        <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">シーズン</th>
                        <th class="w-1/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫数</th>
                        <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫額(千円)</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($u_stocks_all as $u_stock)
                        {{-- @foreach ($h_stock->hinban as $hinban) --}}

                    <tr>
                        <td class="w-1/12 md:px-4 py-1">{{ $u_stock->unit_id }}</td>
                        <td class="w-1/12 md:px-4 py-1">{{ $u_stock->season_name }}</td>
                        <td class="w-1/12 pr-6 md:px-4 py-1 text-right">{{ number_format($u_stock->pcs)}}</td>
                        <td class="w-3/12 pr-12 md:px-4 py-1 text-right">{{ number_format(round($u_stock->zaikogaku)/1000)}}</td>
                    </tr>
                @endforeach
                {{-- @endforeach --}}
                </tbody>
            </table>
        </div>

    @else

    <div class="py-6 border">
        <div class="px-2 mx-auto sm:px-4 lg:px-4 border">
            <table class="w-full bg-white table-auto md:w-1/2 text-center whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="w-1/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">UNIT</th>
                    <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">シーズン</th>
                    <th class="w-1/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫数</th>
                    <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫額(千円)</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($u_stocks as $u_stock)
                    {{-- @foreach ($h_stock->hinban as $hinban) --}}

                <tr>
                    <td class="w-1/12 md:px-4 py-1">{{ $u_stock->unit_id }}</td>
                    <td class="w-1/12 md:px-4 py-1">{{ $u_stock->season_name }}</td>
                    <td class="w-1/12 pr-6 md:px-4 py-1 text-right">{{ number_format($u_stock->pcs)}}</td>
                    <td class="w-3/12 pr-12 md:px-4 py-1 text-right">{{ number_format(round($u_stock->zaikogaku)/1000)}}</td>
                </tr>
                @endforeach
                {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
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
