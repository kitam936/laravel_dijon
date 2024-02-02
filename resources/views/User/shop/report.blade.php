
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        店舗Report一覧

        </h2>
        <x-flash-message status="session('status')"/>

        <form method="get" action="{{ route('user.shop.report_list')}}" class="mt-4">
            <span class="items-center text-sm mt-2 text-gray-800 dark:text-gray-200 leading-tight" >※エリア・会社を選択してください　　　</span>
            <div class="md:flex">
                <div class="flex">
                    <div class="mb-2 ml-00 md:flex mb-2">
                        {{--  <label class="items-center text-sm mt-2 text-gray-800 dark:text-gray-200 leading-tight" >エリア　</label>  --}}
                        <select class="w-32 h-8 rounded text-sm pt-1" id="ar_id" name="ar_id"  class="border">
                        <option value="" @if(\Request::get('ar_id') == '0') selected @endif >全エリア</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" @if(\Request::get('ar_id') == $area->id) selected @endif >{{ $area->ar_name }}</option>
                        @endforeach
                            </select>
                    </div>
                    <div class="flex ml-2 mb-2 md:flex mb-2">
                        {{--  <label class="pr-1 items-center text-sm mt-2 md:ml-4 text-gray-800 dark:text-gray-200 leading-tight" >会  社　</label>  --}}
                            <select class="w-32 h-8 ml-2 rounded text-sm pt-1 " id="co_id" name="co_id"  class="border">
                            <option value="" @if(\Request::get('co_id') == '0') selected @endif >全社</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}" @if(\Request::get('co_id') == $company->id) selected @endif >{{ $company->co_name }}</option>
                            @endforeach
                            </select><br>
                    </div>
                </div>
                <div class="flex">
                    <div class="ml-0 md:ml-2">
                        {{--  <span class="items-center text-sm mt-2  text-gray-800 dark:text-gray-200 leading-tight" >店名　:</span>  --}}
                        <input class="w-52 h-8 ml-0 rounded text-sm md:ml-4" id="sh_name" placeholder="店名検索入力(一部でも)" name="sh_name" >
                    </div>
                    <div class="ml-2 md:ml-4">
                        <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.report_list') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">全表示</button>
                    </div>

                </div>
            </div>
        </form>


    </x-slot>



    <div class="py-6 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="md:w-2/3 bg-white table-auto w-full text-center whitespace-no-wrap">
               <thead>
                    <tr>
                        {{-- <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">id</th> --}}
                        <th class="w-3/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Date</th>
                        <th class="w-2/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">エリア</th>
                        <th class="w-4/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">社名</th>
                        <th class="w-4/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">店名</th>
                        <th class="w-2/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">詳細</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($reports as $report)
                    <tr>
                        {{-- <td class="w-2/12 md:px-4 py-1 text-left">  {{ $report->id }} </td> --}}
                        <td class="w-3/15 text-sm md:px-4 py-1 text-left">  {{ Str::limit($report->created_at,10) }} </td>
                        <td class="w-2/15 pr-2 text-sm md:px-4 py-1 text-left">  {{ Str::limit($report->ar_name,8) }} </td>
                        <td class="w-4/15 text-sm md:px-4 py-1 text-left">  {{ Str::limit($report->co_name,10) }} </td>
                        <td class="w-4/15 pl-2 text-sm md:px-4 py-1 text-left">  {{ Str::limit($report->shop_name,12) }} </td>
                        <td class="w-2/15 text-sm md:px-4 py-1 text-center"><a href="{{ route('user.shop.report_detail',['id'=>$report->id]) }}" class="w-20 h-8 text-indigo-500 ml-2 "  >詳細</a></td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
            {{ $reports->links() }}
        </div>
    </div>

    <script>
        const company = document.getElementById('co_id')
        company.addEventListener('change', function(){
        this.form.submit()
        })

        const area = document.getElementById('ar_id')
        area.addEventListener('change', function(){
        this.form.submit()
        })

        const shop = document.getElementById('sh_name')
        shop.addEventListener('change', function(){
        this.form.submit()
        })

    </script>


</x-app-layout>
