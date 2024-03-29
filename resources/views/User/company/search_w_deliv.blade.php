
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            社別日別納品<br>

        </h2>

        <span class="items-center text-sm mt-2 text-gray-800 dark:text-gray-200 leading-tight" >　※Brand・会社を選択してください　　　</span>

        <form method="get" action="{{ route('user.company.search_wd_form')}}" class="mt-4">
        <div class="flex">
            <select class="w-32 h-8 rounded text-sm pt-1 border mb-2 mr-2 " id="brand_code" name="brand_code" type="number" >
                <option value="" @if(\Request::get('brand_code') == '0') selected @endif >全ブランド</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" @if(\Request::get('brand_code') == $brand->id ) selected @endif >{{ $brand->br_name  }}</option>
                @endforeach
            </select>
            <select class="w-32 h-8 rounded text-sm pt-1" id= "co_id" name="co_id" type="text" class="border">
                <option value="" @if(\Request::get('co_id') == '0') selected @endif >全社</option>
                @foreach ($companies as $company)
                    <option value="{{ $company->id }}" @if(\Request::get('co_id') == $company->id) selected @endif >{{ $company->co_name }}</option>
                @endforeach
            </select>

        <div>
            <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">会社一覧</button>
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
                    <td class="w-1/4 pr-8 md:px-4 py-1 text-right"><span style="font-variant-numeric:tabular-nums"> {{ number_format(round($w_deliv->kingaku)/1000)}}</span></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    {{-- @endif --}}

    <script>
        const company = document.getElementById('co_id')
        company.addEventListener('change', function(){
        this.form.submit()
        })

        const brand = document.getElementById('brand_code')
        brand.addEventListener('change', function(){
        this.form.submit()
        })



    </script>


</x-app-layout>



