<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;
use App\Models\Sale;
use App\Models\Stock;

class ShopController extends Controller
{

    public function index()
    {
        $shops = Shop::select('id','shop_name','company_id','shop_info','created_at')->where('company_id','>','1000')->where('is_selling','=',1)->get();

        return view('User.shop.index',compact('shops'));
    }


    public function create()
    {
        //
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

    public function monthrysales($id)
    {
        $shops = Shop::findOrFail($id)->shop_name;

        $m_sales = DB::table('sales')
        ->select('YM')
        ->where('shop_id',$id)
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();
        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        // dd($m_sales,$shops);
        return view('User.shop.m_sales',compact('shops','m_sales','s_stocks'));
        }

    public function weeklysales($id)
    {
        $shops = Shop::findOrFail($id)->shop_name;
        // $company=$shops->company->co_name;

        $w_sales = DB::table('sales')
        ->select('YW')
        ->where('shop_id',$id)
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW')
        ->orderBy('YW','desc')
        ->get();
        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        // dd($w_sales,$shops,$YM0,$YW0);
        return view('User.shop.w_sales',compact('shops','w_sales','s_stocks'));
    }

    public function sh_stock($id)
    {
        $shops = Shop::findOrFail($id)->shop_name;

        $h_stocks = Stock::with('hinban')
        ->where('shop_id',$id)
        ->whereHas('hinban',function($q){$q->where('unit_id','>',6);})
        ->select('hinban_id')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->groupBy('hinban_id')
        ->orderBy('pcs','desc')
        ->get(['hinban_id','hinmei','pcs','zaikogaku']);
        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$h_stocks,$c_stocks);
        return view('User.shop.h_stock',compact('shops','h_stocks','s_stocks'));
    }

    public function su_stock($id)
    {
        $shops = Shop::findOrFail($id)->shop_name;

        $u_stocks = DB::table('stocks')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('stocks.shop_id','=',$id)
        ->select(['hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['hinbans.unit_id','units.season_name'])
        ->get();


        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$u_stocks,$c_stocks);
        return view('User.shop.u_stock',compact('shops','u_stocks','s_stocks'));
    }

    public function s_season_stock($id)
    {
        $shops = Shop::findOrFail($id)->shop_name;

        $season_stocks = DB::table('stocks')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('stocks.shop_id','=',$id)
        ->select(['units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['units.season_id','units.season_name'])
        ->get();


        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$u_stocks,$c_stocks);
        return view('User.shop.season_stock',compact('shops','season_stocks','s_stocks'));
    }

    public function sh_sales($id)
    {
        $shops = Shop::findOrFail($id)->shop_name;

        $h_sales = Sale::with('hinban')
        ->where('shop_id',$id)
        ->whereHas('hinban',function($q){$q->where('unit_id','>',6);})
        ->select('hinban_id')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->groupBy('hinban_id')
        ->orderBy('pcs','desc')
        ->get(['hinban_id','hinmei','pcs','kingaku']);
        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$h_stocks,$c_stocks);
        return view('User.shop.h_sales',compact('shops','h_sales','s_stocks'));
    }

    public function su_sales($id)
    {
        $shops = Shop::findOrFail($id)->shop_name;

        $u_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('sales.shop_id','=',$id)
        ->select(['hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.unit_id','units.season_name'])
        ->get();


        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$u_stocks,$c_stocks);
        return view('User.shop.u_sales',compact('shops','u_sales','s_stocks'));
    }

    public function s_season_sales($id)
    {
        $shops = Shop::findOrFail($id)->shop_name;

        $season_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('sales.shop_id','=',$id)
        ->select(['units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['units.season_id','units.season_name'])
        ->get();


        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$u_stocks,$c_stocks);
        return view('User.shop.season_sales',compact('shops','season_sales','s_stocks'));
    }



}
