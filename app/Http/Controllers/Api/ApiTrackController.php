<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\Tracks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiTrackController extends Controller
{
    public function read($id)
    {
        $track = Tracks::find($id);
        if (!$track) {
            return response()->json([
                'success' => false,
                'message' => 'Track was not found',
            ], 400);
        }
        return response()->json([
            'success' => true,
            'data' => $track->toArray(),
        ], 200);
    }

    public function browse()
    {
        $tracks = Tracks::paginate(10);

        if (is_null($tracks)) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to find tracks',
            ], 400);
        }
        return response()->json([
            'success' => true,
            'tracks' => $tracks,

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


        $track = Tracks::create([
            'name' => $request->input('name'),
            'artist' => $request->input('artist'),
            'album' => $request->input('album'),
            'genre_id' => $request->input('genre_id'),
            'track_number' => $request->input('track_number') ?? 1,
            'length' => $request->input('length'),
            'year' => $request->input('year'),
        ]);


        if ($track) {
            return response()->json([
                'success' => true,
                'message' => 'track has been saved',
                'data' => $track->toArray(),
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Error occurred creating track"
        ], 400);

    }

    public function edit(Request $request, Tracks $track)
    {

        $validation = Validator::make($request->all(), [
            'name' => ['string', 'max:255',],
            'artist' => ['string', 'max:64',],
            'album' => ['string', 'max:64'],
            'genre_id' => 'nullable|exists:genres,id',
            'track_number' => 'nullable|integer',
            'length' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'numeric', 'max:2021'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validation->errors()->toArray(),
            ], 400);
        }

        foreach ($request->keys() as $key) {
            if (isset($request[$key])) {
                if ($request[$key] == 'null') {
                    $request[$key] = null;
                }
                $track[$key] = $request[$key];
            }
        }

        $track->save();

        return response()->json([
            'success' => true,
            'message' => 'track was successfully updated',
            'data' => $track->toArray(),
        ]);

    }

    public function update_all(Request $request, Tracks $track)
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
            $track[$key] = $request[$key];
        }
        $track->save();

        return response()->json([
            'success' => true,
            'message' => 'track has been successfully updated',
            'data' => $track->toArray(),
        ], 200);


    }

    public function delete($id)
    {
        $track = Tracks::find($id);

        if (is_null($track)) {
            return response()->json([
                'success' => false,
                'message' => 'Requested track was not found in the collection',
            ]);
        }

        $playlists = Playlist::whereHas('tracks', function ($query) {
            $query->where('playlist_track.track_id', 50);
        })->get();

        if (!is_null($playlists)) {
            foreach ($playlists as $playlist) {
                $playlist->tracks()->detach($id);
            }
        }

        if ($track->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'track was successfully deleted'
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Error occurred whilst deleting track',
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
            'artist' => ['required', 'string', 'max:64',],
            'album' => ['required', 'string', 'max:64'],
            'genre_id' => 'nullable|exists:genres,id',
            'track_number' => 'nullable|integer',
            'length' => ['nullable', 'string', 'max:255'],
            'year' => ['nullable', 'numeric', 'max:2021'],
        ]);

        return $validation;

    }
}
