<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

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
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
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
        // Rules for validating inputs entered by user
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['string', 'email', 'email:rfc', Rule::unique('users')->ignore($user)],
            'password' => (isset($request->password) && !is_null($request->password) ? [
                'string', 'confirmed',
                Password::min(4)
                    ->letters()
//                    ->numbers()
//                    ->symbols()
//                    ->mixedCase()
            ] : [null]),
        ]);

        if (!is_null($request->input('password')) && ($request->input('password') != $user->password)) {
            $user->password = Hash::make($request->input('password'));
        }
        if (isset($request['name']) && ($request->input('name') != $user->name)) {
            $user->name = $request->input('name');
        }
        if (isset($request['email']) && ($request->input('email') != $user->email)) {
            $user->email = $request->input('email');
        }

        $user->save();
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
