<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Image;
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function($request, $next){
            $id = $request->route()->parameter('image'); //shopのid取得
            if(!is_null($id)){ // null判定
            $imagesOwnerId = Image::findOrFail($id)->owner->id;
            $imageId = (int)$imagesOwnerId; // キャスト 文字列→数値に型変換
            $ownerId = Auth::id();
            if($imageId !== $ownerId){ // 同じでなかったら
            abort(404); // 404画面表示
            }
            }
            return $next($request);
            });
    }

    public function index()
    {
        $ownerId=Auth::id();
        $images=Image::where('owner_id',$ownerId)
        ->orderby('updated_at','desc')->paginate(8);
        return view('owner.images.index',compact('images'));
    }


    public function create()
    {
        return view('owner.images.create');
    }


    public function store(UploadImageRequest $request)
    {
        // dd($request->file('files'));
        $imageFiles = $request->file('files'); //配列でファイルを取得

        if(!is_null($imageFiles)){
        foreach($imageFiles as $imageFile){ // それぞれ処理
        $fileNameToStore = ImageService::upload($imageFile, 'products');
        Image::create([
        'owner_id' => Auth::id(),
        'filename' => $fileNameToStore
        ]);
        }
        }

        return to_route('owner.images.index')->with(['message'=>'画像が登録されました','status'=>'info']);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $image=Image::findOrFail($id);
        return view('owner.images.edit',compact('image'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['string', 'max:50'],

        ]);

        $image=Image::findOrFail($id);
        $image->title=$request->title;
        $image->save();

        return to_route('owner.images.index')->with(['message'=>'画像情報が更新されました','status'=>'info']);
    }


    public function destroy($id)
    {
        $image = Image::findOrFail($id);
        $failePath='public/prpducts/'.$image->filename;

        if(Storage::exists($failePath)){
            Storage::delete($failePath);
        }

        Image::findOrFail($id)->delete();

        return to_route('owner.images.index')->with(['message'=>'削除されました','status'=>'alert']);
    }

}
