<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Models\Tracks;

class PlaylistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $playlists = Playlist::paginate(10);

        return view('admin.playlists.index', compact(['playlists']))
            ->with('i', (\request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.playlists.create');
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
        ]);

        Playlist::create([
            'name' => $request->input('name'),
        ]);

        return redirect(route('playlists.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Playlist $playlist)
    {
        return view('admin.playlists.show', compact(['playlist']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        $all_tracks = Tracks::all();
        return view('admin.playlists.update', compact(['playlist', 'all_tracks']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Playlist $playlist)
    {
        $rules = [];
        $rules[] = ['name' => ['required', 'string', 'max:255'],];

        foreach ($rules as $rule) {
            $request->validate($rule);
        }

        if ($request->input('name') != $playlist->name) {
            $playlist->name = $request->input('name');
        }

        $playlist->tracks()->attach($request->add_tracks);

        $playlist->save();

        $all_tracks = Tracks::all();

        return view('admin.playlists.update', compact(['playlist', 'all_tracks']));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Playlist $playlist)
    {
        $playlist->tracks()->detach();
        $playlist->delete();
        return redirect(route('playlists.index'));

    }

    public function remove(Playlist $playlist, Tracks $track)
    {
        $playlist->tracks()->detach($track);
        $all_tracks = Tracks::all();
        return view('admin.playlists.update', compact(['playlist', 'all_tracks']));
    }
}
