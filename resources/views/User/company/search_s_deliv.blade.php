
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            社別Season納品<br>
        </h2>

        <span class="items-center text-sm mt-2 text-gray-800 dark:text-gray-200 leading-tight" >　※Brand・会社・期間を選択してください</span>

        <form method="get" action="{{ route('user.company.search_sd_form')}}" class="mt-4">
            <div class="flex mb-2">

                <select class="w-32 h-8 rounded text-sm pt-1 border mb-2 mr-2 " id="brand_code" name="brand_code" type="number" >
                    <option value="" @if(\Request::get('brand_code') == '0') selected @endif >全ブランド</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @if(\Request::get('brand_code') == $brand->id ) selected @endif >{{ $brand->br_name  }}</option>
                    @endforeach
                </select>
                <select class="w-32 h-8 rounded text-sm items-center pt-1" id="co_id" name="co_id"  class="border">
                    <option value="" @if(\Request::get('co_id') == '0') selected @endif >全社</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" @if(\Request::get('co_id') == $company->id) selected @endif >{{ $company->co_name }}</option>
                    @endforeach
                </select>

                     <div class="ml-2">
                        <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-0 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">会社一覧</button>
                    </div>
            </div>
            <div class="flex-auto">
                     {{-- <span class="items-center text-sm mt-2" >期間： 　</span> --}}
                     <select class="w-32 h-8 rounded text-sm items-center pt-1" id="YW1" name="YW1" type="number" class="border">
                        <option value="" @if(\Request::get('YW1') == '0') selected @endif >{{ $max_YW }}直近週</option>
                        @foreach ($YWs as $YW)
                            <option value="{{ $YW->YW }}" @if(\Request::get('YW1') == $YW->YW) selected @endif >{{ floor(($YW->YM)/100)%100 }}年{{ ($YW->YM)%100 }}月{{ ($YW->YW)%100 }}週</option>
                        @endforeach
                    </select>
                    <span class="items-center text-sm mt-2 text-gray-800 dark:text-gray-200 leading-tight" >　～　</span>
                    <select class="w-32 h-8 rounded text-sm items-center pt-1" id="YW2" name="YW2" type="number" class="border">
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


    </x-slot>

    @if(\Request::get('co_id') =='0')

    <div class="py-6 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="w-4/5 md:w-1/2 bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年度</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">シーズン</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">納品数</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">納品額(千円)</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($s_delivs_all as $s_deliv)


                <tr>
                    <td class="w-2/8 md:px-4 py-1">{{ $s_deliv->year_code }}</td>
                    <td class="w-2/8 md:px-4 py-1">{{ $s_deliv->season_name }}</td>
                    <td class="w-1/8 md:px-4 py-1 text-right"><span style="font-variant-numeric:tabular-nums"> {{ number_format($s_deliv->pcs)}}</span></td>
                    <td class="w-3/8 md:px-4 py-1 text-right"><span style="font-variant-numeric:tabular-nums"> {{ number_format(round($s_deliv->kingaku)/1000)}}</span></td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>

    @else

    <div class="py-6 border">
        <div class=" p-2 mx-auto sm:px-4 lg:px-4 border ">
            <table class="w-4/5 md:w-1/2 bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年度</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">シーズン</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">納品数</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">納品額(千円)</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($s_delivs as $s_deliv)


                <tr>
                    <td class="w-2/8 md:px-4 py-1">{{ $s_deliv->year_code }}</td>
                    <td class="w-2/8 md:px-4 py-1">{{ $s_deliv->season_name }}</td>
                    <td class="w-1/8 pr-4 md:px-4 py-1 text-right"><span style="font-variant-numeric:tabular-nums"> {{ number_format($s_deliv->pcs)}}</span></td>
                    <td class="w-3/8 pr-12 md:px-4 py-1 text-right"><span style="font-variant-numeric:tabular-nums"> {{ number_format(round($s_deliv->kingaku)/1000)}}</span></td>
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
