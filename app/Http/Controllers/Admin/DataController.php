<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use \SplFileObject;
use Throwable;
use App\Models\Stock;
use App\Models\Shop;
use App\Models\Sale;
use App\Models\Company;
use App\Models\Area;
use App\Models\Brand;
use App\Models\Delivery;
use App\Models\Hinban;
use App\Models\Unit;

class DataController extends Controller
{

    public function __construct(){
        $this->middleware('auth:admin');
        }

    public function index()
    {
        return view('admin.data.data_index');
    }


    public function create()
    {
        return view('admin.data.data_create');
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    public function unit_index(Request $request)
    {
        $units=Unit::All();

        return view('admin.data.unit_data',compact('units'));
    }

    public function brand_index(Request $request)
    {
        $brands=Brand::All();

        return view('admin.data.brand_data',compact('brands'));
    }

    public function hinban_index(Request $request)
    {
        $products=Hinban::with('unit')
        ->where('year_code','LIKE','%'.$request->year_code.'%')
        ->where('brand_id','LIKE','%'.$request->brand_code.'%')
        ->where('unit_id','LIKE','%'.$request->unit_code.'%')
        ->paginate(15);
        $years=DB::table('hinbans')
        ->select(['year_code'])
        ->groupBy(['year_code'])
        ->orderBy('year_code','desc')
        ->get();
        $units=DB::table('units')
        ->select(['id'])
        ->groupBy(['id'])
        ->orderBy('id','asc')
        ->get();
        $brands=DB::table('brands')
        ->select(['id'])
        ->groupBy(['id'])
        ->orderBy('id','asc')
        ->get();
        return view('admin.data.hinban_data',compact('products','years','units','brands'));
    }

    public function area_index(Request $request)
    {
        $areas=Area::All();

        return view('admin.data.area_data',compact('areas'));
    }

    public function company_index(Request $request)
    {
        $companies=Company::All();

        return view('admin.data.company_data',compact('companies'));
    }

    public function shop_index(Request $request)
    {
        $shops=Shop::with('area')->with('company')
        ->where('company_id','LIKE','%'.$request->co_id.'%')->paginate(15);
        $companies = Company::where('id','LIKE','%'.$request->co_id.'%')->select('id','co_name')->get();

        return view('admin.data.shop_data',compact('shops','companies'));
    }

    public function sales_index()
    {
        $sales=Sale::with('shop.company')
        ->orderby('sales_date','desc')->paginate(15);
        return view('admin.data.sales_data',compact('sales'));
    }

    public function delivery_index()
    {
        $delivs=Delivery::with('shop.company')->orderby('deliv_date','desc')->paginate(15);
        return view('admin.data.deliv_data',compact('delivs'));
    }

    public function stock_index()
    {
        $stocks=Stock::with('shop.company')->paginate(15);
        return view('admin.data.stock_data',compact('stocks'));
    }

    public function delete_index()
    {
        $YWs=DB::table('sales')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();
        $max_YM=Sale::max('YM');
        $max_YW=Sale::max('YW');

        return view('admin.data.delete_index',compact('max_YM','max_YW','YWs'));
    }

    public function shop_edit($id)
    {
        $shop=Shop::findOrFail($id);
        return view('admin.data.shop_edit',compact('shop'));
    }

    public function shop_update(Request $request, $id)
    {
        $shop=Shop::findOrFail($id);
        $shop->company_id=$request->co_id;
        $shop->shop_name=$request->sh_name;
        $shop->shop_info=$request->sh_info;
        $shop->area_id=$request->ar_id;
        $shop->is_selling=$request->is_selling;
        $shop->save();

        return to_route('admin.data.shop_index')->with(['message'=>'更新されました','status'=>'info']);
    }

    public function shop_destroy($id)
    {
        // dd('delete');
        Shop::findOrFail($id)->delete();

        return to_route('admin.data.shop_index')->with(['message'=>'削除されました','status'=>'alert']);
    }

    public function sales_destroy(Request $request)
    {
        DB::table('sales')
        ->where('sales.YW','>=',($request->YW1))
        ->where('sales.YW','<=',($request->YW2))
        ->delete();

        return to_route('admin.data.delete_index')->with(['message'=>'削除されました','status'=>'alert']);
    }

    public function deliv_destroy(Request $request)
    {
        DB::table('deliveries')
        ->where('deliveries.YW','>=',($request->YW3))
        ->where('deliveries.YW','<=',($request->YW4))
        ->delete();

        return to_route('admin.data.delete_index')->with(['message'=>'削除されました','status'=>'alert']);
    }



    public function stock_upload(Request $request)
    {
        $Stocks=Stock::query()->delete();

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        // dd($request);
		$file = $request->file('stock_data');
        // dd($file);

        file_put_contents($file, mb_convert_encoding(file_get_contents($file), 'UTF-8', 'SJIS-win'));


        DB::beginTransaction();

        try{
			//ファイルの読み込み
			$csv_arr = new \SplFileObject($file);
			$csv_arr->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

			//csvの値格納用配列
			$data_arr = [];

            $count = 0; // 登録件数確認用

			foreach($csv_arr as $i=>$line){
				if ($line === [null]) continue;
				if($i == 0) continue;

				//配列に格納
				$data_arr[$i]['id'] = $line[0];
				$data_arr[$i]['shop_id'] = $line[1];
				$data_arr[$i]['hinban_id'] = $line[2];
				$data_arr[$i]['pcs'] = $line[3];
                $data_arr[$i]['zaikogaku'] = $line[4];
				$data_arr[$i]['created_at'] = $line[5];
				$data_arr[$i]['updated_at'] = $line[6];

                $count++;
			}

                //保存

			foreach(array_chunk($data_arr, 500) as $chunk){
				DB::transaction(function() use ($chunk){
					DB::table('stocks')->insert($chunk);

				});

			}

			DB::commit();

            return view('admin.data.result',compact('count'));

		}catch(Throwable $e){
			DB::rollback();
            Log::error($e);
            // throw $e;
            return to_route('admin.data.create')->with(['message'=>'エラーにより処理を中断しました。csvデータを確認してください。','status'=>'alert']);
		}
    }







    public function sales_upload(Request $request)
    {

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        // dd($request);
		$file = $request->file('sales_data');
        // dd($file);

        file_put_contents($file, mb_convert_encoding(file_get_contents($file), 'UTF-8', 'SJIS-win'));


        DB::beginTransaction();

        try{
			//ファイルの読み込み
			$csv_arr = new \SplFileObject($file);
			$csv_arr->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

			//csvの値格納用配列
			$data_arr = [];

            $count = 0; // 登録件数確認用

			foreach($csv_arr as $i=>$line){
				if ($line === [null]) continue;
				if($i == 0) continue;

				//配列に格納
				// $data_arr[$i]['id'] = $line[0];
                $data_arr[$i]['sales_date'] = $line[1];
				$data_arr[$i]['shop_id'] = $line[2];
				$data_arr[$i]['hinban_id'] = $line[3];
				$data_arr[$i]['pcs'] = $line[4];
                $data_arr[$i]['tanka'] = $line[5];
                $data_arr[$i]['kingaku'] = $line[6];
                $data_arr[$i]['YM'] = $line[7];
                $data_arr[$i]['YW'] = $line[8];
				$data_arr[$i]['created_at'] = $line[9];
				$data_arr[$i]['updated_at'] = $line[10];
                $count++;
			}

                //保存

			foreach(array_chunk($data_arr, 500) as $chunk){
				DB::transaction(function() use ($chunk){
					DB::table('sales')->insert($chunk);

				});

			}

			DB::commit();

            return view('admin.data.result',compact('count'));

		}catch(Throwable $e){
			DB::rollback();
            Log::error($e);
            // throw $e;
            return to_route('admin.data.create')->with(['message'=>'エラーにより処理を中断しました。csvデータを確認してください。','status'=>'alert']);
		}
    }


    public function hinban_upload(Request $request)
    {

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        // dd($request);
		$file = $request->file('hinban_data');
        // dd($file);

        file_put_contents($file, mb_convert_encoding(file_get_contents($file), 'UTF-8', 'SJIS-win'));


        DB::beginTransaction();

        try{
			//ファイルの読み込み
			$csv_arr = new \SplFileObject($file);
			$csv_arr->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

			//csvの値格納用配列
			$data_arr = [];

            $count = 0; // 登録件数確認用

			foreach($csv_arr as $i=>$line){
				if ($line === [null]) continue;
				if($i == 0) continue;

				//配列に格納
				$data_arr[$i]['id'] = $line[0];
                $data_arr[$i]['brand_id'] = $line[1];
				$data_arr[$i]['unit_id'] = $line[2];
				$data_arr[$i]['year_code'] = $line[3];
				$data_arr[$i]['shohin_gun'] = $line[4];
                $data_arr[$i]['hinmei'] = $line[5];
                $data_arr[$i]['m_price'] = $line[6];
                $data_arr[$i]['price'] = $line[7];
                $data_arr[$i]['cost'] = $line[8];
                $data_arr[$i]['vendor_id'] = $line[9];
                $data_arr[$i]['hin_info'] = $line[10];
				$data_arr[$i]['created_at'] = $line[11];
				$data_arr[$i]['updated_at'] = $line[12];
                $count++;
			}

                //保存

			foreach(array_chunk($data_arr, 500) as $chunk){
				DB::transaction(function() use ($chunk){
					DB::table('hinbans')->insert($chunk);

				});

			}

			DB::commit();

            return view('admin.data.result',compact('count'));

		}catch(Throwable $e){
			DB::rollback();
            Log::error($e);
            // throw $e;
            return to_route('admin.data.create')->with(['message'=>'エラーにより処理を中断しました。csvデータを確認してください。','status'=>'alert']);
		}
    }

    public function hinban_upsert(Request $request)
    {

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        // dd($request);
		$file = $request->file('hinban_data');
        // dd($file);

        file_put_contents($file, mb_convert_encoding(file_get_contents($file), 'UTF-8', 'SJIS-win'));


        DB::beginTransaction();

        try{
			//ファイルの読み込み
			$csv_arr = new \SplFileObject($file);
			$csv_arr->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

			//csvの値格納用配列
			$data_arr = [];

            $count = 0; // 登録件数確認用

			foreach($csv_arr as $i=>$line){
				if ($line === [null]) continue;
				if($i == 0) continue;

				//配列に格納
				$data_arr[$i]['id'] = $line[0];
                $data_arr[$i]['brand_id'] = $line[1];
				$data_arr[$i]['unit_id'] = $line[2];
				$data_arr[$i]['year_code'] = $line[3];
				$data_arr[$i]['shohin_gun'] = $line[4];
                $data_arr[$i]['hinmei'] = $line[5];
                $data_arr[$i]['m_price'] = $line[6];
                $data_arr[$i]['price'] = $line[7];
                $data_arr[$i]['cost'] = $line[8];
                $data_arr[$i]['vendor_id'] = $line[9];
                $data_arr[$i]['hin_info'] = $line[10];
				// $data_arr[$i]['created_at'] = $line[11];
				// $data_arr[$i]['updated_at'] = $line[12];
                $count++;
			}

                //保存

			foreach(array_chunk($data_arr, 500) as $chunk){
				DB::transaction(function() use ($chunk){
					DB::table('hinbans')->upsert($chunk,['id']);

				});

			}

			DB::commit();

            return view('admin.data.result',compact('count'));

		}catch(Throwable $e){
			DB::rollback();
            Log::error($e);
            // throw $e;
            return to_route('admin.data.create')->with(['message'=>'エラーにより処理を中断しました。csvデータを確認してください。','status'=>'alert']);
		}
    }

    public function shop_upsert(Request $request)
    {

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        // dd($request);
		$file = $request->file('shop_data');
        // dd($file);

        file_put_contents($file, mb_convert_encoding(file_get_contents($file), 'UTF-8', 'SJIS-win'));


        DB::beginTransaction();

        try{
			//ファイルの読み込み
			$csv_arr = new \SplFileObject($file);
			$csv_arr->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

			//csvの値格納用配列
			$data_arr = [];

            $count = 0; // 登録件数確認用

			foreach($csv_arr as $i=>$line){
				if ($line === [null]) continue;
				if($i == 0) continue;


				//配列に格納
				$data_arr[$i]['id'] = $line[0];
                $data_arr[$i]['company_id'] = $line[1];
				$data_arr[$i]['area_id'] = $line[2];
				$data_arr[$i]['shop_name'] = $line[3];
				$data_arr[$i]['shop_info'] = $line[4];
                $data_arr[$i]['filename'] = $line[5];
                $data_arr[$i]['is_selling'] = $line[6];
				$data_arr[$i]['created_at'] = $line[7];
				$data_arr[$i]['updated_at'] = $line[8];
                $count++;
			}

                //保存

			foreach(array_chunk($data_arr, 500) as $chunk){
				DB::transaction(function() use ($chunk){
					DB::table('shops')->upsert($chunk,['id']);

				});

			}

			DB::commit();

            return view('admin.data.result',compact('count'));

		}catch(Throwable $e){
			DB::rollback();
            Log::error($e);
            // throw $e;
            return to_route('admin.data.create')->with(['message'=>'エラーにより処理を中断しました。csvデータを確認してください。','status'=>'alert']);
		}
    }

    public function company_upsert(Request $request)
    {

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        // dd($request);
		$file = $request->file('co_data');
        // dd($file);

        file_put_contents($file, mb_convert_encoding(file_get_contents($file), 'UTF-8', 'SJIS-win'));


        DB::beginTransaction();

        try{
			//ファイルの読み込み
			$csv_arr = new \SplFileObject($file);
			$csv_arr->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

			//csvの値格納用配列
			$data_arr = [];

            $count = 0; // 登録件数確認用

			foreach($csv_arr as $i=>$line){
				if ($line === [null]) continue;
				if($i == 0) continue;


				//配列に格納
				$data_arr[$i]['id'] = $line[0];
				$data_arr[$i]['co_name'] = $line[1];
				$data_arr[$i]['co_info'] = $line[2];
				$data_arr[$i]['created_at'] = $line[3];
				$data_arr[$i]['updated_at'] = $line[4];
                $count++;
			}

                //保存

			foreach(array_chunk($data_arr, 500) as $chunk){
				DB::transaction(function() use ($chunk){
					DB::table('companies')->upsert($chunk,['id']);

				});

			}

			DB::commit();

            return view('admin.data.result',compact('count'));

		}catch(Throwable $e){
			DB::rollback();
            Log::error($e);
            // throw $e;
            return to_route('admin.data.create')->with(['message'=>'エラーにより処理を中断しました。csvデータを確認してください。','status'=>'alert']);
		}
    }

    public function area_upsert(Request $request)
    {

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        // dd($request);
		$file = $request->file('ar_data');
        // dd($file);

        file_put_contents($file, mb_convert_encoding(file_get_contents($file), 'UTF-8', 'SJIS-win'));


        DB::beginTransaction();

        try{
			//ファイルの読み込み
			$csv_arr = new \SplFileObject($file);
			$csv_arr->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

			//csvの値格納用配列
			$data_arr = [];

            $count = 0; // 登録件数確認用

			foreach($csv_arr as $i=>$line){
				if ($line === [null]) continue;
				if($i == 0) continue;


				//配列に格納
				$data_arr[$i]['id'] = $line[0];
				$data_arr[$i]['ar_name'] = $line[1];
				$data_arr[$i]['created_at'] = $line[2];
				$data_arr[$i]['updated_at'] = $line[3];
                $count++;
			}

                //保存

			foreach(array_chunk($data_arr, 500) as $chunk){
				DB::transaction(function() use ($chunk){
					DB::table('areas')->upsert($chunk,['id']);

				});

			}

			DB::commit();

            return view('admin.data.result',compact('count'));

		}catch(Throwable $e){
			DB::rollback();
            Log::error($e);
            // throw $e;
            return to_route('admin.data.create')->with(['message'=>'エラーにより処理を中断しました。csvデータを確認してください。','status'=>'alert']);
		}
    }

    public function unit_upsert(Request $request)
    {

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        // dd($request);
		$file = $request->file('unit_data');
        // dd($file);

        file_put_contents($file, mb_convert_encoding(file_get_contents($file), 'UTF-8', 'SJIS-win'));


        DB::beginTransaction();

        try{
			//ファイルの読み込み
			$csv_arr = new \SplFileObject($file);
			$csv_arr->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

			//csvの値格納用配列
			$data_arr = [];

            $count = 0; // 登録件数確認用

			foreach($csv_arr as $i=>$line){
				if ($line === [null]) continue;
				if($i == 0) continue;


				//配列に格納
				$data_arr[$i]['id'] = $line[0];
                $data_arr[$i]['season_id'] = $line[1];
				$data_arr[$i]['season_name'] = $line[2];
				$data_arr[$i]['created_at'] = $line[3];
				$data_arr[$i]['updated_at'] = $line[4];
                $count++;
			}

                //保存

			foreach(array_chunk($data_arr, 500) as $chunk){
				DB::transaction(function() use ($chunk){
					DB::table('units')->upsert($chunk,['id']);

				});

			}

			DB::commit();

            return view('admin.data.result',compact('count'));

		}catch(Throwable $e){
			DB::rollback();
            Log::error($e);
            // throw $e;
            return to_route('admin.data.create')->with(['message'=>'エラーにより処理を中断しました。csvデータを確認してください。','status'=>'alert']);
		}
    }

    public function brand_upsert(Request $request)
    {

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        // dd($request);
		$file = $request->file('br_data');
        // dd($file);

        file_put_contents($file, mb_convert_encoding(file_get_contents($file), 'UTF-8', 'SJIS-win'));


        DB::beginTransaction();

        try{
			//ファイルの読み込み
			$csv_arr = new \SplFileObject($file);
			$csv_arr->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

			//csvの値格納用配列
			$data_arr = [];

            $count = 0; // 登録件数確認用

			foreach($csv_arr as $i=>$line){
				if ($line === [null]) continue;
				if($i == 0) continue;


				//配列に格納
				$data_arr[$i]['id'] = $line[0];
                $data_arr[$i]['br_name'] = $line[1];
				$data_arr[$i]['br_info'] = $line[2];
				$data_arr[$i]['created_at'] = $line[3];
				$data_arr[$i]['updated_at'] = $line[4];
                $count++;
			}

                //保存

			foreach(array_chunk($data_arr, 500) as $chunk){
				DB::transaction(function() use ($chunk){
					DB::table('brands')->upsert($chunk,['id']);

				});

			}

			DB::commit();

            return view('admin.data.result',compact('count'));

		}catch(Throwable $e){
			DB::rollback();
            Log::error($e);
            // throw $e;
            return to_route('admin.data.create')->with(['message'=>'エラーにより処理を中断しました。csvデータを確認してください。','status'=>'alert']);
		}
    }

    public function delivery_upload(Request $request)
    {

        setlocale(LC_ALL, 'ja_JP.UTF-8');
        // dd($request);
		$file = $request->file('deliv_data');
        // dd($file);

        file_put_contents($file, mb_convert_encoding(file_get_contents($file), 'UTF-8', 'SJIS-win'));


        DB::beginTransaction();

        try{
			//ファイルの読み込み
			$csv_arr = new \SplFileObject($file);
			$csv_arr->setFlags(\SplFileObject::READ_CSV | \SplFileObject::READ_AHEAD | \SplFileObject::SKIP_EMPTY);

			//csvの値格納用配列
			$data_arr = [];

            $count = 0; // 登録件数確認用

			foreach($csv_arr as $i=>$line){
				if ($line === [null]) continue;
				if($i == 0) continue;

				//配列に格納
				// $data_arr[$i]['id'] = $line[0];
                $data_arr[$i]['deliv_date'] = $line[1];
				$data_arr[$i]['shop_id'] = $line[2];
				$data_arr[$i]['hinban_id'] = $line[3];
				$data_arr[$i]['pcs'] = $line[4];
                $data_arr[$i]['tanka'] = $line[5];
                $data_arr[$i]['kingaku'] = $line[6];
                $data_arr[$i]['YM'] = $line[7];
                $data_arr[$i]['YW'] = $line[8];
				$data_arr[$i]['created_at'] = $line[9];
				$data_arr[$i]['updated_at'] = $line[10];
                $count++;
			}

                //保存

			foreach(array_chunk($data_arr, 500) as $chunk){
				DB::transaction(function() use ($chunk){
					DB::table('deliveries')->insert($chunk);

				});

			}

			DB::commit();

            return view('admin.data.result',compact('count'));

		}catch(Throwable $e){
			DB::rollback();
            Log::error($e);
            throw $e;
            // return to_route('admin.data.create')->with(['message'=>'エラーにより処理を中断しました。csvデータを確認してください。','status'=>'alert']);
		}
    }


}
