<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Tracks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiGenreController extends Controller
{
    public function read($id)
    {
        $genre = Genre::find($id);
        if (!$genre) {
            return response()->json([
                'success' => false,
                'message' => 'Genre was not found',
            ], 400);
        }
        return response()->json([
            'success' => true,
            'data' => $genre->toArray(),
        ], 200);
    }

    public function browse()
    {
        $genres = Genre::paginate(10);

        if (is_null($genres)) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to find genres',
            ], 400);
        }
        return response()->json([
            'success' => true,
            'genres' => $genres,

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

        $genre = Genre::create([
            'name' => $request['name'],
            'genre_id' => $request['genre_id'],
            'icon' => $request['icon'] ?? '000-unknown.png',
        ]);

        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'genre has been saved',
                'data' => $genre->toArray(),
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Error occurred creating genre"
        ], 400);

    }

    public function edit(Request $request, Genre $genre)
    {
        if ($request['parent_id'] == 'null') {
            $request['parent_id'] = null;
        }

        $validation = Validator::make($request->all(), [
            'name' => ['string', 'max:255',],
            'parent_id' => ['nullable', 'exists:genres,id',],
            'icon' => ['string', 'max:255'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()->toArray(),
            ], 400);
        }

        foreach ($request->keys() as $key) {
            if (isset($request[$key])) {
                $genre[$key] = $request[$key];
            }
        }

        $genre->save();

        return response()->json([
            'success' => true,
            'message' => 'genre was successfully updated',
            'data' => $genre->toArray(),
        ]);

    }

    public function update_all(Request $request, Genre $genre)
    {
        $validation = $this->validate_request($request);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()->toArray(),
            ], 400);
        }

        foreach ($request->keys() as $key) {
            if ($request[$key] == 'null') {
                $request[$key] = null;
            }
            $genre[$key] = $request[$key];
        }
        $genre->save();

        return response()->json([
            'success' => true,
            'message' => 'genre has been successfully updated',
            'data' => $genre->toArray(),
        ], 200);


    }

    public function delete($id)
    {
        $genre = Genre::find($id);

        if (is_null($genre)) {
            return response()->json([
                'success' => false,
                'message' => 'Requested genre was not found in the collection',
            ]);
        }

        $tracks = Tracks::where('genre_id', $genre->id)->get();
        $_genres = Genre::where('parent_id', $genre->id)->get();

        foreach($tracks as $track){
            $track->genre_id = null;
            $track->save();
        }
        foreach($_genres as $_genre){
            $_genre->parent_id = null;
            $_genre->save();
        }

        if ($genre->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'genre was successfully deleted'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error occurred whilst deleting genre',
        ]);

    }

    public function validate_request(Request $request)
    {
        foreach ($request->keys() as $key) {
            if ($request[$key] == 'null') {
                $request[$key] = null;
            }
        }

        $validation = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255',],
            'parent_id' => ['nullable', 'exists:genres,id',],
            'icon' => ['string', 'max:255'],
        ]);

        return $validation;
    }
}
