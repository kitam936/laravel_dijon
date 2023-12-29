<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Company;
use App\Models\Area;
use App\Models\Hinban;

class ProductController extends Controller
{
    public function __construct(){
        $this->middleware('auth:users');
        }

    public function index(Request $request)
    {
        $products = Hinban::with('unit')->paginate(15);
        $products_sele = DB::table('hinbans')
        ->join('units','units.id','=','hinbans.unit_id')
        // ->where('hinbans.year_code','=',($request->year_code ))
        // ->where('units.season_id','=',($request->season_code))
        // ->where('hinbans.unit_id','=',($request->unit_code))
        // ->where('hinbans.brand_id','=',($request->brand_code))
        // ->where('hinbans.year_code','LIKE','%'.($request->year_code ).'%')
        ->where('hinbans.year_code','LIKE','%'.($request->year_code).'%')
        // ->where('units.season_id','LIKE','%'.($request->season_code).'%')
        ->where('units.season_id','LIKE','%'.($request->season_code).'%')
        ->where('hinbans.unit_id','LIKE','%'.($request->unit_code).'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->where('hinbans.id','LIKE','%'.($request->hinban_code).'%')
        ->where('hinbans.vendor_id','<>',8200)
        ->select(['hinbans.year_code','hinbans.brand_id','hinbans.unit_id','units.season_name','hinbans.id','hinbans.hinmei','hinbans.m_price','hinbans.price'])
        ->orderBy('hinbans.id','asc')
        ->paginate(15);
        // ->get();
        $years=DB::table('hinbans')
        ->select(['year_code'])
        ->groupBy(['year_code'])
        ->orderBy('year_code','desc')
        ->get();
        $seasons=DB::table('units')
        ->select(['season_id','season_name'])
        ->groupBy(['season_id','season_name'])
        ->orderBy('season_id','asc')
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

        return view('User.product.index',compact('products','seasons','units','years','products_sele','brands'));
    }

    public function h_shop_zaiko($id)
    {
        // $hinbans = Hinban::findOrFail($id)->first();
        $hinbans = DB::table('stocks')
        ->where('hinban_id','=',$id)
        ->select(['hinban_id'])
        // ->groupBy(['tocks.hinban_id'])
        ->orderBy('hinban_id','asc')
        ->first();


        $h_shop_stocks = DB::table('stocks')
        ->join('hinbans','hinbans.id','=','stocks.hinban_id')
        ->join('shops','shops.id','=','stocks.shop_id')
        ->join('companies','companies.id','=','shops.company_id')
        ->join('areas','areas.id','=','shops.area_id')
        ->where('stocks.hinban_id','=',$id)
        ->select(['stocks.hinban_id','shops.company_id','companies.co_name','stocks.shop_id','shops.shop_name','stocks.pcs','areas.id','areas.ar_name'])
        ->orderBy('stocks.pcs','desc')
        ->orderBy('areas.id','asc')
        ->orderBy('companies.id','asc')
        ->orderBy('stocks.shop_id','asc')
        ->paginate(15);

        // dd($h_shop_stocks,$hinbans);
        if(is_null($hinbans)){
            return to_route('user.product.index')
            ->with(['message'=>'在庫データがありません','status'=>'alert']);
            // dd($h_shop_stocks);
        }else{
            return view('User.product.h_shop_zaiko',compact('h_shop_stocks','hinbans'));
        }


    }
}
