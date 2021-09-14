<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(5);
        return view('admin.users.index', compact(['users']))
            ->with("i", (\request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'confirm_password' => 'required',
        ]);

        User::create([
            'name' => $request->input('name'),
            'password' => $request->input('password'),
            'email' => $request->input('email'),
        ]);
        return redirect(route('users.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.update', compact(['user']));
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
        $patches = [
            'name' => !is_null(($request->input('name'))) ? $request->input('name') : $user->name,
            'email' => !is_null($request->input('password'))
                ? $request->input('email') : $user->email,
            'password' => !is_null($request->input('password')) ?
                Hash::make($request->input('password')) : $user->password,
        ];
        $user->update($patches);
        return redirect(route('users.index'));
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
        return redirect(route('users.index'));
    }


}
