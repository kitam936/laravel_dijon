
<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            店舗詳細
            {{-- <button type="button" onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">戻る</button> --}}
        </h2>
        <div class="ml-2 flex md:ml-60">
        <div class="ml-0 mt-2 md:mt-0 md:ml-60">
            <button type="button" class="w-40 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.index') }}'" >shop一覧</button>
        </div>

        <div class="ml-00 mt-2 md:ml-4 md:mt-0">
            @foreach ($shops as $shop)
            <button type="button" class="w-40 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.report_create',['shop'=>$shop->id]) }}'" >新規Report</button>
            @endforeach
        </div>
        </div>




        <form method="get" action="" class="mt-2 mb-4">

            <div class="md:flex">
                @foreach ($shops as $shop)
                <div class="flex">
                <div class="flex pl-0 mt-0">

                    <div class="pl-2 ml-0 md:ml-2 w-32 h-6 items-center bg-gray-100 border rounded" name="co_id"  value="">{{ $shop->co_name }}</div>
                </div>
                <div class="flex pl-2 mt-0">

                    <div class="pl-2 w-32 h-6 items-center bg-gray-100 border rounded" name="ar_id" value="">{{ $shop->ar_name }}</div>
                </div>
                </div>
                <div class="flex">
                <div class="flex pl- mt-1 md:mt-0">

                    <div class="pl-2 w-32 h-6 items-center bg-gray-100 border rounded md:ml-2" name="sh_id" value="">{{ $shop->id }}</div>
                </div>
                <div class="flex pl-2 mt-1 md:mt-0 ">

                    <div class="pl-2 w-32 h-6 items-center bg-gray-100 border rounded" name="sh_name" value="">{{ $shop->shop_name }}</div>
                </div>
                </div>
                <div class="md:flex">
                <div class="flex pl-0 mt-1 md:mt-0">

                    <div class="pl-2 ml-0 md:ml-2 w-80 h-6 items-center bg-gray-100 border rounded" name="sh_info" value="">{{ $shop->shop_info }}</div>
                </div>

                </div>
                @endforeach
            </div>
     </form>
            <div class=" p-1 text-gray-900 dark:text-gray-100 md:flex-auto md:mt-6">
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_m_form',['shop'=>$shop->id]) }}'" >月別売上推移</button>
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_w_form',['shop'=>$shop->id]) }}'" >週別売上推移</button>
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_u_form',['shop'=>$shop->id]) }}'" >Unit別売上</button>
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_s_form',['shop'=>$shop->id]) }}'" >Season別売上</button>
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_h_form',['shop'=>$shop->id]) }}'" >品番別売上</button>
            </div>
            <div class=" p-1 text-gray-900 dark:text-gray-100 md:flex-auto ">
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_md_form',['shop'=>$shop->id]) }}'" >月別納品推移</button>
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_wd_form',['shop'=>$shop->id]) }}'" >日別納品推移</button>
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_ud_form',['shop'=>$shop->id]) }}'" >Unit別納品</button>
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_sd_form',['shop'=>$shop->id]) }}'" >Season別納品</button>
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_hd_form',['shop'=>$shop->id]) }}'" >品番別納品</button>
            </div>
            <div class=" p-1 text-gray-900 dark:text-gray-100 md:flex-auto ">
                {{-- <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200 "  >******</button> --}}
                {{-- <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200 "  >******</button> --}}
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_uz_form',['shop'=>$shop->id]) }}'" >Unit別在庫</button>
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_sz_form',['shop'=>$shop->id]) }}'" >Season別在庫</button>
                <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.s_hz_form',['shop'=>$shop->id]) }}'" >品番別在庫</button>
            </div>


    </x-slot>



    <div class="py-6 border">
        <span class="items-center text-lg mt-2 text-gray-800 dark:text-gray-200 leading-tight" >　　店舗Report</span>
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="md: bg-white table-auto w-full text-center whitespace-no-wrap">
               <thead>
                    <tr>
                        <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Date</th>
                        <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">エリア</th>
                        <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">社名</th>
                        <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">店名</th>
                        <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">詳細</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($reports as $report)
                    <tr>
                        <td class="w-2/12 md:px-4 py-1 text-left">  {{ Str::limit($report->created_at,10) }} </td>
                        <td class="w-2/12 md:px-4 py-1 text-left">  {{ $report->ar_name }} </td>
                        <td class="w-3/12 md:px-4 py-1 text-left">  {{ Str::limit($report->co_name,10) }} </td>
                        <td class="w-3/12 md:px-4 py-1 text-left">  {{ Str::limit($report->shop_name,10) }} </td>
                        <td class="w-2/12 md:px-4 py-1 text-center"><a href="{{ route('user.shop.report_detail',['id'=>$report->id]) }}" class="w-20 h-8 text-indigo-500 ml-2 "  >詳細</a></td>
                    </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    </div>







</x-app-layout>
