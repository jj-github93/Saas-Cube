<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function __construct(){
        $this->middleware('permission:user-list|user-create|user-edit|user-delete|view-own-profile',
            ['only' => ['index', 'store']]
        );
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit|edit-own-profile', ['only' => 'edit', 'update']);
        $this->middleware('permission:user-delete', ['only' => 'destroy', 'delete']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $authUser = auth()->user();
        $authUserRole = $authUser->roles()->pluck('name')->first();
        if($authUserRole == 'Admin'){
            $users = User::paginate(5);
        }
        else if($authUserRole == 'Manager'){
            $users = User::whereNotIn('name', ['Admin'])->paginate(5);
        }
        else{
            $users = User::where('id', $authUser->id)->first();
        }

        return view('admin.users.index', compact(['users', 'authUser', 'authUserRole']))
            ->with("i", (\request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //ddd($request);

        $request->validate([
            'name' => ['required', 'string', 'max:255',],
            'email' => ['required', 'email', 'email:rfc', 'string', 'unique:users'],
            'password' => ['required', 'confirmed', 'string',
                Password::min(4)
                    ->letters()
                //->mixedCase()
                //->numbers()
                //->symbols()
            ],
            'password_confirmation' => ['required', 'string', 'required_with:password'],
            'roles' => ['required'],
        ]);

        $inputs = $request->all();
        $inputs['password'] = Hash::make($inputs['password']);

        $user = User::create($inputs);
        $user->assignRole($request->input('roles'));

//        User::create([
//            'name' => $request->input('name'),
//            'email' => $request->input('email'),
//            'password' => Hash::make($request->input('password'))
//        ]);


        return redirect(route('users.index'))->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $authUser = auth()->user();
        $authUserRole = auth()->user()->roles()->pluck('name')->first();
        $userRole = $user->roles()->pluck('name')->first();

        return view('admin.users.show', compact('user', 'userRole','authUserRole', 'authUser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->first();
        return view('admin.users.update', compact(['user', 'userRoles', 'roles']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Rules for validating inputs entered by user
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['string', 'email', 'email:rfc', Rule::unique('users')->ignore($user)],
            'roles' => ['required'],
            'password' => (isset($request->password) && !is_null($request->password) ? [
                'string', 'confirmed',
                Password::min(4)
                    ->letters()
                    ->numbers()
//                    ->symbols()
//                    ->mixedCase()
            ] : [null]),
        ]);

        $inputs = $request->all();

        if(!empty($inputs['password'])){
            $inputs['password'] = Hash::make($inputs['password']);
        }
        else{
            $inputs = Arr::except($inputs, array('password'));
        }
        $user->update($inputs);

        DB::table('model_has_roles')
            ->where('model_id', $user->id)
            ->delete();
        $user->assignRole($request->input(['roles']));

//        if (!is_null($request->input('password')) && ($request->input('password') != $user->password)) {
//            $user->password = Hash::make($request->input('password'));
//        }
//        if (isset($request['name']) && ($request->input('name') != $user->name)) {
//            $user->name = $request->input('name');
//        }
//        if (isset($request['email']) && ($request->input('email') != $user->email)) {
//            $user->email = $request->input('email');
//        }
//          $user->save();
        return redirect(route('users.index'))
            ->with('success', 'User updated successfully');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect(route('users.index'))
            ->with('success', 'User has been deleted');
    }


}
