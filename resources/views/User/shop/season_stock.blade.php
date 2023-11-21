
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            店別シーズン在庫<br><br>
            {{ $shops }} 店<br>
            <div class='flex font-semibold text-gray-800 dark:text-gray-200 leading-tight'>
            <div class='border bg-gray-100 h-6'>
                @foreach ($s_stocks as $s_stock)
                現在庫　：　{{ number_format($s_stock->zaikogaku) }}円　　{{ number_format($s_stock->pcs) }}枚　　　　
                @endforeach
            </div>
            <div>
            <button type="button" onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">戻る</button>
            </div>
            </div>
        </h2>
    </x-slot>

    <div class="py-6 border">


        <div class=" mx-auto sm:px-4 lg:px-4 border">

            <table class="w-2 bg-white table-auto md:w-1/2 text-center whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">シーズン</th>
                    <th class="w-1/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫数</th>
                    <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">在庫額</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($season_stocks as $season_stock)
                    {{-- @foreach ($h_stock->hinban as $hinban) --}}

                <tr>
                    <td class="w-2/12 md:px-4 py-1">{{ $season_stock->season_name }}</td>
                    <td class="w-1/12 md:px-4 py-1 text-right">{{ number_format($season_stock->pcs)}}</td>
                    <td class="w-2/12 md:px-4 py-1 text-right">{{ number_format($season_stock->zaikogaku)}}</td>
                </tr>
                @endforeach
                {{-- @endforeach --}}
                </tbody>
            </table>
        </div>

</x-app-layout>
