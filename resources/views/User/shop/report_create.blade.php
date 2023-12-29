<x-app-layout>
    <x-slot name="header">
        <div >
            <h2 class="mb-4 font-semibold text-xl text-gray-800 leading-tight">
            <div>
                店舗Report登録
            </div>
            </h2>
            <div class="flex">
            <div class="ml-10 mb-2">
                <button type="button" onclick="location.href='{{ route('user.shop.report_list') }}'" class="w-32 flex-auto p-1 text-sm text-gray-900 dark:text-gray-100 bg-gray-200   hover:bg-gray-300 rounded">店舗Report一覧</button>
            </div>
            <div class="ml-4 mb-2">
                <button type="button" onclick="location.href='{{ route('user.shop.index') }}'" class="w-32 flex-auto p-1 text-sm text-gray-900 dark:text-gray-100 bg-gray-200   hover:bg-gray-300 rounded">店舗一覧</button>
            </div>
            </div>
        </div>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- <x-input-error :messages="$errors->get('image')" class="mt-2" /> --}}
                    <form method="post" action="{{ route('user.shop.report_store')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="-m-2">
                        <div class="mb-0">
                            <span class="items-center text-sm mt-2" >店舗： 　</span>
                            <select class="w-40 h-8 text-sm items-center pt-1" id="sh_id" name="sh_id" type="number" class="border">
                                <option value="{{ old('name') }}">店舗選択※必須</option>
                                @foreach ($companies as $company)
                                    <optgroup  label = "{{ $company->co_name }}" class="text-indigo-700 font-weight:bold">
                                        @foreach ($company->shop as $shop )
                                        <option  value="{{ $shop->id }}" >{{ $shop->shop_name }}</option>
                                        @endforeach
                                @endforeach
                            </select>

                        </div>

                        <div class="p-2 mx-auto">
                            <div class="relative">
                              <label for="comment" class="leading-7 text-sm text-gray-600">comment※必須</label>
                              <textarea id="comment" name="comment" rows="8" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ old('comment') }}</textarea>
                            </div>
                        </div>
                        <div class="p-0 flex">
                        <div class="relative">
                            <label for="image1" class="leading-7 text-sm text-gray-600">画像1</label>
                            <input type="file" id="image1" name="image1" multiple accept=“image/png,image/jpeg,image/jpg” class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative">
                            <label for="image2" class="leading-7 text-sm text-gray-600">画像2</label>
                            <input type="file" id="image2" name="image2" multiple accept=“image/png,image/jpeg,image/jpg” class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative">
                            <label for="image3" class="leading-7 text-sm text-gray-600">画像3</label>
                            <input type="file" id="image3" name="image3" multiple accept=“image/png,image/jpeg,image/jpg” class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative">
                            <label for="image4" class="leading-7 text-sm text-gray-600">画像4</label>
                            <input type="file" id="image4" name="image4" multiple accept=“image/png,image/jpeg,image/jpg” class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        </div>


                        <div class="p-2 w-1/2 mx-auto">

                          <div class="p-2 w-full mt-4 flex justify-around">

                            <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録</button>
                          </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

