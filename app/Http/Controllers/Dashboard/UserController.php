<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Intervention\Image\ImageManagerStatic as Image;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    function __construct(){

        $this->middleware('permission:user-list', ['only' => ['index']]);
        $this->middleware('permission:user-create', ['only' => ['create','store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);

    }


    /*** Display a listing of the resource.** @return \Illuminate\Http\Response*/

    public function index(Request $request)
    {

        $data = User::when($request->search,function ($q) use ($request){

            return $q->where('id','!=','1')
                    ->where('first_name','like',"%". $request->search ."%")
                    ->orWhere('last_name','like',"%". $request->search ."%");

        })->orderBy('id','ASC')->paginate(5);


        return view('dashboard.users.index',compact('data'))->with('i', ($request->input('page', 1) - 1) * 5);

    }


    public function create(){

        $roles = FacadesDB::table('roles')->where('name','!=','SuperAdmin')->get();

        return view('dashboard.users.add',compact('roles'));

    }


    /*** Store a newly created resource in storage.** @param  \Illuminate\Http\Request  $request* @return \Illuminate\Http\Response*/

    public function store(Request $request)
    {

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'Status'  => 'required',
            'roles_name' => 'required',
            'image' => 'image:png,jepg,jpg'
            ]);

            $input = $request->all();

            if(!$request->hasFile('image')){

                $input['image'] = '6.jpg';

            }else{

                // picture move
                $img = Image::make(request()->image)->resize(100, null, function ($constraint) {

                $constraint->aspectRatio();

                })->save(public_path('assets/img/faces/'. request()->image->hashName()));

                $input['image'] = $request->image->hashName();

            }

        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);

        $user->assignRole($request->input('roles_name'));

        return redirect()->route('dashboard.users.index')->with('success',trans('site.success'));
    }



    /*** Show the form for editing the specified resource.** @param  int  $id* @return \Illuminate\Http\Response*/

    public function edit($id)
    {

        $user = User::find($id);

        $roles = FacadesDB::table('roles')->where('name','!=','SuperAdmin')->get();

        $userRole = $user->roles->pluck('name','name')->all();

        return view('dashboard.users.edit',compact('user','roles','userRole'));
    }



    /*** Update the specified resource in storage.** @param  \Illuminate\Http\Request  $request* @param  int  $id* @return \Illuminate\Http\Response*/
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'Status'  => 'required',
            'roles_name' => 'required',
            'image' => 'image:png,jepg,jpg'
        ]);

        $user = User::find($id);
        $input = $request->all();

        if ($request->hasFile('image') && $user->image != '6.jpg'){

            Storage::disk('profile')->delete( $user->image );

            $img = Image::make(request()->image)->resize(100, null, function ($constraint) {

            $constraint->aspectRatio();

            })->save(public_path('assets/img/faces/'. request()->image->hashName()));

            $input['image'] = $request->image->hashName();

        }

        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));
        }

        $user = User::find($id);

        $user->update($input);

        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles_name'));

        return redirect()->route('dashboard.users.index')->with('success',trans('site.success'));
    }



    /*** Remove the specified resource from storage.** @param  int  $id* @return \Illuminate\Http\Response*/
    public function destroy(Request $request)
    {

        $user = User::find($request->user_id);

        if($user->image != '6.jpg')
            Storage::disk('profile')->delete( $user->image );

        $user->delete();

        return redirect()->route('dashboard.users.index')->with('success',trans('site.true-delete'));
    }
}
