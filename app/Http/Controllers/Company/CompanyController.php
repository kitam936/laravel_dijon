<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Shop;
use App\Models\Sale;
use App\Models\Stock;

class CompanyController extends Controller
{

    public function index()
    {
        $companies = Company::select('id','co_name','co_info','created_at')->where('id','>','1000')->get();
        return view('User.company.index',compact('companies'));
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
        $companies = Company::findOrFail($id);
        $shops = Shop::where('company_id', $companies->id)->where('company_id','>','1000')->get();

        dd($companies,$shops);
        return view('User.shop.index',compact('companies','shops'));
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

    public function shoplist($id)
    {
        $companies = Company::findOrFail($id);

        // $shops = Shop::where('company_id', $companies->id)->get();
        $shops = Shop::where('company_id', $companies->id)->where('company_id','>','1000')->where('is_selling','=',1)->get();

        // dd($companies,$shops);
        return view('User.shop.index',compact('companies','shops'));


    }

    public function monthrysales($id)
    {
        $companies = Company::findOrFail($id)->co_name;
        $m_sales = Sale::whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();
        $c_stocks = Stock::whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        // dd($companies,$m_sales,$c_stock);
        return view('User.company.m_sales',compact('companies','m_sales','c_stocks'));
    }

    public function weeklysales($id)
    {
        $companies = Company::findOrFail($id)->co_name;
        $w_sales = Sale::whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->select('YW','YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();
        $c_stocks = Stock::whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        // dd($companies,$m_sales);
        return view('User.company.w_sales',compact('companies','w_sales','c_stocks'));
    }

    public function ch_stock($id)
    {
        $companies = Company::findOrFail($id)->co_name;

        $h_stocks = Stock::with('hinban')
        ->whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->whereHas('hinban',function($q){$q->where('unit_id','>',6);})
        ->select('hinban_id')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->groupBy('hinban_id')
        ->orderBy('pcs','desc')
        ->get(['hinban_id','hinmei','pcs','zaikogaku']);
        $c_stocks = Stock::whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$h_stocks,$c_stocks);
        return view('User.company.h_stock',compact('companies','h_stocks','c_stocks'));
    }

    public function cu_stock($id)
    {
        $companies = Company::findOrFail($id)->co_name;

        // $u_stocks = Stock::with('hinban:unit_id,id')
        // ->whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        // ->whereHas('hinban',function($q){$q->where('unit_id','>',6);})
        // ->select('unit_id')   //カラムなしとエラーが出る
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->groupBy('unit_id')
        // ->orderBy('pcs','desc')
        // ->get(['unit_id','pcs','zaikogaku']);

        $u_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','=',$id)
        ->select(['hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['hinbans.unit_id','units.season_name'])
        ->get();


        $c_stocks = Stock::whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$u_stocks,$c_stocks);
        return view('User.company.u_stock',compact('companies','u_stocks','c_stocks'));
    }

    public function c_season_stock($id)
    {
        $companies = Company::findOrFail($id)->co_name;

        $season_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','=',$id)
        ->select(['units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['units.season_id','units.season_name'])
        ->get();


        $c_stocks = Stock::whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$u_stocks,$c_stocks);
        return view('User.company.season_stock',compact('companies','season_stocks','c_stocks'));
    }

    public function ch_sales($id)
    {
        $companies = Company::findOrFail($id)->co_name;

        $h_sales = Sale::with('hinban')
        ->whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->whereHas('hinban',function($q){$q->where('unit_id','>',6);})
        ->select('hinban_id')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->groupBy('hinban_id')
        ->orderBy('pcs','desc')
        ->get(['hinban_id','hinmei','pcs','kingaku']);
        $c_stocks = Stock::whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$h_stocks,$c_stocks);
        return view('User.company.h_sales',compact('companies','h_sales','c_stocks'));
    }

    public function cu_sales($id)
    {
        $companies = Company::findOrFail($id)->co_name;

        $u_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','=',$id)
        ->select(['hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.unit_id','units.season_name'])
        ->get();


        $c_stocks = Stock::whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$u_stocks,$c_stocks);
        return view('User.company.u_sales',compact('companies','u_sales','c_stocks'));
    }

    public function c_season_sales($id)
    {
        $companies = Company::findOrFail($id)->co_name;

        $season_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','=',$id)
        ->select(['units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['units.season_id','units.season_name'])
        ->get();


        $c_stocks = Stock::whereHas('shop',function($q)use($id){$q->where('company_id',$id);})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($companies,$u_stocks,$c_stocks);
        return view('User.company.season_sales',compact('companies','season_sales','c_stocks'));
    }



}
