
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            店別日別納品<br>
        </h2>

        <span class="items-center text-sm mt-2" >　※店舗を選択してください　　　</span>

        <form method="get" action="{{ route('user.shop.s_search_wd_form')}}" class="mt-4">
        <div class="flex">
            <select class="w-40 h-8 text-sm items-center" id="sh_id" name="sh_id" type="number" class="border">
                <option value="0" @if(\Request::get('sh_id') == '0') selected @endif >全店</option>
                @foreach ($companies as $company)
                    <optgroup  label = "{{ $company->co_name }}" class="text-indigo-700 font-weight:bold">
                        @foreach ($company->shop as $shop )
                        <option  value="{{ $shop->id }}" @if(\Request::get('sh_id') == $shop->id) selected @endif >{{ $shop->shop_name }}</option>
                        @endforeach
                @endforeach
            </select>


        <div>
            <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.shop.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">SHOP一覧</button>
        </div>
        </div>
        </form>

    </x-slot>



        <div class="py-6 border">
        <div class=" w-full  sm:px-4 lg:px-4 border">
            <table class="md:w-1/2 table-auto bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead >
                <tr>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年月</th>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年週</th>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">日付</th>
                    <th class="w-1/4 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">納品額(千円)</th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($w_delivs as $w_deliv)
                <tr>
                    <td class="w-1/4 md:px-4 py-1">{{ $w_deliv->YM }}</td>
                    <td class="w-1/4 md:px-4 py-1">{{ $w_deliv->YW }}</td>
                    <td class="w-1/4 md:px-4 py-1">{{ $w_deliv->deliv_date }}</td>
                    <td class="w-1/4 pr-10 md:pr-10 py-1 text-right">{{ number_format(round($w_deliv->kingaku)/1000)}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>


    <script>
        const shop = document.getElementById('sh_id')
        shop.addEventListener('change', function(){
        this.form.submit()
        })




    </script>

</x-app-layout>



