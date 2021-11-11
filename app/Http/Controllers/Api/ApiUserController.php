<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ApiUserController extends Controller
{
    public function read($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'user was not found',
            ], 400);
        }
        return response()->json([
            'success' => true,
            'data' => $user->toArray(),
        ], 200);
    }

    public function browse()
    {
        $users = User::paginate(5);

        if (is_null($users)) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to find users',
            ], 400);
        }
        return response()->json([
            'success' => true,
            'users' => $users,

        ], 200);

    }

    public function add(Request $request)
    {
        $validation = $this->validate_request($request);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()->toArray(),
            ], 400);
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'User has been saved',
                'data' => $user->toArray(),
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Error occurred creating user"
        ], 400);

    }

    public function edit(Request $request, User $user)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['string', 'max:255',],
            'email' => ['email', 'email:rfc', 'string', Rule::unique('users')->ignore($user)],
            'password' => ['string',
                Password::min(4)
                    ->letters()
                //->mixedCase()
                //->numbers()
                //->symbols()
            ],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()->toArray(),
            ], 400);
        }

        foreach ($request->keys() as $key) {
            if($key == 'password'){
                $user[$key] = Hash::make($request[$key]);
            }
            $user[$key] = $request[$key];
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'user was successfully updated',
            'data' => $user->toArray(),
        ]);

    }

    public function update_all(Request $request, User $user)
    {
        $validation = $this->validate_request($request, $user);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()->toArray(),
            ], 400);
        }

        foreach ($request->keys() as $key) {
            if ($key == 'password') {
                $user[$key] = Hash::make($request[$key]);
            }
            $user[$key] = $request[$key];
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'user has been successfully updated',
            'data' => $user->toArray(),
        ], 200);


    }

    public function delete($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            return response()->json([
                'success' => false,
                'message' => 'Requested user was not found in the collection',
            ]);
        }

        if ($user->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'User was successfully deleted'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Error occurred whilst deleting user',
        ]);



    }

    public function validate_request(Request $request, User $user=null)
    {
        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255',],
            'email' => ['required', 'email', 'email:rfc', 'string', Rule::unique('users')->ignore($user)],
            'password' => ['required', 'string',
                Password::min(4)
                    ->letters()
                //->mixedCase()
                //->numbers()
                //->symbols()
            ],
        ]);
        return $validation;
    }
}
