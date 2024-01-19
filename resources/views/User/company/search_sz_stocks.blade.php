
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            社別Season在庫<br>
        </h2>

        <span class="items-center text-sm mt-1 text-gray-800 dark:text-gray-200 leading-tight" >　※会社を選択してください　　　</span>

        <form method="get" action="{{ route('user.company.search_sz_form')}}" class="mt-2">
            <div class="flex">
                <div class="flex mb-2">

                        <select class="w-32 h-8 rounded text-sm pt-1" id="co_id" name="co_id"  class="border">
                        <option value="" @if(\Request::get('co_id') == '0') selected @endif >全社</option>
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
                    <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">会社一覧</button>
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

    <div class="px-2 py-4 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="w-full bg-white table-auto md:w-1/2 text-center whitespace-no-wrap">
                <<thead>
                    <tr>
                        <th class="w-2/5 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">シーズン</th>
                        <th class="w-1/5 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫数</th>
                        <th class="w-2/5 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫額(千円)</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($season_stocks_all as $season_stock)
                    <tr>
                        <td class="w-2/5 md:px-4 py-1">{{ $season_stock->season_name }}</td>
                        <td class="w-1/5 pr-6 md:px-4 py-1 text-right">{{ number_format($season_stock->pcs)}}</td>
                        <td class="w-2/5 pr-16 md:px-4 py-1 text-right">{{ number_format(round($season_stock->zaikogaku)/1000)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else

    <div class="px-2 py-4 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border">
            <table class="w-full bg-white table-auto md:w-1/2 text-center whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="w-2/5 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">シーズン</th>
                    <th class="w-1/5 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫数</th>
                    <th class="w-2/5 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫額(千)</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($season_stocks as $season_stock)
                <tr>
                    <td class="w-2/5 md:px-4 py-1">{{ $season_stock->season_name }}</td>
                    <td class="w-1/5 pr-6 md:px-4 py-1 text-right">{{ number_format($season_stock->pcs)}}</td>
                    <td class="w-2/5 pr-16 md:px-4 py-1 text-right">{{ number_format(round($season_stock->zaikogaku)/1000)}}</td>
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


        </script>

</x-app-layout>
