
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            社別品番売上<br>
        </h2>

        <span class="items-center text-sm mt-2" >　※会社・期間を選択してください</span>

        <form method="get" action="{{ route('user.company.search_h_form')}}" class="mt-4">
            <div class="flex mb-4">
                {{-- <span class="items-center text-sm mt-2" >会社： 　</span> --}}
                    <select class="w-32 h-8 text-sm items-center pt-1" id="co_id" name="co_id"  class="border">
                    <option value="" @if(\Request::get('co_id') == '0') selected @endif >全社</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @if(\Request::get('co_id') == $company->id) selected @endif >{{ $company->co_name }}</option>
                    @endforeach
                     </select>

                     <div class="ml-8">
                        <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">会社一覧</button>
                    </div>
            </div>
            <div class="flex">
                     {{-- <span class="items-center text-sm mt-2" >期間： 　</span> --}}
                     <select class="w-32 h-8 text-sm items-center pt-1" id="YW1" name="YW1" type="number" class="border">
                        <option value="" @if(\Request::get('YW1') == '0') selected @endif >{{ $max_YW }}直近週</option>
                        @foreach ($YWs as $YW)
                            <option value="{{ $YW->YW }}" @if(\Request::get('YW1') == $YW->YW) selected @endif >{{ floor(($YW->YM)/100)%100 }}年{{ ($YW->YM)%100 }}月{{ ($YW->YW)%100 }}週</option>
                        @endforeach
                    </select>
                    <span class="items-center text-sm mt-2" > 　～　</span>
                    <select class="w-32 h-8 text-sm items-center pt-1" id="YW2" name="YW2" type="number" class="border">
                        <option value="" @if(\Request::get('YW2') == '0') selected @endif >{{ $max_YW }}直近週</option>
                        @foreach ($YWs as $YW)
                            <option value="{{ $YW->YW }}" @if(\Request::get('YW2') == $YW->YW) selected @endif >{{ floor(($YW->YM)/100)%100 }}年{{ ($YW->YM)%100 }}月{{ ($YW->YW)%100 }}週</option>
                        @endforeach
                    </select>
                    <span class="items-center text-sm mt-2" >　</span>

             {{-- <div>
                <button  class="w-24 h-8 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-400 rounded ">検索</button>
            </div> --}}

            </div>
            </form>
            @if(\Request::get('co_id') =='0')

            {{-- <div class="ml-16 py-2 border"> --}}
                <div class=" w-full border sm:px-0 md:px-0 w-2/3 mt-4 ">
                    <div class='border bg-gray-100 h-6'>
                        @foreach ($all_stocks as $all_stock)
                        　現在庫　：　{{ number_format(round($all_stock->zaikogaku)/1000) }}千円　　{{ number_format($all_stock->pcs) }}枚　
                        @endforeach
                    </div>
                </div>
            {{-- </div> --}}

            @else

                {{-- <div class="ml-16 py-2 border"> --}}
                    <div class=" w-full border sm:px-0 md:px-0 w-2/3 mt-4 ">
                    <div class='border bg-gray-100 h-6'>
                        @foreach ($c_stocks as $c_stock)
                        　現在庫　：　{{ number_format(round($c_stock->zaikogaku)/1000) }}千円　　{{ number_format($c_stock->pcs) }}枚　
                        @endforeach
                    </div>
                    </div>
                {{-- </div> --}}

            @endif
    </x-slot>

    @if(\Request::get('co_id') =='0')

    <div class="px-2 py-4 border">
        <div class=" mx-auto px-4 sm:px-4 lg:px-4 border ">
            <table class="md:w-1/2 bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年度</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">UNIT</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品番</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品名</th>
                    <th class="w-2/8 pr-10 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">売上数</th>

                </tr>
                </thead>

                <tbody>
                @foreach ($h_sales_all as $h_sale)
                    {{-- @foreach ($h_stock->hinban as $hinban) --}}

                <tr>
                    <td class="w-2/8 md:px-4 py-1">{{ $h_sale->year_code }}</td>
                    <td class="w-1/8 md:px-4 py-1">{{ $h_sale->unit_id }}</td>
                    <td class="w-3/8 md:px-4 py-1">{{ $h_sale->hinban_id }}</td>
                    <td class="w-2/8 md:px-4 py-1 text-left">{{ $h_sale->hinmei }}</td>
                    <td class="w-2/8 pr-10 md:px-4 py-1 text-right">{{ number_format($h_sale->pcs)}}</td>

                </tr>
                @endforeach
                {{-- @endforeach --}}
                </tbody>
            </table>
        </div>

    @else

    <div class="px-2 py-4 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="md:w-1/2 bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年度</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">UNIT</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品番</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品名</th>
                    <th class="w-2/8 pr-10 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">売上数</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($h_sales as $h_sale)
                    {{-- @foreach ($h_stock->hinban as $hinban) --}}

                <tr>
                    <td class="w-2/8 md:px-4 py-1">{{ $h_sale->year_code }}</td>
                    <td class="w-1/8 md:px-4 py-1">{{ $h_sale->unit_id }}</td>
                    <td class="w-3/8 md:px-4 py-1">{{ $h_sale->hinban_id }}</td>
                    <td class="w-2/8 pl-4 md:px-4 py-1 text-left">{{ $h_sale->hinmei }}</td>
                    <td class="w-2/8 pr-10 md:px-4 py-1 text-right">{{ number_format($h_sale->pcs)}}</td>

                </tr>
                @endforeach
                {{-- @endforeach --}}
                </tbody>
            </table>
        </div>

        @endif

        <script>
            const company = document.getElementById('co_id')
            company.addEventListener('change', function(){
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
