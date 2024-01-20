
<x-app-layout>
    <x-slot name="header">
        <div class="">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            店別期間納品
        </h2>

        <span class="items-center text-sm mt-2 text-gray-800 dark:text-gray-200 leading-tight" >　※期間を選択してください</span>

        </div>
        <form method="get" action="{{ route('user.shop.s_delivs_rank')}}" class="mt-4">

            <div class="flex">
                     {{-- <label for="YW1" class="items-center text-sm mt-2 " >期間： 　</label> --}}
                     <select class="w-32 h-8 rounded text-sm items-center pt-1" id="YW1" name="YW1" type="number" >
                        <option value="" @if(\Request::get('YW1') == '0') selected @endif >{{ $max_YW }}直近週</option>
                        @foreach ($YWs as $YW)
                            <option value="{{ $YW->YW }}" @if(\Request::get('YW1') == $YW->YW) selected @endif >{{ floor(($YW->YM)/100)%100 }}年{{ ($YW->YM)%100 }}月{{ ($YW->YW)%100 }}週</option>
                        @endforeach
                    </select>
                    <label for="YW2" class="items-center text-sm mt-2 text-gray-800 dark:text-gray-200 leading-tight" >　～　</label>
                    <select class="w-32 h-8 rounded text-sm items-center pt-1" id="YW2" name="YW2" type="number" class="border">
                        <option value="" @if(\Request::get('YW2') == '0') selected @endif >{{ $max_YW }}直近週</option>
                        @foreach ($YWs as $YW)
                            <option value="{{ $YW->YW }}" @if(\Request::get('YW2') == $YW->YW) selected @endif >{{ floor(($YW->YM)/100)%100 }}年{{ ($YW->YM)%100 }}月{{ ($YW->YW)%100 }}週</option>
                        @endforeach
                    </select>
                    <span class="items-center text-sm mt-2" >　</span>
                    <div class="ml-0" >
                        <button type="button" class="w-20 h-8 ml-2 bg-indigo-500 text-white ml-0 hover:bg-indigo-600 rounded " onclick="location.href='{{ route('user.shop.index') }}'" >SHOP一覧</button>
                    </div>
            </div>
        </form>

    </x-slot>



    <div class="py-6 border">
        <div class=" mx-auto px-4 sm:px-4 lg:px-4 border ">
            <table class="w-full bg-white table-auto md:w-1/2 text-center whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">社名</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">店名</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">納品数</th>
                    <th class="w-2/8 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">納品額(千円)</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($s_ranks as $s_rank)


                <tr>
                    <td class="w-2/8 text-xs md:px-4 py-1">{{ $s_rank->co_name }}</td>
                    <td class="w-2/8 text-xs md:px-4 py-1">{{ $s_rank->shop_name }}</td>
                    <td class="w-2/8 text-xs pr-6 md:px-4 py-1 text-right">{{ number_format($s_rank->pcs)}}</td>
                    <td class="w-2/8 text-xs pr-10 md:px-4 py-1 text-right">{{ number_format(round($s_rank->kingaku)/1000)}}</td>
                </tr>
                @endforeach

                </tbody>
            </table>
            {{  $s_ranks->links()}}
        </div>



        <script>


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