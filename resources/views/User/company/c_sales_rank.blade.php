
<x-app-layout>
    <x-slot name="header">
        <div class="">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            社別期間売上
        </h2>

        <span class="items-center text-sm mt-2 text-gray-800 dark:text-gray-200 leading-tight" >　※Brand・期間を選択してください</span>

        </div>

        <form method="get" action="{{ route('user.company.c_sales_rank')}}" class="md:flex mt-4">

            <div class="flex mb-2">
                {{-- <label for="co_id" class="items-center text-sm mt-2" >会社： 　</label> --}}
                {{-- <label for="brand_code" class="items-center text-sm mt-2  text-gray-800 dark:text-gray-200 leading-tight" >Brand：</label> --}}
                <select class="w-28 h-8 rounded text-sm pt-1 border mb-2 mr-4 " id="brand_code" name="brand_code" type="number" >
                <option value="" @if(\Request::get('brand_code') == '0') selected @endif >全ブランド</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" @if(\Request::get('brand_code') == $brand->id ) selected @endif >{{ $brand->br_name  }}</option>
                @endforeach
                </select>


            </div>


            <div class="flex">
                     {{-- <label for="YW1" class="items-center text-sm mt-2 " >期間： 　</label> --}}
                    <select class="w-32 h-8 rounded text-sm items-center pt-1" id="YW1" name="YW1" type="number" >
                    <option value="" @if(\Request::get('YW1') == '0') selected @endif >{{ $max_YW }}直近週</option>
                    @foreach ($YWs as $YW)
                        <option value="{{ $YW->YW }}" @if(\Request::get('YW1') == $YW->YW) selected @endif >{{ floor(($YW->YM)/100)%100 }}年{{ ($YW->YM)%100 }}月{{ ($YW->YW)%100 }}週</option>
                    @endforeach
                </select>
                <label for="YW2" class="items-center text-sm mt-2 ml-2 text-gray-800 dark:text-gray-200 leading-tight" >～</label>
                <select class="w-32 h-8 ml-2 rounded text-sm items-center pt-1" id="YW2" name="YW2" type="number" class="border">
                    <option value="" @if(\Request::get('YW2') == '0') selected @endif >{{ $max_YW }}直近週</option>
                    @foreach ($YWs as $YW)
                        <option value="{{ $YW->YW }}" @if(\Request::get('YW2') == $YW->YW) selected @endif >{{ floor(($YW->YM)/100)%100 }}年{{ ($YW->YM)%100 }}月{{ ($YW->YW)%100 }}週</option>
                    @endforeach
                </select>
                <span class="items-center text-sm mt-2" ></span>

                 <div>
                    <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2 md:ml-4 hover:bg-indigo-600 rounded " onclick="location.href='{{ route('user.company.index') }}'" >会社一覧</button>
                </div>


        </div>

        </form>

    </x-slot>



    <div class="py-6 border">
        <div class=" mx-auto px-4 sm:px-4 lg:px-4 border ">
            <table class="w-full bg-white table-auto md:w-1/2 text-center whitespace-no-wrap">
                <thead>
                <tr>
                    {{-- <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">社ｺｰﾄﾞ</th> --}}
                    <th class="w-4/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">社名</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">売上数</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">売上額(千円)</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($c_ranks as $c_rank)


                <tr>
                    {{-- <td class="w-2/8 md:px-4 py-1">{{ $c_rank->company_id }}</td> --}}
                    <td class="w-4/8 text-sm md:px-4 py-1 text-left">{{ $c_rank->co_name }}</td>
                    <td class="w-2/8 text-sm pr-6 md:px-4 py-1 text-right">{{ number_format($c_rank->pcs)}}</td>
                    <td class="w-2/8 text-sm pr-10 md:px-4 py-1 text-right">{{ number_format(round($c_rank->kingaku)/1000)}}</td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>



        <script>

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
