<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\Rules\Password;
use Illuminate\Validation\Rules;
use Throwable;
use Illuminate\Support\Facades\Log;
use App\Models\Shop;

class UsersController extends Controller
{
    public function __construct(){
        $this->middleware('auth:admin');
        }


    public function index()
    {
        $users = User::select('id','name','email','created_at')->paginate(10);
        return view('admin.users.index',compact('users'));
    }


    public function create()
    {
        return view('admin.users.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        try{
            DB::transaction(function()use($request){
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);

            },2);
        }catch(Throwable $e){
            Log::error($e);
            throw $e;
        }

        return to_route('admin.users.index')->with(['message'=>'登録されました','status'=>'info']);
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $user=User::findOrFail($id);
        return view('admin.users.edit',compact('user'));
    }


    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=Hash::make($request->password);
        $user->save();

        return to_route('admin.users.index')->with(['message'=>'更新されました','status'=>'info']);
    }


    public function destroy($id)
    {
        // dd('delete');
        User::findOrFail($id)->delete();

        return to_route('admin.users.index')->with(['message'=>'削除されました','status'=>'alert']);
    }
}
