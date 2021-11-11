<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Playlist;
use App\Models\Tracks;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:track-list|track-create|track-edit|track-delete|',
            ['only' => ['index', 'store']]
        );
        $this->middleware('permission:track-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:track-edit', ['only' => 'edit', 'update']);
        $this->middleware('permission:track-delete', ['only' => 'destroy', 'delete']);
    }

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
        $data = $this->validate_data($request);
        Tracks::create($data);

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
        $data = $this->validate_data($request);
        $track->update($data);
        $track->save();

        return redirect(route("tracks.index"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tracks $track)
    {
        $playlists = Playlist::whereHas('tracks', function ($query) {
            $query->where('playlist_track.track_id', 50);
        })->get();

        if (!is_null($playlists)) {
            foreach ($playlists as $playlist) {
                $playlist->tracks()->detach($track);
            }
        }

        $track->delete();
        return redirect(route('tracks.index'));
    }

    public function validate_data(Request $request)
    {
        if(is_null($request['album'])){
            $request['album'] = 'No album';
        }

        return $request->validate([
            'name' => ['required', 'string', 'max:255',],
            'artist' => ['required', 'string', 'max:64',],
            'album' => ['string', 'max:64'],
            'genre_id' => 'nullable|exists:genres,id',
            'track_number' => 'nullable|integer',
            'length' => 'nullable|string|max:10',
            'year' => ['nullable', 'numeric', 'max:2021'],
        ]);
    }
}
