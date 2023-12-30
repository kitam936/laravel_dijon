
<x-app-layout>
    <x-slot name="header">
        <div class="flex">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            店舗詳細
            {{-- <button type="button" onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">戻る</button> --}}
        </h2>
        <div class="ml-60 mt-0 md:mt-0">
            <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">shop一覧</button>
        </div>
        </div>



        <form method="get" action="" class="mt-4">

            <div class="md:flex">
                @foreach ($shops as $shop)
                <div class="flex">
                <div class="flex pl-2 mt-2">
                    社名：
                    <div class="pl-2  ml-8 md:ml-2 w-32 h-8 items-center bg-gray-100 border" name="co_id"  value="">{{ $shop->co_name }}</div>
                </div>
                <div class="flex pl-2 mt-1">
                    エリア：
                    <div class="pl-2 w-32 h-8 items-center bg-gray-100 border" name="ar_id" value="">{{ $shop->ar_name }}</div>
                </div>
                </div>
                <div class="flex">
                <div class="flex pl-2 mt-1">
                    店舗コード：
                    <div class="pl-2 w-32 h-8 items-center bg-gray-100 border" name="sh_id" value="">{{ $shop->id }}</div>
                </div>
                <div class="flex pl-2 mt-1">
                    店名：
                    <div class="pl-2 w-32 h-8 items-center bg-gray-100 border" name="sh_name" value="">{{ $shop->shop_name }}</div>
                </div>
                </div>
                <div class="md:flex">
                <div class="flex pl-2 mt-1">
                    info :
                    <div class="pl-2 ml-2 md:ml-2 w-80 h-8 items-center bg-gray-100 border" name="sh_info" value="">{{ $shop->shop_info }}</div>
                </div>

                </div>
                @endforeach



            </div>
        </form>
    </x-slot>



    <div class="py-6 border">
        <span class="items-center text-lg mt-2" >　　店舗Report</span>
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="md: bg-white table-auto w-full text-center whitespace-no-wrap">
               <thead>
                    <tr>
                        <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Date</th>
                        <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">エリア</th>
                        <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">社名</th>
                        <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">店名</th>
                        <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">詳細</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($reports as $report)
                    <tr>
                        <td class="w-2/12 md:px-4 py-1 text-left">  {{ $report->created_at }} </td>
                        <td class="w-2/12 md:px-4 py-1 text-left">  {{ $report->ar_name }} </td>
                        <td class="w-2/12 md:px-4 py-1 text-left">  {{ $report->co_name }} </td>
                        <td class="w-3/12 md:px-4 py-1 text-left">  {{ $report->shop_name }} </td>
                        <td class="w-3/12 md:px-4 py-1 text-center"><a href="{{ route('user.shop.report_detail',['id'=>$report->id]) }}" class="w-20 h-8 text-indigo-500 ml-2 "  >Report詳細</a></td>
                    </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    </div>







</x-app-layout>
