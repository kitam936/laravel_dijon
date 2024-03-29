<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Delivery;
use App\Models\Shop;
use App\Models\Sale;
use App\Models\Stock;

class CompanyController extends Controller
{

    public function __construct(){
        $this->middleware('auth:users');
        }

    public function index()
    {
        $companies = Company::select('id','co_name','co_info','created_at')
        ->where('id','>','1000')
        ->where('id','<','4000')
        ->paginate(15);
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

        $areas = DB::table('areas')
        ->select(['areas.id','areas.ar_name'])
        ->get();

        // $shops = Shop::where('company_id', $companies->id)->get();
        $shops = Shop::where('company_id', $companies->id)->where('company_id','>','1000')->where('is_selling','=',1)->paginate(15);

        // dd($companies,$shops);
        return view('User.shop.index',compact('companies','shops','areas'));


    }


    public function search_m_sales(Request $request)
    {
        $companies = Company::findOrFail($request->co_id)->co_name;
        $m_sales = Sale::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();
        $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($companies,$m_sales,$c_stock);
        return view('User.company.search_m_sales',compact('companies','m_sales','c_stocks'));
    }

    public function search_form_m_sales(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $m_sales_all = DB::table('sales')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();

        // $m_sales = Sale::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->select('YM')
        // ->selectRaw('SUM(kingaku) as kingaku')
        // ->groupBy('YM')
        // ->orderBy('YM','desc')
        // ->get();
        $m_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();
        // $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();
        $c_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $all_stocks = DB::table('stocks')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        // dd($companies,$m_sales,$m_sales_all);
        return view('User.company.search_m_sales',compact('companies','m_sales_all','m_sales','c_stocks','all_stocks','brands'));
    }

    public function search_form_w_sales(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        // $w_sales_all = DB::table('sales')
        // ->select('YW','YM')
        // ->selectRaw('SUM(kingaku) as kingaku')
        // ->groupBy('YW','YM')
        // ->orderBy('YW','desc')
        // ->orderBy('YM','desc')
        // ->get();

        $w_sales_all = DB::table('sales')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select('YW','YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();

        // $w_sales = Sale::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->select('YW','YM')
        // ->selectRaw('SUM(kingaku) as kingaku')
        // ->groupBy('YW','YM')
        // ->orderBy('YW','desc')
        // ->orderBy('YM','desc')
        // ->get();

        $w_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select('YW','YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();


        // $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();

        $c_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // $all_stocks = DB::table('stocks')
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();

        $all_stocks = DB::table('stocks')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        // dd($companies,$m_sales,$m_sales_all);
        return view('User.company.search_w_sales',compact('companies','w_sales_all','w_sales','c_stocks','all_stocks','brands'));
    }

    public function search_form_u_sales(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $u_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();

        // $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();

        $c_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        $YWs=DB::table('sales')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();
        $max_YM=Sale::max('YM');
        $max_YW=Sale::max('YW');
        $min_YW=Sale::max('YW');
        // dd($companies,$u_sales,$u_sales_all,$c_stocks,$all_stocks,$YMWs,$max_YM,$max_YW,$YMs,$YWs);
        return view('User.company.search_u_sales',compact('companies','u_sales','c_stocks','max_YM','max_YW','YWs','min_YW','brands'));
    }

    public function search_form_s_sales(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $s_sales_all = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','units.season_id','units.season_name'])
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','units.season_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();
        $s_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        // ->where('shops.company_id','=',$request->co_id)
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','units.season_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();
        // $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id',$request->co_id);})
        // $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();

        $c_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $all_stocks = DB::table('stocks')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $YWs=DB::table('sales')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();
        $max_YM=Sale::max('YM');
        $max_YW=Sale::max('YW');
        $min_YW=Sale::max('YW');
        // dd($companies,$s_sales,$s_sales_all,$c_stocks,$all_stocks,$YMWs,$max_YM,$max_YW,$YMs,$YWs);
        return view('User.company.search_s_sales',compact('companies','s_sales_all','s_sales','c_stocks','all_stocks','max_YM','max_YW','min_YW','YWs','brands'));
    }

    public function search_form_h_sales(Request $request)
    {
        $companies = Company::where('id','>',1000)->where('id','<',4000)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $h_sales_all = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->paginate(20);

        $h_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->paginate(20);

        // $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();

        $c_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // $all_stocks = DB::table('stocks')
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();

        $all_stocks = DB::table('stocks')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $YWs=DB::table('sales')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();

        // $YWs=Sale::Yms()->get();

        $max_YM=Sale::max('YM');
        $max_YW=Sale::max('YW');
        $min_YW=Sale::max('YW');
        // dd($h_sales,$h_sales_all);
        return view('User.company.search_h_sales',compact('companies','h_sales_all','h_sales','c_stocks','all_stocks','max_YM','min_YW','max_YW','YWs','brands'));
    }

    public function search_form_hz_stocks(Request $request)
    {

        $companies = Company::where('id','>',0)->where('id','<',9999)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $h_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select('stocks.hinban_id','hinbans.hinmei','hinbans.unit_id')
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy('stocks.hinban_id','hinbans.hinmei','hinbans.unit_id')
        ->orderBy('pcs','desc')
        ->get(['stocks.hinban_id','hinbans.hinmei','stocks.pcs','stocks.zaikogaku','hinbans.unit_id']);

        $h_stocks_all = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select('stocks.hinban_id','hinbans.hinmei','hinbans.unit_id')
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy('stocks.hinban_id','hinbans.hinmei','hinbans.unit_id')
        ->orderBy('pcs','desc')
        ->get(['stocks.hinban_id','hinbans.hinmei','stocks.pcs','stocks.zaikogaku','hinbans.unit_id']);

        // $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();

        $c_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // $all_stocks = DB::table('stocks')
        // // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();

        $all_stocks = DB::table('stocks')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($h_stocks,$h_stocks_all,$all_stocks,$c_stocks);
        return view('User.company.search_hz_stocks',compact('companies','h_stocks','all_stocks','h_stocks_all','c_stocks','brands'));
    }

    public function search_form_uz_stocks(Request $request)
    {
        $companies = Company::where('id','>',0)->where('id','<',9999)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $u_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select(['hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['hinbans.unit_id','units.season_name'])
        ->get();

        $u_stocks_all = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select(['hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['hinbans.unit_id','units.season_name'])
        ->get();

        // $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();

        $c_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // $all_stocks = DB::table('stocks')
        // // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();

        $all_stocks = DB::table('stocks')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($h_sales,$h_sales_all);
        return view('User.company.search_uz_stocks',compact('companies','u_stocks','all_stocks','c_stocks','u_stocks_all','brands'));
    }

    public function search_form_sz_stocks(Request $request)
    {
        // $companies = Company::where('id','>',1000)->where('id','<',4000)->select('id','co_name')->get();
        $companies = Company::where('id','>',0)->where('id','<',9999)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $season_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select(['units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['units.season_id','units.season_name'])
        ->get();

        $season_stocks_all = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select(['units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['units.season_id','units.season_name'])
        ->get();

        $c_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $all_stocks = DB::table('stocks')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        // dd($h_sales,$h_sales_all);
        return view('User.company.search_sz_stocks',compact('companies','season_stocks','all_stocks','season_stocks_all','c_stocks','brands'));
    }

    public function search_form_m_deliv(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $m_delivs_all = DB::table('deliveries')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();
        // $m_delivs = Delivery::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->select('YM')
        // ->selectRaw('SUM(kingaku) as kingaku')
        // ->groupBy('YM')
        // ->orderBy('YM','desc')
        // ->get();

        $m_delivs = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();

        // dd($companies,$m_sales,$m_sales_all);
        return view('User.company.search_m_deliv',compact('companies','m_delivs_all','m_delivs','brands'));
    }

    public function search_form_w_deliv(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $w_delivs_all = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select('YW','YM','deliv_date')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM','deliv_date')
        ->orderBy('deliv_date','desc')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();

        // $w_delivs = Delivery::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->select('YW','YM','deliv_date')
        // ->selectRaw('SUM(kingaku) as kingaku')
        // ->groupBy('YW','YM','deliv_date')
        // ->orderBy('deliv_date','desc')
        // ->orderBy('YW','desc')
        // ->orderBy('YM','desc')
        // ->get();

        $w_delivs = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select('YW','YM','deliv_date')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM','deliv_date')
        ->orderBy('deliv_date','desc')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();

        // dd($companies,$m_sales,$m_sales_all);
        return view('User.company.search_w_deliv',compact('companies','w_delivs_all','w_delivs','brands'));
    }

    public function search_form_u_deliv(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $u_delivs = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();


        $YWs=DB::table('deliveries')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();
        $max_YM=Delivery::max('YM');
        $max_YW=Delivery::max('YW');
        $min_YW=Delivery::max('YW');
        // dd($companies,$u_sales,$u_sales_all,$c_stocks,$all_stocks,$YMWs,$max_YM,$max_YW,$YMs,$YWs);
        return view('User.company.search_u_deliv',compact('companies','u_delivs','max_YM','max_YW','YWs','min_YW','brands'));
    }

    public function search_form_s_deliv(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $s_delivs_all = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','units.season_id','units.season_name'])
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','units.season_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();

        $s_delivs = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        // ->where('shops.company_id','=',$request->co_id)
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->select(['hinbans.year_code','units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','units.season_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();

        $YWs=DB::table('deliveries')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();
        $max_YM=Delivery::max('YM');
        $max_YW=Delivery::max('YW');
        $min_YW=Delivery::max('YW');
        // dd($companies,$s_sales,$s_sales_all,$c_stocks,$all_stocks,$YMWs,$max_YM,$max_YW,$YMs,$YWs);
        return view('User.company.search_s_deliv',compact('companies','s_delivs_all','s_delivs','max_YM','max_YW','min_YW','YWs','brands'));
    }

    public function search_form_h_deliv(Request $request)
    {
        $companies = Company::where('id','>',1000)->where('id','<',4000)->select('id','co_name')->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $h_delivs_all = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->paginate(20);

        $h_delivs = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->paginate(20);


        $YWs=DB::table('deliveries')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();

        // $YWs=Sale::Yms()->get();

        $max_YM=Delivery::max('YM');
        $max_YW=Delivery::max('YW');
        $min_YW=Delivery::max('YW');
        // dd($h_sales,$h_sales_all);
        return view('User.company.search_h_deliv',compact('companies','h_delivs_all','h_delivs','max_YM','min_YW','max_YW','YWs','brands'));
    }

    public function c_sales_rank(Request $request)
    {
        $c_ranks = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('companies','shops.company_id','=','companies.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->where('sales.shop_id','>',1000)->where('sales.shop_id','<',4000)
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select(['shops.company_id','companies.co_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['shops.company_id','companies.co_name'])
        ->orderBy('kingaku','desc')
        ->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $YWs=DB::table('sales')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();

        $max_YM=Sale::max('YM');
        $max_YW=Sale::max('YW');
        $min_YW=Sale::max('YW');
        // dd($c_ranks,$YMWs,$max_YM,$max_YW,$YMs,$YWs);
        return view('User.company.c_sales_rank',compact('c_ranks','max_YM','max_YW','YWs','min_YW','brands'));
    }

    public function c_delivs_rank(Request $request)
    {
        $c_ranks = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('companies','shops.company_id','=','companies.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->where('deliveries.shop_id','>',1000)->where('deliveries.shop_id','<',4000)
        ->where('deliveries.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->where('hinbans.brand_id','LIKE','%'.($request->brand_code).'%')
        ->select(['shops.company_id','companies.co_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['shops.company_id','companies.co_name'])
        ->orderBy('kingaku','desc')
        ->get();

        $brands=DB::table('brands')
        ->select(['id','br_name'])
        ->groupBy(['id','br_name'])
        ->orderBy('id','asc')
        ->get();

        $YWs=DB::table('deliveries')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();

        $max_YM=Delivery::max('YM');
        $max_YW=Delivery::max('YW');
        $min_YW=Delivery::max('YW');
        // dd($c_ranks,$YMWs,$max_YM,$max_YW,$YMs,$YWs);
        return view('User.company.c_delivs_rank',compact('c_ranks','max_YM','max_YW','YWs','min_YW','brands'));
    }



}
