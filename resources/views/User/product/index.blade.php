
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            商品一覧
            {{-- <button type="button" onclick="location.href='{{ route('user.company.index') }}'" class="mb-2 ml-2 text-right text-black bg-indigo-300 border-0 py-0 px-2 focus:outline-none hover:bg-indigo-300 rounded ">戻る</button> --}}
        </h2>
        <x-flash-message status="session('status')"/>
        <form method="get" action="{{ route('user.product.index')}}" class="mt-4">

            <div class="lg:flex">
                <div class="md:flex">
                    <label for="year_code" class="items-center text-sm mt-2" >年度CD：</label>
                    <select class="w-24 h-8 text-sm pt-1 mr-2 mb-2" id="year_code" name="year_code" type="number" class="border">
                    <option value="" @if(\Request::get('year_code') == '999') selected @endif >指定なし</option>
                    @foreach ($years as $year)
                        <option value="{{ $year->year_code }}" @if(\Request::get('year_code') == $year->year_code ) selected @endif >{{ $year->year_code  }}</option>
                    @endforeach
                    </select>
                    <label for="brand_code" class="items-center text-sm mt-2 " >Brand：</label>
                    <select class="w-24 h-8 text-sm pt-1 border mb-2 mr-4 " id="brand_code" name="brand_code" type="number" >
                    <option value="" @if(\Request::get('brand_code') == '0') selected @endif >指定なし</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->id }}" @if(\Request::get('brand_code') == $brand->id ) selected @endif >{{ $brand->id  }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="md:flex">
                    <label for="season_code" class="items-center text-sm mt-2" >季節CD：</label>
                    <select class="w-24 h-8 text-sm pt-1 mr-4 mb-2 border " id="season_code" name="season_code" type="number" >
                    <option value="" @if(\Request::get('season_code') == '999') selected @endif >指定なし</option>
                    @foreach ($seasons as $season)
                        <option value="{{ $season->season_id }}" @if(\Request::get('season_code') == $season->season_id ) selected @endif >{{ $season->season_name  }}</option>
                    @endforeach
                    </select>
                    <label for="unit_code" class="items-center text-sm mt-2 " >Unit：</label>
                    <select class="w-24 h-8 text-sm pt-1 mr-4 mb-2 border " id="unit_code" name="unit_code" type="number" >
                    <option value="" @if(\Request::get('unit_code') == '0') selected @endif >指定なし</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" @if(\Request::get('unit_code') == $unit->id ) selected @endif >{{ $unit->id  }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="flex">
                    <label for="hinban_code" class="items-center text-sm mt-2 mr-1" >品番CD：</label>
                    <input class="w-44 h-8 text-sm pt-1" id="hinban_code" placeholder="品番入力（一部でも可）" name="hinban_code" type="number" class="border">
                    <div>
                    <button  type="button" class="w-24 h-8 ml-2 text-center text-gray-900 bg-gray-200 border-0 py-0 px-2 focus:outline-none hover:bg-gray-300 rounded">品番検索</button>
                    </div>

                </div>
                <div class="pl-2">
                    <button type="button" class="w-20 h-8 bg-indigo-500 text-white ml-0 hover:bg-indigo-600 rounded lg:ml-2 " onclick="location.href='{{ route('user.product.index') }}'" >全表示</button>
                </div>

            </div>


        </form>


    </x-slot>




    @if(\Request::get('year_code') =='0')

    <div class="py-6 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border ">
            <table class="md: bg-white table-auto w-full text-center whitespace-no-wrap">
               <thead>
                    <tr>
                        <th class="w-1/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年</th>
                        <th class="w-1/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">BR</th>
                        <th class="w-2/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">季節</th>
                        <th class="w-1/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">UNIT</th>
                        <th class="w-1/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品番</th>
                        <th class="w-1/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品名</th>
                        <th class="w-3/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">元売価</th>
                        <th class="w-3/15 md:px-4 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">現売価</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td class="w-1/15 md:px-4 py-1"> {{ $product->year_code }} </td>
                        <td class="w-1/15 md:px-4 py-1">{{ $product->brand_id }}</td>
                        <td class="w-1/15 md:px-4 py-1">{{ $product->season_name }}</td>
                        <td class="w-1/15 md:px-4 py-1"> {{ $product->unit_id }}</td>
                        <td class="w-2/15 md:px-4 py-1"> {{ $product->hinabn_id }}</td>
                        <td class="w-4/15 md:px-4 py-1 text-left">{{ $product->hinmei }}</td>
                        <td class="w-1/15 md:px-4 py-1 text-right">{{ number_format($product->m_price )}}</td>
                        <td class="w-1/15 md:px-4 py-1 text-right">{{ number_format($product->price )}}</td>
                        <td class="w-1/15 md:px-4 py-1 text-right"><a href="{{ route('user.product.h_shop_zaiko',['hinban'=>$product->id]) }}" class="w-20 h-8 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded"  >在庫確認</a></td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
            {{  $products->appends([
                'year_code'=>\Request::get('year_code'),
                'brand_code'=>\Request::get('brand_code'),
                'season_code'=>\Request::get('season_code'),
                'unit_code'=>\Request::get('unit_code'),
            ])->links()}}
        </div>

    @else

    <div class="py-6 border">
        <div class=" mx-auto sm:px-4 lg:px-4 border">
            <table class="md: bg-white table-auto w-full text-center whitespace-no-wrap">
                <thead>
                    <tr>
                        <th class="w-1/15 h-4 md:px-2 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">年</th>
                        <th class="w-1/15 h-4 md:px-2 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">BR</th>
                        <th class="w-3/15 h-4 md:px-2 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">季節</th>
                        <th class="w-1/15 h-4 md:px-2 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">UNIT</th>
                        <th class="w-1/15 h-4 md:px-2 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品番</th>
                        <th class="w-4/15 h-4 md:px-2 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">品名</th>
                        <th class="w-1/15 h-4 md:px-2 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">元売価</th>
                        <th class="w-1/15 h-4 md:px-2 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">現売価</th>
                        <th class="w-2/15 h-4 md:px-2 py-1 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100"></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($products_sele as $product)
                    <tr>
                        <td class="w-1/15 h-2 md:px-2 py-0"> {{ $product->year_code }} </td>
                        <td class="w-1/15 h-2 md:px-2 py-0">{{ $product->brand_id }}</td>
                        <td class="w-3/15 h-2 text-sm md:px-2 py-0 md:text-ml">{{ $product->season_name }}</td>
                        <td class="w-1/15 h-2 md:px-2 py-0"> {{ $product->unit_id }}</td>
                        <td class="w-1/15 h-2 md:px-2 py-0"> {{ $product->id }}</td>
                        <td class="w-4/15 h-2 pl-2 text-sm md:px-2 py-0 text-left ">{{ $product->hinmei }}</td>
                        <td class="w-1/15 h-2 px-2 md:px-2 py-0 text-right">{{ number_format($product->m_price )}}</td>
                        <td class="w-1/15 h-2 px-2 md:px-2 py-0 text-right">{{ number_format($product->price )}}</td>
                        {{-- <td type="button" class="w-20 h-6 bg-indigo-500 text-white ml-2 hover:bg-indigo-600 rounded"  >在庫確認</button> --}}
                        <td class="w-2/15 h-2 text-sm px-2 py-1"><a href="{{route('user.product.h_shop_zaiko',['hinban'=>$product->id]) }}" class=text-blue-500>在庫</td>
                    </tr>
                    @endforeach

                </tbody>

            </table>
            {{  $products_sele->appends([
                'year_code'=>\Request::get('year_code'),
                'brand_code'=>\Request::get('brand_code'),
                'season_code'=>\Request::get('season_code'),
                'unit_code'=>\Request::get('unit_code'),
                'hinban_code'=>\Request::get('hinban_code'),
            ])->links()}}
        </div>
    </div>
    </div>
    @endif

    <script>
        const year = document.getElementById('year_code')
        year.addEventListener('change', function(){
        this.form.submit()
        })

        const brand = document.getElementById('brand_code')
        brand.addEventListener('change', function(){
        this.form.submit()
        })

        const season = document.getElementById('season_code')
        season.addEventListener('change', function(){
        this.form.submit()
        })

        const unit = document.getElementById('unit_code')
        unit.addEventListener('change', function(){
        this.form.submit()
        })

        const hinban = document.getElementById('hinban_code')
        hinban.addEventListener('change', function(){
        this.form.submit()
        })

    </script>

</x-app-layout>
