<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiPlaylistController extends Controller
{
    public function find($id)
    {
        $playlist = Playlist::find($id);
        if (!$playlist) {
            return response()->json([
                'success' => false,
                'message' => 'Playlist was not found',
            ], 400);
        }
        return response()->json([
            'success' => true,
            'data' => $playlist->toArray(),
        ], 200);
    }

    public function all()
    {
        $playlists = Playlist::all();

        if (!is_null($playlists)) {
            return response()->json([
                'success' => true,
                'data' => $playlists->toArray(),
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Unable to find playlists',
        ], 400);
    }

    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'protected' => 'required|bool',
            'user_id' => ['nullable', 'exists:users,id']
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()->toArray(),
            ], 400);
        }


        $playlist = Playlist::create([
            'name' => $request->input('name'),
            'protected' => $request->input('protected'),
            'user_id' => $request->input('user_id'),
        ]);


        if ($playlist) {
            return response()->json([
                'success' => true,
                'message' => 'Playlist has been saved',
                'data' => $playlist->toArray(),
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Error occurred creating playlist"
        ], 400);

    }

    public function edit(Request $request, Playlist $playlist)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'protected' => 'bool',
            'user_id' => 'exists:users,id',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()->toArray(),
            ], 400);
        }

        if (!is_null($request->input('name'))) {
            $playlist->name = $request->input('name');
        }
        if (!is_null($request->input('protected'))) {
            $playlist->protected = $request->input('protected');
        }
        if (!is_null($request->input('user_id'))) {
            $playlist->user_id = $request->input('user_id');
        }

        $playlist->save();

        return response()->json([
            'success' => true,
            'message' => 'Playlist was successfully updated',
            'data' => $playlist->toArray(),
        ]);

    }

    public function update_all(Request $request, Playlist $playlist)
    {

        if ($request['user_id'] == 'null') {
            $request['user_id'] = null;
        }


        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'protected' => 'required|bool',
            'user_id' => 'nullable|exists:users,id',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()->toArray(),
            ], 400);
        }

        $playlist->name = $request['name'];
        $playlist->protected = (bool)$request['protected'];
        $playlist->user_id = $request['user_id'];

        $playlist->save();

        return response()->json([
            'success' => true,
            'message' => 'Playlist has been successfully updated',
            'data' => $playlist->toArray(),
        ], 200);


    }

    public function delete($id)
    {
        $playlist = Playlist::find($id);

        if(is_null($playlist)){
            return response()->json([
                'success' => false,
                'message' => 'Requested playlist was not found in the collection',
            ]);
        }

        $playlist->tracks()->detach();

        $success = $playlist->delete();

        if(!$success){
            return response()->json([
                'success' => false,
                'message' => 'Error occurred whilst deleting playlist',
            ]);
        }

        return response()->json([
            'success' => $success,
            'message' => 'Playlist was successfully deleted'
        ]);



    }

    public function rules($name, $protected, $user_id)
    {

    }
}
