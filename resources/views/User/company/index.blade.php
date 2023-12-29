
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            会社情報
        </h2>
        <div class="md:flex-auto p-1 text-gray-900 dark:text-gray-100  ">
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.company.search_m_form') }}'" >月別売上推移</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.company.search_w_form') }}'" >週別売上推移</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.company.search_u_form') }}'" >Unit別売上</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.company.search_s_form') }}'" >Season別売上</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.company.search_h_form') }}'" >品番別売上</button>
        </div>
        <div class="md:flex-auto p-1 text-gray-900 dark:text-gray-100  ">
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200 "  >******</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200 "  >******</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.company.search_uz_form') }}'" >Unit別在庫</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.company.search_sz_form') }}'" >Season別在庫</button>
            <button type="button" class="w-32 flex-auto p-0 text-sm text-gray-900 dark:text-gray-100 bg-gray-200  hover:bg-gray-300 rounded" onclick="location.href='{{ route('user.company.search_hz_form') }}'" >品番別在庫</button>
        </div>
    </x-slot>


    <div class="py-6">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="md:w-1/2 bg-white table-auto w-full text-center whitespace-no-wrap">
               <thead>
                    <tr>
                        <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">会社コード</th>
                        <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">社名</th>
                        <th class="w-3/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">詳細</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($companies as $company)
                    <tr>
                        <td class="w-2/12 pl-10 md:px-4 py-1 text-left"> {{ $company->id }} </td>
                        <td class="w-3/12 pl-4 md:px-4 py-1 text-left">{{ $company->co_name }}</td>
                        <td class="w-3/12 md:px-4 py-1 text-center"><a href="" class="w-20 h-8 text-indigo-500 ml-2 "  >詳細を見る</a></td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
            {{  $companies->links()}}
        </div>
    </div>



</x-app-layout>
