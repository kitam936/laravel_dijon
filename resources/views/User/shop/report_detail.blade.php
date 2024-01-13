<x-app-layout>
    <x-slot name="header">

        <h2 class="font-semibold text-xl  text-gray-800 dark:text-gray-200 leading-tight">
        <div>
            店舗Report詳細
        </div>
        </h2>
        <div class="flex ml-8">
        <div class="ml-2 ">
            <button type="button" onclick="location.href='{{ route('user.shop.report_list') }}'" class="w-32 text-center text-sm text-white bg-indigo-400 border-0 py-1 px-2 focus:outline-none hover:bg-indigo-600 rounded ">店舗Report一覧</button>
        </div>
        <div class="ml-2 ">
            <button type="button" onclick="location.href='{{ route('user.shop.index') }}'" class="w-32 text-center text-sm text-white bg-indigo-400 border-0 py-1 px-2 focus:outline-none hover:bg-indigo-600 rounded ">店舗一覧</button>
        </div>

        @foreach ($reports as $report)
        <div class="ml-2 ">
            <button type="button" onclick="location.href='{{ route('user.shop.report_edit',['report'=>$report->id])}}'" class="w-32 text-center text-sm text-white bg-indigo-500 border-0 py-1 px-2 focus:outline-none hover:bg-indigo-600 rounded ">編集</button>
        </div>
        @endforeach
        </div>

    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">

                    <form method="get" action=""  enctype="multipart/form-data">

                        <div class="-m-2">
                            <div class="p-2 mx-auto">
                                @foreach ($reports as $report)

                                <div class="p-2 w-full mx-auto">
                                    <div class="relative">
                                        <label for="date" class="leading-7 text-sm  text-gray-800 dark:text-gray-200 leading-tight">date</label>
                                        <div  id="date" name="date" value="{{$report->created_at}}" class="h-10 text-lg w-full bg-gray-100 bg-opacity-50 rounded focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{$report->created_at}}
                                    </div>
                                    <div class="relative">
                                        <label for="name" class="leading-7 text-sm  text-gray-800 dark:text-gray-200 leading-tight">店名</label>
                                        <div  id="name" name="name" value="{{$report->shop_name}}" class="h-10 text-lg w-full bg-gray-100 bg-opacity-50 rounded focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{$report->shop_name}}
                                    </div>
                                    </div>
                                    <div class="p-2 mx-auto mb-1">
                                        <div class="relative">
                                            <label for="information" class="leading-7 text-sm  text-gray-800 dark:text-gray-200 leading-tight">コメント</label>
                                            <div id="information" name="information" rows="10" class="w-full bg-gray-100 bg-opacity-50 rounded focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{$report->comment}}</div>
                                        </div>
                                    </div>
                                {{-- <div class="px-2 md:w-2/1 mx-auto">
                                    <div class="relative flex">
                                    <div class="w-40 ml-2">
                                        <x-report-thumbnail :filename="$report->image1" />
                                    </div>
                                    <div class="w-40 ml-2">
                                        <x-report-thumbnail :filename="$report->image2" />
                                    </div>
                                    <div class="w-40 ml-2">
                                        <x-report-thumbnail :filename="$report->image3" />
                                    </div>
                                    <div class="w-40 ml-2">
                                        <x-report-thumbnail :filename="$report->image4" />
                                    </div>
                                    </div>
                                </div> --}}

                                <div class="px-2 md:w-2/3 mx-auto">

                                    <div class="w-full mb-1">
                                        @if(!empty($report->image1))
                                        <img src="{{ asset('storage/reports/'.$report->image1) }}">
                                        @endif
                                        {{-- <img src="{{ asset('storage/reports/'.$report->image1) }}"> --}}
                                    </div>
                                    <div class="w-full mb-1">
                                        @if(!empty($report->image2))
                                        <img src="{{ asset('storage/reports/'.$report->image2) }}">
                                        @endif
                                        {{-- <img src="{{ asset('storage/reports/'.$report->image2) }}"> --}}
                                    </div>
                                    <div class="w-full mb-1">
                                        @if(!empty($report->image3))
                                        <img src="{{ asset('storage/reports/'.$report->image3) }}">
                                        @endif
                                        {{-- <img src="{{ asset('storage/reports/'.$report->image3) }}"> --}}
                                    </div>
                                    <div class="w-full mb-1">
                                        @if(!empty($report->image4))
                                        <img src="{{ asset('storage/reports/'.$report->image4) }}">
                                        @endif
                                        {{-- <img src="{{ asset('storage/reports/'.$report->image4) }}"> --}}
                                    </div>

                                </div>

                                @endforeach
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
