<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Tracks;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tracks = Tracks::paginate(10);
        return view('admin.tracks.index', compact(['tracks']))
            ->with('i', (\request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('admin.tracks.create', compact(['genres']));
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
            'artist' => 'required',
            'genre' => 'required',
        ]);

        Tracks::create([
            'name' => $request->input('name'),
            'artist' => $request->input('artist'),
            'album' => $request->input('album'),
            'genre' => $request->input('genre') == "No Genre" ? null : $request->input('genre'),
            'track_number' => $request->input('track_number'),
            'length' => $request->input('length'),
            'year' => $request->input('year'),
        ]);

        return redirect(route("tracks.index"));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tracks $track)
    {
        return view('admin/tracks/show', compact(['track']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tracks $track)
    {
        $all_genres = Genre::all();
        return view("admin.tracks.update", compact(['track', 'all_genres']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tracks $track)
    {
//        $rules = [];
//        if ($request->input('track_number') != $track->track_number) {
//            $rules[] = ['track_number' => ['required', 'int',]];
//        }
//        if ($request->input('name') != $track->name) {
//            $rules[] = ['name' => ['required', 'string', 'max:255',]];
//        }
//        if ($request->input('artist') != $track->artist) {
//            $rules[] = ['artist' => ['required', 'string', 'max:255',]];
//        }
//        if ($request->input('album') != $track->album) {
//            $rules[] = ['album' => ['required', 'string', 'max:255',]];
//        }
//        if ($request->input('genre') != $track->genre) {
//            $rules[] = ['genre' => ['required', 'string',]];
//        }
//        if ($request->input('year') != $track->year) {
//            $rules[] = ['year' => ['required', 'year',]];
//        }
//        if ($request->input('name') != $track->length) {
//            $rules[] = ['length' => ['required', 'string',]];
//        }
//
//        $request->validate($rules);
//
//        ddd($rules);
//
//        if ($request->input('track_number') != $track->track_number) {
//            $track->track_number = $request->input('track_number');
//        }
//        if ($request->input('name') != $track->name) {
//            $track->name = $request->input('name');
//        }
//        if ($request->input('artist') != $track->arist) {
//            $track->artist = $request->input('artist');
//        }
//        if ($request->input('album') != $track->album) {
//            $track->album = $request->input('album');
//        }
//        if ($request->input('genre') != $track->genre) {
//            $track->genre = $request->input('genre');
//        }
//        if ($request->input('year') != $track->year) {
//            $track->year = $request->input('year');
//        }
//        if ($request->input('name') != $track->length) {
//            $track->length = $request->input('length');
//        }
//
//        $track->save();

        $patches = [
            'name' => !is_null(($request->input('name'))) ? $request->input('name') : $track->name,
            'track_id' => !is_null(($request->input('track_id'))) ? (int)$request->input('track_id') : $track->track_id,
            'artist' => !is_null(($request->input('artist'))) ? $request->input('artist') : $track->artist,
            'album' => !is_null(($request->input('album'))) ? $request->input('album') : $track->album,
            'genre' => ($request->input('genre') == null) ? null : $request->input('genre'),
            'length' => !is_null(($request->input('length'))) ? $request->input('length') : $track->length,
            'year' => !is_null(($request->input('year'))) ? $request->input('year') : $track->year,
        ];

        $track->update($patches);

        return redirect(route("tracks.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tracks $track){
        $track->delete();
        return redirect(route('tracks.index'));
    }
}
