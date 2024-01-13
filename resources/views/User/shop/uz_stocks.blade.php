
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            店別Unit在庫<br>
        </h2>

        <div class="mt-4 md:flex">
            @foreach ($shops as $shop)
            <div class="flex">
            <div class="flex pl-0 mt-0">

                <div class="pl-0  ml-0 md:ml-2 w-32 h-6 items-center bg-gray-100 border" name="co_id"  value="">{{ $shop->co_name }}</div>
            </div>
            <div class="flex pl-0 mt-0">

                <div class="pl-0 w-32 h-6 items-center bg-gray-100 border ml-2" name="ar_id" value="">{{ $shop->shop_name }}</div>
            </div>
            <div>
                <button type="button" class="w-20 h-6 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.show',['shop'=>$shop->id]) }}'" >戻る</button>
            </div>
            </div>
            @endforeach
        </div>
            @if(\Request::get('sh_id') =='0')

            {{-- <div class="ml-16 py-2 border"> --}}
                <div class="ml-0 w-full  sm:px-0 lg:px-0 border mt-4 ml-0">
                    <div class='border bg-gray-100 h-6'>
                        @foreach ($all_stocks as $all_stock)
                        　現在庫　：　{{ number_format(round($all_stock->zaikogaku)/1000) }}千円　　{{ number_format($all_stock->pcs) }}枚　
                        @endforeach
                    </div>
                </div>
            {{-- </div> --}}

            @else

                {{-- <div class="ml-16 py-2 border"> --}}
                <div class="ml-0 w-full  sm:px-0 lg:px-0 border mt-4 ml-0">
                    <div class='border bg-gray-100 h-6'>
                        @foreach ($s_stocks as $s_stock)
                        　現在庫　：　{{ number_format(round($s_stock->zaikogaku)/1000) }}千円　　{{ number_format($s_stock->pcs) }}枚　
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
