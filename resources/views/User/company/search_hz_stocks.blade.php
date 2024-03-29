
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            社別品番在庫<br>
        </h2>

        <span class="items-center text-sm mt-2 text-gray-800 dark:text-gray-200 leading-tight" >　※Brand・会社を選択してください　　　</span>

        <form method="get" action="{{ route('user.company.search_hz_form')}}" class="mt-2">
            <div class="flex">
                <div class="flex mb-2">
                    <select class="w-32 h-8 rounded text-sm pt-1 border mb-2 mr-2 " id="brand_code" name="brand_code" type="number" >
                        <option value="" @if(\Request::get('brand_code') == '0') selected @endif >全ブランド</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @if(\Request::get('brand_code') == $brand->id ) selected @endif >{{ $brand->br_name  }}</option>
                        @endforeach
                    </select>

                    <select class="w-32 h-8 rounded text-sm pt-1" id="co_id" name="co_id"  class="border">
                        <option value="0" @if(\Request::get('co_id') == '0') selected @endif >全社</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" @if(\Request::get('co_id') == $company->id) selected @endif >{{ $company->co_name }}</option>
                        @endforeach
                    </select>

                </div>
                <div class="flex">
                {{-- <div>
                    <button  class="w-24 h-8 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-400 rounded ">検索</button>
                </div> --}}
                <div>
                    <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded " onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">会社一覧</button>
                </div>
                </div>
            </div>
        </form>

            @if(\Request::get('co_id') =='0')

            {{-- <div class="ml-16 py-2 border"> --}}
                <div class=" w-full  sm:px-0 lg:px-0 border mt-0 ">
                    <div class='border bg-gray-100 h-6'>
                        @foreach ($all_stocks as $all_stock)
                        　現在庫　：　{{ number_format($all_stock->pcs) }}枚　　　　{{ number_format(round($all_stock->zaikogaku)/1000) }}千円　
                        @endforeach
                    </div>
                </div>　
            {{-- </div> --}}

            @else

                {{-- <div class="ml-16 py-2 border"> --}}
                    <div class=" w-full  sm:px-0 lg:px-0 border mt-0 ">
                    <div class='border bg-gray-100 h-6'>
                        @foreach ($c_stocks as $c_stock)
                        　現在庫　：　{{ number_format($c_stock->pcs) }}枚　　　　{{ number_format(round($c_stock->zaikogaku)/1000) }}千円　
                        @endforeach
                    </div>
                </div>
                {{-- </div> --}}

            @endif
    </x-slot>

    @if(\Request::get('co_id') =='0')

    <div class="py-6 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="w-full md:w-3/4 bg-white table-auto text-center whitespace-no-wrap">
                <<thead>
                    <tr>
                    <th class="w-1/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">UNIT</th>
                    <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品番</th>
                    <th class="w-4/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品名</th>
                    <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫数</th>
                    <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫額(千円)</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($h_stocks_all as $h_stock)
                    <tr>
                        <td class="w-1/12 text-sm md:px-4 py-1">{{ $h_stock->unit_id }}</td>
                        <td class="w-2/12 text-sm md:px-4 py-1">{{ $h_stock->hinban_id }}</td>
                        <td class="w-4/12 text-xs md:px-4 py-1 text-left">{{ Str::limit($h_stock->hinmei,24) }}</td>
                        <td class="w-2/12 text-sm pr-6 md:px-4 py-1 text-right"><span style="font-variant-numeric:tabular-nums">{{ number_format($h_stock->pcs)}}</span></td>
                        <td class="w-3/12 text-sm md:px-4 py-1 text-right pr-4"><span style="font-variant-numeric:tabular-nums">{{ number_format(round($h_stock->zaikogaku)/1000)}}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else

    <div class="py-6 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border">
            <table class="w-full md:w-3/4 bg-white table-auto text-center whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="w-1/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">UNIT</th>
                    <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品番</th>
                    <th class="w-4/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品名</th>
                    <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫数</th>
                    <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫額(千円)</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($h_stocks as $h_stock)
                <tr>
                    <td class="w-1/12 text-sm md:px-4 py-1">{{ $h_stock->unit_id }}</td>
                    <td class="w-2/12 text-sm md:px-4 py-1">{{ $h_stock->hinban_id }}</td>
                    <td class="w-4/12 text-xs md:px-4 py-1 text-left">{{ Str::limit($h_stock->hinmei,24) }}</td>
                    <td class="w-2/12 text-sm pr-6 md:px-4 py-1 text-right"><span style="font-variant-numeric:tabular-nums">{{ number_format($h_stock->pcs)}}</span></td>
                    <td class="w-3/12 text-sm  md:px-4 py-1 text-right pr-4"><span style="font-variant-numeric:tabular-nums">{{ number_format(round($h_stock->zaikogaku)/1000)}}</span></td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        @endif

        <script>
            const company = document.getElementById('co_id')
            company.addEventListener('change', function(){
            this.form.submit()
            })

            const brand = document.getElementById('brand_code')
            brand.addEventListener('change', function(){
            this.form.submit()
            })



        </script>

</x-app-layout>
