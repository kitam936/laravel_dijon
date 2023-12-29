
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            SHOP一覧
            {{-- <button type="button" onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">戻る</button> --}}
        </h2>
        <div class=" p-1 text-gray-900 dark:text-gray-100 md:flex-auto ">
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200   hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.shop.s_search_m_form') }}'" >月別売上推移</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200   hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.shop.s_search_w_form') }}'" >週別売上推移</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200   hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.shop.s_search_u_form') }}'" >Unit別売上</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200   hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.shop.s_search_s_form') }}'" >Season別売上</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200   hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.shop.s_search_h_form') }}'" >品番別売上</button>
        </div>
        <div class=" p-1 text-gray-900 dark:text-gray-100 md:flex-auto ">
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200 "  >******</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200 "  >******</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200   hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.shop.s_search_uz_form') }}'" >Unit別在庫</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200   hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.shop.s_search_sz_form') }}'" >Season別在庫</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200   hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.shop.s_search_hz_form') }}'" >品番別在庫</button>
        </div>

        <form method="get" action="{{ route('user.shop.index')}}" class="mt-4">

            <div class="md:flex">
                <div class="mb-2 md:flex mb-4">
                    <label class="items-center text-sm mt-2" >エリア　</label>
                        <select class="w-32 h-8 text-sm pt-1" id="ar_id" name="ar_id"  class="border">
                        <option value="" @if(\Request::get('ar_id') == '0') selected @endif >指定なし</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" @if(\Request::get('ar_id') == $area->id) selected @endif >{{ $area->ar_name }}</option>
                        @endforeach
                         </select>
                </div>
                <div class="flex mb-2 md:flex mb-4">
                    <label class="pr-1 items-center text-sm mt-2 md:ml-4" >会  社　</label>
                        <select class="w-32 h-8 text-sm pt-1 " id="co_id" name="co_id"  class="border">
                        <option value="" @if(\Request::get('co_id') == '0') selected @endif >指定なし</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}" @if(\Request::get('co_id') == $company->id) selected @endif >{{ $company->co_name }}</option>
                        @endforeach
                        </select><br>
                        <label class="items-center text-sm mt-2 ml-4" >店名 　</label>
                        <input class="w-44 h-8 text-sm pt-1" id="sh_name" placeholder="店名入力（一部でも可）" name="sh_name"  class="border">
                </div>
                <div class="ml-80 md:ml-4">
                    <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">全表示</button>
                </div>

            </div>
        </form>
    </x-slot>

    <div class="py-0 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="md:w-2/3 bg-white table-auto w-full text-center whitespace-no-wrap">
               <thead>
                    <tr>
                        <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">エリア</th>
                        <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">社名</th>
                        <th class="w-4/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">店名</th>
                        <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">詳細</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($shops as $shop)
                    <tr>
                        <td class="w-2/12 md:px-4 py-1 text-left"> {{ $shop->ar_name }} </td>
                        <td class="w-3/12 md:px-4 py-1 text-left">{{ $shop->co_name }}</td>
                        <td class="w-4/12 md:px-4 py-1 text-left">{{ $shop->shop_name }}</td>
                        <td class="w-3/12 md:px-4 py-1 text-center"><a href="{{ route('user.shop.show',['shop'=>$shop->id]) }}" class="w-20 h-8 text-indigo-500 ml-2 "  >店舗詳細</a></td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
            {{  $shops->appends([
                'co_id'=>\Request::get('co_id'),
                'ar_id'=>\Request::get('ar_id'),
                'sh_id'=>\Request::get('sh_id'),
            ])->links()}}
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