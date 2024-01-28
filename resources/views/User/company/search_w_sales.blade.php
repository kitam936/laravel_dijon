
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            社別週別売上<br>
        </h2>

        <span class="items-center text-sm mt-2 text-gray-800 dark:text-gray-200 leading-tight" >　※Brand・会社を選択してください　　　</span>

        <form method="get" action="{{ route('user.company.search_w_form')}}" class="mt-4">
        <div class="flex">
        <select class="w-32 h-8 rounded text-sm pt-1 border mb-2 mr-2 " id="brand_code" name="brand_code" type="number" >
            <option value="" @if(\Request::get('brand_code') == '0') selected @endif >全ブランド</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->id }}" @if(\Request::get('brand_code') == $brand->id ) selected @endif >{{ $brand->br_name  }}</option>
            @endforeach
        </select>
        <select class="w-32 h-8 rounded text-sm pt-1" id= "co_id" name="co_id" type="text" class="border">
            <option value="" @if(\Request::get('co_id') == '0') selected @endif >全社</option>
            @foreach ($companies as $company)
                <option value="{{ $company->id }}" @if(\Request::get('co_id') == $company->id) selected @endif >{{ $company->co_name }}</option>
            @endforeach
         </select>

         {{-- <div>
            <button  class="w-24 h-8 ml-2 text-center text-black bg-gray-300 border-0 py-0 px-2 focus:outline-none hover:bg-gray-400 rounded ">検索</button>
        </div> --}}
        <div>
            <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-0 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.index') }}'" >会社一覧</button>
        </div>
        </div>
        </form>

        {{-- @if(\Request::get('co_id') =='0')


            <div class=" w-1/2  sm:px-0 lg:px-0 border mt-4 ml-0">
                <div class='border bg-gray-100 h-6'>
                    @foreach ($all_stocks as $all_stock)
                    　現在庫　：　　　{{ number_format($all_stock->zaikogaku) }}円　　　　　　{{ number_format($all_stock->pcs) }}枚　　　　
                    @endforeach
                </div>
            </div>

        @else --}}

            <div class=" w-full  sm:px-0 lg:px-0 border mt-4 ml-0">
                <div class='border bg-gray-100 h-6'>
                    @foreach ($c_stocks as $c_stock)
                    　現在庫　：　{{ number_format($c_stock->pcs) }}枚　　　　{{ number_format(round($c_stock->zaikogaku)/1000) }}千円　
                    @endforeach
                </div>
            </div>

        {{-- @endif --}}


    </x-slot>

    {{-- @if(\Request::get('co_id') =='0')

    <div class="py-6 border">
        <div class=" w-1/2  sm:px-4 lg:px-4 border">
            <table class="table-auto bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead >
                <tr>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年月</th>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年週</th>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">週売上</th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($w_sales_all as $w_sale)
                <tr>
                    <td class="w-1/4 md:px-4 py-1">{{ $w_sale->YM }}</td>
                    <td class="w-1/4 md:px-4 py-1">{{ $w_sale->YW }}</td>
                    <td class="w-1/4 md:px-4 py-1 text-right">{{ number_format($w_sale->kingaku)}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    @else --}}

        <div class="py-6 border">
        <div class=" w-full  sm:px-4 md:w-1/2 px-4 border">
            <table class="mx-auto table-auto bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead >
                <tr>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年月</th>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年週</th>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">週売上(千円)</th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($w_sales as $w_sale)
                <tr>
                    <td class="w-1/4 md:px-4 py-1">{{ $w_sale->YM }}</td>
                    <td class="w-1/4 md:px-4 py-1">{{ $w_sale->YW }}</td>
                    <td class="w-1/4 pr-8 md:px-4 py-1 text-right">{{ number_format(round($w_sale->kingaku)/1000)}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    {{-- @endif --}}

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



