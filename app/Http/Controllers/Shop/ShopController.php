<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Shop;
use App\Models\Sale;
use App\Models\Stock;
use App\Models\Company;
use App\Models\Area;
use App\Models\Delivery;
use App\Models\Report;

class ShopController extends Controller
{

    public function __construct(){
        $this->middleware('auth:users');
        }


    public function index(Request $request)
    {
        $companies = Company::with('shop')
        ->whereHas('shop',function($q){$q->where('is_selling','=',1);})
        ->where('id','>',1000)
        ->where('id','<',4000)->get();
        $areas = DB::table('areas')
        ->select(['areas.id','areas.ar_name'])
        ->get();
        $shops = DB::table('shops')
        ->join('areas','areas.id','=','shops.area_id')
        ->join('companies','companies.id','=','shops.company_id')
        ->select('shops.id','shops.shop_name','shops.company_id','shops.area_id','areas.ar_name','companies.co_name','shop_info')
        ->where('shops.company_id','>','1000')
        ->where('shops.company_id','<','4000')
        ->where('shops.is_selling','=',1)
        ->where('shops.company_id','LIKE','%'.($request->co_id).'%')
        ->where('shops.area_id','LIKE','%'.($request->ar_id).'%')
        ->where('shops.shop_info','LIKE','%'.($request->info).'%')
        ->paginate(15);
        // dd($companies,$areas,$shops);

        return view('User.shop.index',compact('shops','areas','companies'));
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
        $reports=DB::table('reports')
        ->join('shops','shops.id','=','reports.shop_id')
        ->join('companies','companies.id','=','shops.company_id')
        ->join('areas','areas.id','=','shops.area_id')
        ->where('reports.shop_id',$id)
        ->select(['reports.id','shops.company_id','companies.co_name','reports.shop_id','shops.shop_name','areas.ar_name','shops.shop_info','reports.comment','reports.image1','reports.created_at'])
        ->get();

        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->join('areas','areas.id','=','shops.area_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name','areas.ar_name','shops.shop_info'])
        ->get();
        // dd($shops,$reports);

        return view('User.shop.show',compact('shops','reports'));
        // return view('User.shop.show',compact('shops'));
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




    public function s_search_form_m_sales(Request $request)
    {
        $companies = Company::with('shop')
        ->whereHas('shop',function($q){$q->where('is_selling','=',1);})
        ->where('id','>',1000)
        ->where('id','<',4000)->get();

        // $companies = DB::table('companies')
        // ->join('shops','companies.id','=','shops.company_id')
        // ->select(['companies.id,','companies.co_naame','shops.id','shops.shop_name','is_selling','YM','YW'])
        // ->where('shops.is_selling','=',1)
        // ->where('companies.id','>',1000)
        // ->where('companies.id','<',4000)->get();

        $m_sales = Sale::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();

        $s_stocks = Stock::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($m_sales,$s_stocks,$shops);
        return view('User.shop.search_m_sales',compact('m_sales','s_stocks','companies','all_stocks'));
    }

    public function s_search_form_w_sales(Request $request)
    {
        $companies = Company::with('shop')
        ->where('id','>',1000)
        ->where('id','<',4000)->get();

        $w_sales = Sale::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->select('YW','YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();
        $s_stocks = Stock::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($companies,$m_sales,$m_sales_all);
        return view('User.shop.search_w_sales',compact('w_sales','s_stocks','companies','all_stocks'));
    }

    public function s_search_form_u_sales(Request $request)
    {
        $companies = Company::with('shop')
        ->where('id','>',1000)
        ->where('id','<',4000)
        ->get();

        $u_sales_all = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();

        $u_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.id','LIKE','%'.($request->sh_id).'%')
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();
        $s_stocks = Stock::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $YWs=DB::table('sales')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();
        $max_YW=Sale::max('YW');
        $max_YM=Sale::max('YM');
        $min_YW=Sale::max('YW');
        // dd($companies,$u_sales,$u_sales_all,$c_stocks,$all_stocks,$max_YW,$max_YW,$YWs,$YWs);
        return view('User.shop.search_u_sales',compact('companies','u_sales_all','u_sales','s_stocks','all_stocks','max_YW','min_YW','YWs'));

    }

    public function s_search_form_s_sales(Request $request)
    {
        $companies = Company::with('shop')
        ->where('id','>',1000)
        ->where('id','<',4000)
        ->get();

        $s_sales_all = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','units.season_id','units.season_name'])
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','units.season_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();
        $s_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.id','LIKE','%'.($request->sh_id).'%')
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','units.season_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();
        $s_stocks = Stock::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $YWs=DB::table('sales')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();
        $max_YW=Sale::max('YW');
        $max_YM=Sale::max('YM');
        $min_YW=Sale::max('YW');
        // dd($companies,$s_sales,$s_sales_all,$c_stocks,$all_stocks,$YWWs,$max_YW,$max_YW,$YWs,$YWs);
        return view('User.shop.search_s_sales',compact('companies','s_sales_all','s_sales','s_stocks','all_stocks','max_YW','min_YW','YWs'));
    }

    public function s_search_form_h_sales(Request $request)
    {
        $companies = Company::with('shop')
        ->whereHas('shop',function($q){$q->where('is_selling','=',1);})
        ->where('id','>',1000)
        ->where('id','<',4000)->get();

        $h_sales_all = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->get();

        $h_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.id','LIKE','%'.($request->sh_id).'%')
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->selectRaw('SUM(pcs) as pcs')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->get();

        $s_stocks = Stock::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $YWs=DB::table('sales')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();
        $max_YW=Sale::max('YW');
        $max_YM=Sale::max('YM');

        // $YWs=Sale::YWs()->get();

        $max_YW=Sale::max('YW');
        $max_YW=Sale::max('YW');
        $min_YW=Sale::max('YW');
        // dd($h_sales,$h_sales_all);
        return view('User.shop.search_h_sales',compact('companies','h_sales_all','h_sales','s_stocks','all_stocks','max_YW','min_YW','YWs'));
    }

    public function s_search_form_hz_stocks(Request $request)
    {
        $companies = Company::with('shop')
        ->whereHas('shop',function($q){$q->where('is_selling','=',1);})
        ->where('id','>',1000)
        ->where('id','<',4000)->get();

        $h_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.id','LIKE','%'.($request->sh_id).'%')
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
        ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->select('stocks.hinban_id','hinbans.hinmei','hinbans.unit_id')
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy('stocks.hinban_id','hinbans.hinmei','hinbans.unit_id')
        ->orderBy('pcs','desc')
        ->get(['stocks.hinban_id','hinbans.hinmei','stocks.pcs','stocks.zaikogaku','hinbans.unit_id']);

        $s_stocks = Stock::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($h_stocks,$h_stocks_all,$all_stocks,$c_stocks);
        return view('User.shop.search_hz_stocks',compact('companies','h_stocks','all_stocks','h_stocks_all','s_stocks'));
    }

    public function s_search_form_uz_stocks(Request $request)
    {
        $companies = Company::where('id','>',1000)->where('id','<',4000)->select('id','co_name')->get();

        $u_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.id','LIKE','%'.($request->sh_id).'%')
        ->select(['hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['hinbans.unit_id','units.season_name'])
        ->get();

        $u_stocks_all = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->select(['hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['hinbans.unit_id','units.season_name'])
        ->get();

        $s_stocks = Stock::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($h_sales,$h_sales_all);
        return view('User.shop.search_uz_stocks',compact('companies','s_stocks','all_stocks','u_stocks','u_stocks_all'));
    }

    public function s_search_form_sz_stocks(Request $request)
    {
        $companies = Company::where('id','>',1000)->where('id','<',4000)->select('id','co_name')->get();

        $season_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.id','LIKE','%'.($request->sh_id).'%')
        ->select(['units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['units.season_id','units.season_name'])
        ->get();

        $season_stocks_all = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->select(['units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['units.season_id','units.season_name'])
        ->get();

        $s_stocks = Stock::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($h_sales,$h_sales_all);
        return view('User.shop.search_sz_stocks',compact('companies','season_stocks','all_stocks','season_stocks_all','s_stocks'));
    }

    public function s_search_form_m_deliv(Request $request)
    {
        $companies = Company::with('shop')
        ->whereHas('shop',function($q){$q->where('is_selling','=',1);})
        ->where('id','>',1000)
        ->where('id','<',4000)->get();

        $m_delivs = Delivery::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();

        return view('User.shop.search_m_deliv',compact('m_delivs','companies'));
    }

    public function s_search_form_w_deliv(Request $request)
    {
        $companies = Company::with('shop')
        ->where('id','>',1000)
        ->where('id','<',4000)->get();

        $w_delivs = Delivery::where('shop_id','LIKE','%'.($request->sh_id).'%')
        ->select('YW','YM','deliv_date')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM','deliv_date')
        ->orderBy('deliv_date','desc')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();

        return view('User.shop.search_w_deliv',compact('w_delivs','companies'));
    }

    public function s_search_form_u_deliv(Request $request)
    {
        $companies = Company::with('shop')
        ->where('id','>',1000)
        ->where('id','<',4000)
        ->get();

        $u_delivs_all = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();

        $u_delivs = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.id','LIKE','%'.($request->sh_id).'%')
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
        $max_YW=Delivery::max('YW');
        $max_YM=Delivery::max('YM');
        $min_YW=Delivery::max('YW');
        // dd($companies,$u_sales,$u_sales_all,$c_stocks,$all_stocks,$max_YW,$max_YW,$YWs,$YWs);
        return view('User.shop.search_u_deliv',compact('companies','u_delivs_all','u_delivs','max_YW','min_YW','YWs'));

    }

    public function s_search_form_s_deliv(Request $request)
    {
        $companies = Company::with('shop')
        ->where('id','>',1000)
        ->where('id','<',4000)
        ->get();

        $s_delivs_all = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','units.season_id','units.season_name'])
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
        ->where('shops.id','LIKE','%'.($request->sh_id).'%')
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
        $max_YW=Delivery::max('YW');
        $max_YM=Delivery::max('YM');
        $min_YW=Delivery::max('YW');
        // dd($companies,$s_sales,$s_sales_all,$c_stocks,$all_stocks,$YWWs,$max_YW,$max_YW,$YWs,$YWs);
        return view('User.shop.search_s_deliv',compact('companies','s_delivs_all','s_delivs','max_YW','min_YW','YWs'));
    }

    public function s_search_form_h_deliv(Request $request)
    {
        $companies = Company::with('shop')
        ->whereHas('shop',function($q){$q->where('is_selling','=',1);})
        ->where('id','>',1000)
        ->where('id','<',4000)->get();

        $h_delivs_all = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->get();

        $h_delivs = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.id','LIKE','%'.($request->sh_id).'%')
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->selectRaw('SUM(pcs) as pcs')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->get();

        $YWs=DB::table('deliveries')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();


        $max_YW=Delivery::max('YW');
        $max_YW=Delivery::max('YW');
        $min_YW=Delivery::max('YW');
        // dd($h_sales,$h_sales_all);
        return view('User.shop.search_h_deliv',compact('companies','h_delivs_all','h_delivs','max_YW','min_YW','YWs'));
    }



    public function s_form_m_sales($id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();


        $m_sales = Sale::where('shop_id',$id)
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();

        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($m_sales,$s_stocks,$companies);
        return view('User.shop.m_sales',compact('m_sales','s_stocks','shops','all_stocks'));
    }

    public function s_form_w_sales($id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $w_sales = Sale::where('shop_id',$id)
        ->select('YW','YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();
        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($companies,$m_sales,$m_sales_all);
        return view('User.shop.w_sales',compact('w_sales','s_stocks','shops','all_stocks'));
    }

    public function s_form_u_sales(Request $request,$id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $u_sales_all = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();

        $u_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('sales.shop_id',$id)
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();
        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $YWs=DB::table('sales')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();
        $max_YW=Sale::max('YW');
        $max_YM=Sale::max('YM');
        $min_YW=Sale::max('YW');
        // dd($companies,$u_sales,$u_sales_all,$c_stocks,$all_stocks,$max_YW,$max_YW,$YWs,$YWs);
        return view('User.shop.u_sales',compact('shops','u_sales_all','u_sales','s_stocks','all_stocks','max_YW','min_YW','YWs'));

    }

    public function s_form_s_sales(Request $request, $id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $s_sales_all = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','units.season_id','units.season_name'])
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','units.season_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();
        $s_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('sales.shop_id',$id)
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','units.season_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();
        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $YWs=DB::table('sales')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();
        $max_YW=Sale::max('YW');
        $max_YM=Sale::max('YM');
        $min_YW=Sale::max('YW');
        // dd($companies,$s_sales,$s_sales_all,$c_stocks,$all_stocks,$YWWs,$max_YW,$max_YW,$YWs,$YWs);
        return view('User.shop.s_sales',compact('shops','s_sales_all','s_sales','s_stocks','all_stocks','max_YW','min_YW','YWs'));
    }

    public function s_form_h_sales(Request $request, $id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $h_sales_all = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->get();

        $h_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('sales.shop_id',$id)
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->selectRaw('SUM(pcs) as pcs')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->get();

        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $YWs=DB::table('sales')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();
        $max_YW=Sale::max('YW');
        $max_YM=Sale::max('YM');

        // $YWs=Sale::YWs()->get();

        $max_YW=Sale::max('YW');
        $max_YW=Sale::max('YW');
        $min_YW=Sale::max('YW');
        // dd($h_sales,$h_sales_all);
        return view('User.shop.h_sales',compact('shops','h_sales_all','h_sales','s_stocks','all_stocks','max_YW','min_YW','YWs'));
    }

    public function s_form_hz_stocks(Request $request,$id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $h_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('stocks.shop_id',$id)
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
        ->select('stocks.hinban_id','hinbans.hinmei','hinbans.unit_id')
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy('stocks.hinban_id','hinbans.hinmei','hinbans.unit_id')
        ->orderBy('pcs','desc')
        ->get(['stocks.hinban_id','hinbans.hinmei','stocks.pcs','stocks.zaikogaku','hinbans.unit_id']);

        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($h_stocks,$h_stocks_all,$all_stocks,$c_stocks);
        return view('User.shop.hz_stocks',compact('shops','h_stocks','all_stocks','h_stocks_all','s_stocks'));
    }

    public function s_form_uz_stocks($id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $u_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('stocks.shop_id',$id)
        ->select(['hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['hinbans.unit_id','units.season_name'])
        ->get();

        $u_stocks_all = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['hinbans.unit_id','units.season_name'])
        ->get();

        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($h_sales,$h_sales_all);
        return view('User.shop.uz_stocks',compact('shops','s_stocks','all_stocks','u_stocks','u_stocks_all'));
    }

    public function s_form_sz_stocks(Request $request,$id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $season_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('stocks.shop_id',$id)
        ->select(['units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['units.season_id','units.season_name'])
        ->get();

        $season_stocks_all = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->groupBy(['units.season_id','units.season_name'])
        ->get();

        $s_stocks = Stock::where('shop_id',$id)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        $all_stocks = DB::table('stocks')
        // ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($h_sales,$h_sales_all);
        return view('User.shop.sz_stocks',compact('shops','season_stocks','all_stocks','season_stocks_all','s_stocks'));
    }

    public function s_form_m_deliv(Request $request,$id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $m_delivs = Delivery::where('shop_id',$id)
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();

        return view('User.shop.m_deliv',compact('m_delivs','shops'));
    }

    public function s_form_w_deliv(Request $request, $id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $w_delivs = Delivery::where('shop_id',$id)
        ->select('YW','YM','deliv_date')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM','deliv_date')
        ->orderBy('deliv_date','desc')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();

        return view('User.shop.w_deliv',compact('w_delivs','shops'));
    }

    public function s_form_u_deliv(Request $request,$id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $u_delivs_all = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();

        $u_delivs = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('deliveries.shop_id',$id)
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
        $max_YW=Delivery::max('YW');
        $max_YM=Delivery::max('YM');
        $min_YW=Delivery::max('YW');
        // dd($companies,$u_sales,$u_sales_all,$c_stocks,$all_stocks,$max_YW,$max_YW,$YWs,$YWs);
        return view('User.shop.u_deliv',compact('shops','u_delivs_all','u_delivs','max_YW','min_YW','YWs'));

    }

    public function s_form_s_deliv(Request $request,$id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $s_delivs_all = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','units.season_id','units.season_name'])
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
        ->where('deliveries.shop_id',$id)
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
        $max_YW=Delivery::max('YW');
        $max_YM=Delivery::max('YM');
        $min_YW=Delivery::max('YW');
        // dd($companies,$s_sales,$s_sales_all,$c_stocks,$all_stocks,$YWWs,$max_YW,$max_YW,$YWs,$YWs);
        return view('User.shop.s_deliv',compact('shops','s_delivs_all','s_delivs','max_YW','min_YW','YWs'));
    }

    public function s_form_h_deliv(Request $request,$id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        $h_delivs_all = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->select(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->get();

        $h_delivs = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('deliveries.shop_id',$id)
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->selectRaw('SUM(pcs) as pcs')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->get();

        $YWs=DB::table('deliveries')
        ->select(['YW','YM'])
        ->groupBy(['YW','YM'])
        ->orderBy('YM','desc')
        ->orderBy('YW','desc')
        ->get();


        $max_YW=Delivery::max('YW');
        $max_YW=Delivery::max('YW');
        $min_YW=Delivery::max('YW');
        // dd($h_sales,$h_sales_all);
        return view('User.shop.h_deliv',compact('shops','h_delivs_all','h_delivs','max_YW','min_YW','YWs'));
    }

    public function s_sales_rank(Request $request)
    {
        $s_ranks = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('companies','shops.company_id','=','companies.id')
        ->where('sales.shop_id','>',1000)->where('sales.shop_id','<',4000)
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->orderBy('kingaku','desc')
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
        return view('User.shop.s_sales_rank',compact('s_ranks','max_YM','max_YW','YWs','min_YW'));
    }



}
