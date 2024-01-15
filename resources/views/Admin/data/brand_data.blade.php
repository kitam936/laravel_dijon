<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <div class="flex">
            <div>
            BRANDデータ
            </div>
            <div class="w-40 ml-60 text-sm items-right mb-0">
                <button onclick="location.href='{{ route('admin.data.data_index') }}'" class="text-white bg-indigo-400 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-ml">戻る</button>
            </div>
            </div>
        </h2>
        <x-flash-message status="session('status')"/>

    </x-slot>

    <div class="py-6 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="md:w-2/3 bg-white table-auto text-center whitespace-no-wrap">
               <thead>
                    <tr>
                        <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">Brand_id</th>
                        <th class="w-4/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">BRAND名</th>
                        <th class="w-2/12 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">info</th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($brands as $brand)
                    <tr>
                        <td class="w-2/12 md:px-4 py-1">{{ $brand->id }}</td>
                        <td class="w-4/12 md:px-4 py-1"> {{ $brand->br_name }}</td>
                        <td class="w-2/12 md:px-4 py-1"> {{ $brand->br_info }}</td>


                    </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

</x-app-layout>
