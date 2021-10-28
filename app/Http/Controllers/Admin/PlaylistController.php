<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Tracks;

class PlaylistController extends Controller
{
    function __construct(){
        $this->middleware('permission:playlist-list|playlist-create|playlist-edit|playlist-delete|',
            ['only' => ['index', 'store']]
        );
        $this->middleware('permission:playlist-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:playlist-edit', ['only' => 'edit', 'update']);
        $this->middleware('permission:playlist-delete', ['only' => 'destroy', 'delete']);
    }
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
        $users = User::all();

        return view('admin.playlists.create', compact(['users']));
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
            'name' => ['required', 'string', 'max:64',],
            'protected' => ['required', 'bool'],
            'user_id' => ['nullable', 'integer']
        ]);

        Playlist::create([
            'name' => $request->input('name'),
            'protected' => $request->input('protected'),
            'user_id' => $request->input('user_id'),
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
        $users = User::all();
        $all_tracks = Tracks::all();
        return view('admin.playlists.update', compact(['playlist', 'all_tracks', 'users']));
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
        //ddd($request);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'protected' => ['required', 'bool'],
            'user_id' => ['nullable', 'numeric']
        ]);

        if (isset($request['name']) && $request->input('name') != $playlist->name) {
            $playlist->name = $request->input('name');
        }
        if($request->input('user_id') != $playlist->user_id){
            $playlist->user_id = $request->input('user_id');
        }
        if($request->input('protected') != $playlist->protected){
            $playlist->protected = $request->input('protected');
        }

        $playlist->tracks()->attach($request->add_tracks);

        $playlist->save();

        $all_tracks = Tracks::all();
        $users = User::all();

        return view('admin.playlists.update', compact(['playlist', 'all_tracks', 'users']));

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
