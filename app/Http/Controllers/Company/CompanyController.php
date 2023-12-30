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

        $m_sales_all = DB::table('sales')
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();
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
        $all_stocks = DB::table('stocks')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        // dd($companies,$m_sales,$m_sales_all);
        return view('User.company.search_m_sales',compact('companies','m_sales_all','m_sales','c_stocks','all_stocks'));
    }

    public function search_form_w_sales(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $w_sales_all = DB::table('sales')
        ->select('YW','YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();
        $w_sales = Sale::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->select('YW','YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();
        $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        $all_stocks = DB::table('stocks')
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        // dd($companies,$m_sales,$m_sales_all);
        return view('User.company.search_w_sales',compact('companies','w_sales_all','w_sales','c_stocks','all_stocks'));
    }

    public function search_form_u_sales(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        // $u_sales_all = DB::table('sales')
        // ->join('shops','sales.shop_id','=','shops.id')
        // ->join('hinbans','sales.hinban_id','=','hinbans.id')
        // ->join('units','hinbans.unit_id','=','units.id')
        // ->select(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        // ->where('sales.YW','>=',($request->YW1 ?? '0'))
        // ->where('sales.YW','<=',($request->YW2 ?? '0'))
        // ->selectRaw('SUM(pcs) as pcs')
        // ->selectRaw('SUM(kingaku) as kingaku')
        // ->groupBy(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        // ->orderBy('pcs','desc')
        // ->get();
        $u_sales = DB::table('sales')
        ->join('shops','sales.shop_id','=','shops.id')
        ->join('hinbans','sales.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();
        // $u_sales = Sale::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        // ->with(['hinbans'])
        // ->with('units')
        // ->select(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        // ->where('sales.YW','>=',($request->YW1 ?? '0'))
        // ->where('sales.YW','<=',($request->YW2 ?? '0'))
        // ->selectRaw('SUM(pcs) as pcs')
        // ->selectRaw('SUM(kingaku) as kingaku')
        // ->groupBy(['hinbans.year_code','hinbans.unit_id','units.season_name'])
        // ->orderBy('pcs','desc')
        // ->get();
        $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        // $all_stocks = DB::table('stocks')
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->get();

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
        return view('User.company.search_u_sales',compact('companies','u_sales','c_stocks','max_YM','max_YW','YWs','min_YW'));
    }

    public function search_form_s_sales(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

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
        // ->where('shops.company_id','=',$request->co_id)
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','units.season_id','units.season_name'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','units.season_id','units.season_name'])
        ->orderBy('pcs','desc')
        ->get();
        // $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id',$request->co_id);})
        $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();
        $all_stocks = DB::table('stocks')
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
        return view('User.company.search_s_sales',compact('companies','s_sales_all','s_sales','c_stocks','all_stocks','max_YM','max_YW','min_YW','YWs'));
    }

    public function search_form_h_sales(Request $request)
    {
        $companies = Company::where('id','>',1000)->where('id','<',4000)->select('id','co_name')->get();

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
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('sales.YW','>=',($request->YW1 ?? Sale::max('YW')))
        ->where('sales.YW','<=',($request->YW2 ?? Sale::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','sales.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->get();

        $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        $all_stocks = DB::table('stocks')
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
        return view('User.company.search_h_sales',compact('companies','h_sales_all','h_sales','c_stocks','all_stocks','max_YM','min_YW','max_YW','YWs'));
    }

    public function search_form_hz_stocks(Request $request)
    {
        $companies = Company::where('id','>',1000)->where('id','<',4000)->select('id','co_name')->get();

        // $h_stocks = Stock::with('hinban')
        // ->whereHas('shop',function($q)use($request){$q->where('company_id',($request->co_id ?? '0'));})
        // ->select('hinban_id')
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->groupBy('hinban_id')
        // ->orderBy('pcs','desc')
        // ->get(['hinban_id','hinmei','pcs','zaikogaku']);

        // $h_stocks_all = Stock::with('hinban')
        // ->select('hinban_id')
        // ->selectRaw('SUM(zaikogaku) as zaikogaku')
        // ->selectRaw('SUM(pcs) as pcs')
        // ->groupBy('hinban_id')
        // ->orderBy('pcs','desc')
        // ->get(['hinban_id','hinmei','pcs','zaikogaku']);

        $h_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
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

        $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        $all_stocks = DB::table('stocks')
        ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($h_stocks,$h_stocks_all,$all_stocks,$c_stocks);
        return view('User.company.search_hz_stocks',compact('companies','h_stocks','all_stocks','h_stocks_all','c_stocks'));
    }

    public function search_form_uz_stocks(Request $request)
    {
        $companies = Company::where('id','>',1000)->where('id','<',4000)->select('id','co_name')->get();

        $u_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
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

        $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        $all_stocks = DB::table('stocks')
        ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($h_sales,$h_sales_all);
        return view('User.company.search_uz_stocks',compact('companies','u_stocks','all_stocks','c_stocks','u_stocks_all'));
    }

    public function search_form_sz_stocks(Request $request)
    {
        $companies = Company::where('id','>',1000)->where('id','<',4000)->select('id','co_name')->get();

        $season_stocks = DB::table('stocks')
        ->join('shops','stocks.shop_id','=','shops.id')
        ->join('hinbans','stocks.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
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

        $c_stocks = Stock::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();


        $all_stocks = DB::table('stocks')
        ->where('shop_id','>',1000)->where('shop_id','<',4000)
        ->selectRaw('SUM(zaikogaku) as zaikogaku')
        ->selectRaw('SUM(pcs) as pcs')
        ->get();

        // dd($h_sales,$h_sales_all);
        return view('User.company.search_sz_stocks',compact('companies','season_stocks','all_stocks','season_stocks_all','c_stocks'));
    }

    public function search_form_m_deliv(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $m_delivs_all = DB::table('deliveries')
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();
        $m_delivs = Delivery::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->select('YM')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YM')
        ->orderBy('YM','desc')
        ->get();

        // dd($companies,$m_sales,$m_sales_all);
        return view('User.company.search_m_deliv',compact('companies','m_delivs_all','m_delivs'));
    }

    public function search_form_w_deliv(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $w_delivs_all = DB::table('deliveries')
        ->select('YW','YM','deliv_date')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM','deliv_date')
        ->orderBy('deliv_date','desc')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();
        $w_delivs = Delivery::whereHas('shop',function($q)use($request){$q->where('company_id','LIKE','%'.$request->co_id.'%');})
        ->select('YW','YM','deliv_date')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy('YW','YM','deliv_date')
        ->orderBy('deliv_date','desc')
        ->orderBy('YW','desc')
        ->orderBy('YM','desc')
        ->get();

        // dd($companies,$m_sales,$m_sales_all);
        return view('User.company.search_w_deliv',compact('companies','w_delivs_all','w_delivs'));
    }

    public function search_form_u_deliv(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

        $u_delivs = DB::table('deliveries')
        ->join('shops','deliveries.shop_id','=','shops.id')
        ->join('hinbans','deliveries.hinban_id','=','hinbans.id')
        ->join('units','hinbans.unit_id','=','units.id')
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
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
        return view('User.company.search_u_deliv',compact('companies','u_delivs','max_YM','max_YW','YWs','min_YW'));
    }

    public function search_form_s_deliv(Request $request)
    {
        $companies = Company::where('id','>',1000)->select('id','co_name')->get();

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
        // ->where('shops.company_id','=',$request->co_id)
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
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
        return view('User.company.search_s_deliv',compact('companies','s_delivs_all','s_delivs','max_YM','max_YW','min_YW','YWs'));
    }

    public function search_form_h_deliv(Request $request)
    {
        $companies = Company::where('id','>',1000)->where('id','<',4000)->select('id','co_name')->get();

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
        ->where('shops.company_id','LIKE','%'.$request->co_id.'%')
        ->where('deliveries.YW','>=',($request->YW1 ?? Delivery::max('YW')))
        ->where('deliveries.YW','<=',($request->YW2 ?? Delivery::max('YW')))
        ->select(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->selectRaw('SUM(pcs) as pcs')
        ->selectRaw('SUM(kingaku) as kingaku')
        ->groupBy(['hinbans.year_code','hinbans.unit_id','deliveries.hinban_id','hinbans.hinmei'])
        ->orderBy('pcs','desc')
        ->get();


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
        return view('User.company.search_h_deliv',compact('companies','h_delivs_all','h_delivs','max_YM','min_YW','max_YW','YWs'));
    }



}
