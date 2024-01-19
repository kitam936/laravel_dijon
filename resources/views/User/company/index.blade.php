
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            会社情報
        </h2>
        <div class="md:flex-auto p-1 text-gray-900 dark:text-gray-100  ">
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_m_form') }}'" >月別売上推移</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_w_form') }}'" >週別売上推移</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_u_form') }}'" >Unit別売上</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_s_form') }}'" >Season別売上</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_h_form') }}'" >品番別売上</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.c_sales_rank') }}'" >期間売上</button>
        </div>
        <div class="md:flex-auto p-1 text-gray-900 dark:text-gray-100  ">
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_md_form') }}'" >月別納品推移</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_wd_form') }}'" >日別納品推移</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_ud_form') }}'" >Unit別納品</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_sd_form') }}'" >Season別納品</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_hd_form') }}'" >品番別納品</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.c_delivs_rank') }}'" >期間納品</button>
        </div>
        <div class="md:flex-auto p-1 text-gray-900 dark:text-gray-100  ">
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_uz_form') }}'" >Unit別在庫</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_sz_form') }}'" >Season別在庫</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-white dark:text-white bg-indigo-400  hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.company.search_hz_form') }}'" >品番別在庫</button>

        </div>
    </x-slot>


    <div class="py-6">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="md:w-1/2 bg-white table-auto w-full text-center whitespace-no-wrap">
               <thead>
                    <tr>
                        <th class="w-1/2 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">会社コード</th>
                        <th class="w-1/2 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">社名</th>
                        {{-- <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">詳細</th> --}}

                    </tr>
                </thead>

                <tbody>
                    @foreach ($companies as $company)
                    <tr>
                        <td class="w-1/2 pl-4 md:px-4 py-1 text-center"> {{ $company->id }} </td>
                        <td class="w-1/2 pl-4 md:px-4 py-1 text-center">{{ $company->co_name }}</td>
                        {{-- <td class="w-3/12 md:px-4 py-1 text-center"><a href="" class="w-20 h-8 text-indigo-500 ml-2 "  >詳細を見る</a></td> --}}
                    </tr>
                    @endforeach

                </tbody>

            </table>
            {{  $companies->links()}}
        </div>
    </div>



</x-app-layout>
