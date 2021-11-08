<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Tracks;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    function __construct(){
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
        $request->validate([
            'name' => ['required', 'string', 'max:255',],
            'artist' => ['required', 'string', 'max:64',],
            'album' => ['string', 'max:64'],
            'genre_id' => ['required', 'integer'],
            'track_number' => (isset($request->track_number) ? ['integer'] : [null]),
            'length' => ['string', 'max:255'],
            'year' => (isset($request->password) && !is_null($request->password) ?
                ['string', 'max:4', 'numeric'] : [null])
        ]);

        Tracks::create([
            'name' => $request->input('name'),
            'artist' => $request->input('artist'),
            'album' => $request->input('album'),
            'genre_id' => $request->input('genre_id') == 0 ? null : $request->input('genre_id'),
            'track_number' => $request->input('track_number') ?? 1,
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
        $request->validate([
            'name' => ['required', 'string', 'max:255',],
            'artist' => ['required', 'string', 'max:64',],
            'album' => ['string', 'max:64'],
            'genre_id' => ['required', 'integer'],
            'track_number' => (isset($request->track_number) ? ['integer'] : [null]),
            'length' => ['string', 'max:255'],
            'year' => (isset($request->year) && !is_null($request->year) ?
                ['string', 'max:4', 'numeric'] : [null])
        ]);

        if (isset($request['track_number']) && ($request->input != $track->track_number)) {
            $track->track_number = $request->input('track_number');
        }
        if (isset($request['name']) && ($request->input != $track->name)) {
            $track->name = $request->input('name');
        }
        if (isset($request['artist']) && ($request->input != $track->artist)) {
            $track->artist = $request->input('artist');
        }
        if (isset($request['album']) && ($request->input != $track->album)) {
            $track->album = $request->input('album');
        }
        if (isset($request['genre_id']) && ($request->input != $track->genre_id)) {
            $track->genre_id = $request->input('genre_id') != 0 ? $request->input('genre_id') : null;
        }
        if (isset($request['year']) && ($request->input != $track->year)) {
            $track->year = $request->input('year');
        }
        if (isset($request['length']) && ($request->input != $track->length)) {
            $track->length = $request->input('length');
        }

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
        $track->delete();
        return redirect(route('tracks.index'));
    }
}
