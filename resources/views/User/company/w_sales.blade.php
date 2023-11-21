

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            社別週別売上<br><br>
            {{ $companies }}<br>
            <div class='flex font-semibold text-gray-800 dark:text-gray-200 leading-tight'>
                <div class='border bg-gray-100 h-6'>
                @foreach ($c_stocks as $c_stock)
                現在庫　：　{{ number_format($c_stock->zaikogaku) }}円　　{{ number_format($c_stock->pcs) }}枚　　　　
                @endforeach
            </div>
            <div>
                <button type="button" onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">戻る</button>
            </div>
            </div>

        </h2>

    </x-slot>

    <div class="py-6 border">


        <div class=" mx-auto sm:px-4 lg:px-4 border ">


            <table class="md:w-1/2 bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年月</th>
                    <th class="md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年週</th>
                    <th class="md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">週売上</th>
                </tr>
                </thead>

                <tbody>
                    @foreach ($w_sales as $w_sale)
                <tr>
                    <td class="md:px-4 py-1">{{ $w_sale->YM }}</td>
                    <td class="md:px-4 py-1">{{ $w_sale->YW }}</td>
                    <td class="md:px-4 py-1 text-right">{{ number_format($w_sale->kingaku)}}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

</x-app-layout>
