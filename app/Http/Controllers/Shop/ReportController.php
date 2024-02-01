<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;
use InterventionImage;
use App\Models\Report;
use App\Models\Shop;
use App\Models\User;
use App\Models\Company;
use App\Models\Area;


class ReportController extends Controller
{
    public function __construct(){
        $this->middleware('auth:users');
        }


    public function report_list(Request $request)
    {
        $reports=DB::table('reports')
        ->join('shops','shops.id','=','reports.shop_id')
        ->join('companies','companies.id','=','shops.company_id')
        ->join('areas','areas.id','=','shops.area_id')
        ->select(['reports.id','shops.company_id','companies.co_name','reports.shop_id','shops.shop_name','areas.ar_name','shops.shop_info','reports.comment','reports.image1','reports.created_at','reports.updated_at'])
        ->where('shops.company_id','>','1000')
        ->where('shops.company_id','<','4000')
        ->where('shops.is_selling','=',1)
        ->where('shops.company_id','LIKE','%'.($request->co_id).'%')
        ->where('shops.area_id','LIKE','%'.($request->ar_id).'%')
        ->where('shops.shop_name','LIKE','%'.($request->sh_name).'%')
        ->orderBy('updated_at','desc')
        ->paginate(15);



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
        ->select('shops.id','shops.shop_name','shops.company_id','shops.area_id','areas.ar_name','companies.co_name')
        ->where('shops.company_id','>','1000')
        ->where('shops.company_id','<','4000')
        ->where('shops.is_selling','=',1)
        ->where('shops.company_id','LIKE','%'.($request->co_id).'%')
        ->where('shops.area_id','LIKE','%'.($request->ar_id).'%')
        ->where('shops.shop_name','LIKE','%'.($request->sh_name).'%')
        ->paginate(15);
        // dd($shops,$reports);

        return view('User.shop.report',compact('reports','areas','shops','companies'));
    }

    public function report_detail($id)
    {
        $report=DB::table('reports')
        ->join('shops','shops.id','=','reports.shop_id')
        ->join('companies','companies.id','=','shops.company_id')
        ->join('areas','areas.id','=','shops.area_id')
        ->join('users','users.id','=','reports.user_id')
        ->select(['reports.id','reports.user_id','users.name','shops.company_id','companies.co_name','reports.shop_id','shops.shop_name','areas.ar_name','shops.shop_info','reports.comment','reports.image1','reports.image2','reports.image3','reports.image4','reports.created_at'])
        ->where('reports.id',$id)
        ->first();

        $login_user=Auth::id();

        // dd($reports);

        return view('User.shop.report_detail',compact('report','login_user'));
    }

    public function report_create($id)
    {
        $shops = DB::table('shops')
        ->join('companies','companies.id','=','shops.company_id')
        ->where('shops.id',$id)
        ->select(['shops.company_id','companies.co_name','shops.id','shops.shop_name'])
        ->get();

        return view('User.shop.report_create',compact('shops'));
    }

    public function report_store(UploadImageRequest $request)
    {

        // dd($request->sh_id,$request->image1->extension(),$request->comment,$request->image2,$request->image3,$request->image4);
        $folderName='reports';
        if(!is_null($request->file('image1'))){
            $fileName1 = uniqid(rand().'_');
            $extension1 = $request->file('image1')->extension();
            $fileNameToStore1 = $fileName1. '.' . $extension1;
            Storage::putFileAs('public/reports', $request->file('image1'), $fileNameToStore1);
        }else{
            $fileNameToStore1 = '';
        };

        if(!is_null($request->file('image2'))){
            $fileName2 = uniqid(rand().'_');
            $extension2 = $request->file('image2')->extension();
            $fileNameToStore2 = $fileName2. '.' . $extension2;
            Storage::putFileAs('public/reports', $request->file('image2'), $fileNameToStore2);
        }else{
            $fileNameToStore2 = '';
        };
        if(!is_null($request->file('image3'))){
            $fileName3 = uniqid(rand().'_');
            $extension3 = $request->file('image3')->extension();
            $fileNameToStore3 = $fileName3. '.' . $extension3;
            Storage::putFileAs('public/reports', $request->file('image3'), $fileNameToStore3);
        }else{
            $fileNameToStore3 = '';
        };


        if(!is_null($request->file('image4'))){
            $fileName4 = uniqid(rand().'_');
            $extension4 = $request->file('image4')->extension();
            $fileNameToStore4 = $fileName4. '.' . $extension4;
            Storage::putFileAs('public/reports', $request->file('image4'), $fileNameToStore4);
        }else{
            $fileNameToStore4 = '';
        };

        // dd($request->sh_id,$request->comment);
        Report::create([
            'shop_id' => $request->sh_id2,
            'image1' => $fileNameToStore1,
            'image2' => $fileNameToStore2,
            'image3' => $fileNameToStore3,
            'image4' => $fileNameToStore4,
            'comment' => $request->comment,
        ]);



        return to_route('user.shop.report_list')->with(['message'=>'Reportが登録されました','status'=>'info']);
    }

    public function report_store_rs(UploadImageRequest $request)
    {

        // dd($request->sh_id,$request->image1->extension(),$request->comment,$request->image2,$request->image3,$request->image4);

        $user = User::findOrFail(Auth::id());
        $folderName='reports';
        if(!is_null($request->file('image1'))){
            $fileName1 = uniqid(rand().'_');
            $extension1 = $request->file('image1')->extension();
            $fileNameToStore1 = $fileName1. '.' . $extension1;
            $resizedImage1 = InterventionImage::make($request->file('image1'))->resize(400, 400,function($constraint){$constraint->aspectRatio();})->encode();
            Storage::put('public/reports/' . $fileNameToStore1, $resizedImage1 );
        }else{
            $fileNameToStore1 = '';
        };

        if(!is_null($request->file('image2'))){
            $fileName2 = uniqid(rand().'_');
            $extension2 = $request->file('image2')->extension();
            $fileNameToStore2 = $fileName2. '.' . $extension2;
            $resizedImage2 = InterventionImage::make($request->file('image2'))->resize(400, 400,function($constraint){$constraint->aspectRatio();})->encode();
            Storage::put('public/reports/' . $fileNameToStore2, $resizedImage2 );
        }else{
            $fileNameToStore2 = '';
        };
        if(!is_null($request->file('image3'))){
            $fileName3 = uniqid(rand().'_');
            $extension3 = $request->file('image3')->extension();
            $fileNameToStore3 = $fileName3. '.' . $extension3;
            $resizedImage3 = InterventionImage::make($request->file('image3'))->resize(400, 400,function($constraint){$constraint->aspectRatio();})->encode();
            Storage::put('public/reports/' . $fileNameToStore3, $resizedImage3 );
        }else{
            $fileNameToStore3 = '';
        };


        if(!is_null($request->file('image4'))){
            $fileName4 = uniqid(rand().'_');
            $extension4 = $request->file('image4')->extension();
            $fileNameToStore4 = $fileName4. '.' . $extension4;
            $resizedImage4 = InterventionImage::make($request->file('image4'))->resize(400, 400,function($constraint){$constraint->aspectRatio();})->encode();
            Storage::put('public/reports/' . $fileNameToStore4, $resizedImage4 );
        }else{
            $fileNameToStore4 = '';
        };

        // dd($request->sh_id,$request->comment);
        Report::create([
            'user_id' => $user->id,
            'shop_id' => $request->sh_id2,
            'image1' => $fileNameToStore1,
            'image2' => $fileNameToStore2,
            'image3' => $fileNameToStore3,
            'image4' => $fileNameToStore4,
            'comment' => $request->comment,
        ]);



        return to_route('user.shop.report_list')->with(['message'=>'Reportが登録されました','status'=>'info']);
    }


    public function report_edit($id)
    {
        $report=DB::table('reports')
        ->join('shops','shops.id','=','reports.shop_id')
        ->join('companies','companies.id','=','shops.company_id')
        ->select(['reports.id','reports.user_id','shops.company_id','companies.co_name','reports.shop_id','shops.shop_name','reports.comment','reports.image1','reports.image2','reports.image3','reports.image4','reports.created_at'])
        ->where('reports.id',$id)
        ->first();
        // dd($report);
        return view('User.shop.report_edit',compact('report'));
    }

    public function report_update(Request $request, $id)
    {
        $report=Report::findOrFail($id);

        if(!is_null($request->file('image1'))){
            $fileName1 = uniqid(rand().'_');
            $extension1 = $request->file('image1')->extension();
            $fileNameToStore1 = $fileName1. '.' . $extension1;
            Storage::putFileAs('public/reports', $request->file('image1'), $fileNameToStore1);
        }else{
            $fileNameToStore1 = $report->image1;
        };

        if(!is_null($request->file('image2'))){
            $fileName2 = uniqid(rand().'_');
            $extension2 = $request->file('image2')->extension();
            $fileNameToStore2 = $fileName2. '.' . $extension2;
            Storage::putFileAs('public/reports', $request->file('image2'), $fileNameToStore2);
        }else{
            $fileNameToStore2 = $report->image2;
        };
        if(!is_null($request->file('image3'))){
            $fileName3 = uniqid(rand().'_');
            $extension3 = $request->file('image3')->extension();
            $fileNameToStore3 = $fileName3. '.' . $extension3;
            Storage::putFileAs('public/reports', $request->file('image3'), $fileNameToStore3);
        }else{
            $fileNameToStore3 = $report->image3;
        };


        if(!is_null($request->file('image4'))){
            $fileName4 = uniqid(rand().'_');
            $extension4 = $request->file('image4')->extension();
            $fileNameToStore4 = $fileName4. '.' . $extension4;
            Storage::putFileAs('public/reports', $request->file('image4'), $fileNameToStore4);
        }else{
            $fileNameToStore4 = $report->image4;
        };

        $report->image1 = $fileNameToStore1;
        $report->image2 = $fileNameToStore2;
        $report->image3 = $fileNameToStore3;
        $report->image4 = $fileNameToStore4;
        $report->comment = $request->comment;

        // dd($request->sh_id,$fileNameToStore1,$fileNameToStore2,$fileNameToStore3,$fileNameToStore4);

        $report->save();

        return to_route('user.shop.report_list')->with(['message'=>'Reportが更新されました','status'=>'info']);
    }

    public function report_update_rs(Request $request, $id)
    {
        $report=Report::findOrFail($id);

        $user = User::findOrFail(Auth::id());

        if(!is_null($request->file('image1'))){
            $fileName1 = uniqid(rand().'_');
            $extension1 = $request->file('image1')->extension();
            $fileNameToStore1 = $fileName1. '.' . $extension1;
            $resizedImage1 = InterventionImage::make($request->file('image1'))->resize(400, 400,function($constraint){$constraint->aspectRatio();})->encode();
            Storage::put('public/reports/' . $fileNameToStore1, $resizedImage1 );
        }else{
            $fileNameToStore1 = $report->image1;
        };

        if(!is_null($request->file('image2'))){
            $fileName2 = uniqid(rand().'_');
            $extension2 = $request->file('image2')->extension();
            $fileNameToStore2 = $fileName2. '.' . $extension2;
            $resizedImage2 = InterventionImage::make($request->file('image2'))->resize(400, 400,function($constraint){$constraint->aspectRatio();})->encode();
            Storage::put('public/reports/' . $fileNameToStore2, $resizedImage2 );
        }else{
            $fileNameToStore2 = $report->image2;
        };
        if(!is_null($request->file('image3'))){
            $fileName3 = uniqid(rand().'_');
            $extension3 = $request->file('image3')->extension();
            $fileNameToStore3 = $fileName3. '.' . $extension3;
            $resizedImage3 = InterventionImage::make($request->file('image3'))->resize(400, 400,function($constraint){$constraint->aspectRatio();})->encode();
            Storage::put('public/reports/' . $fileNameToStore3, $resizedImage3 );
        }else{
            $fileNameToStore3 = $report->image3;
        };


        if(!is_null($request->file('image4'))){
            $fileName4 = uniqid(rand().'_');
            $extension4 = $request->file('image4')->extension();
            $fileNameToStore4 = $fileName4. '.' . $extension4;
            $resizedImage4 = InterventionImage::make($request->file('image4'))->resize(400, 400,function($constraint){$constraint->aspectRatio();})->encode();
            Storage::put('public/reports/' . $fileNameToStore4, $resizedImage4 );
        }else{
            $fileNameToStore4 = $report->image4;
        };

        $report->image1 = $fileNameToStore1;
        $report->image2 = $fileNameToStore2;
        $report->image3 = $fileNameToStore3;
        $report->image4 = $fileNameToStore4;
        $report->comment = $request->comment;

        // dd($request->sh_id,$fileNameToStore1,$fileNameToStore2,$fileNameToStore3,$fileNameToStore4);

        $report->save();

        return to_route('user.shop.report_list')->with(['message'=>'Reportが更新されました','status'=>'info']);
    }


    public function report_destroy($id)
    {

        Report::findOrFail($id)->delete();

        return to_route('user.shop.report_list')->with(['message'=>'削除されました','status'=>'alert']);

    }



}
