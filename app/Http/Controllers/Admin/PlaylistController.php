<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Playlist;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Tracks;
use Illuminate\Support\Facades\Auth;

class PlaylistController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:playlist-list|playlist-create|playlist-edit|playlist-delete|',
            ['only' => ['index', 'store']]
        );
        $this->middleware('permission:playlist-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:playlist-edit|edit-public-playlist|edit-own-playlist', ['only' => 'edit', 'update']);
        $this->middleware('permission:playlist-delete|delete-public-playlist|delete-own-playlist', ['only' => 'destroy', 'delete']);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->can('view-public-playlist')) {
            $playlists = Playlist::where('protected', 0)
                ->paginate(10);
        }
        if ($user->can('view-own-playlist')) {
            $playlists = Playlist::where('protected', 0)
                ->orWhere('user_id', $user->id)
                ->paginate(10);
        }
        if ($user->can('playlist-list')) {
            $playlists = Playlist::paginate(10);
        }

        return view('admin.playlists.index', compact(['playlists', 'user']))
            ->with('i', (\request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->roles->pluck('name') == 'Admin') {
            $users = User::all();

        } else {
            $users = User::find(auth()->user()->id);
        }

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
        $validated_data = $this->validate_data($request);

        Playlist::create($validated_data);

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
        $user = auth()->user();
        return view('admin.playlists.show', compact(['playlist', 'user']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Playlist $playlist)
    {
        $user = auth()->user();

        if ($user->can('playlist-edit')) {
            $users = User::all();
        } else if ($user->can('edit-public-playlist')) {
            $users = User::whereNotIn('name', ['Admin'])->get();
        } else {
            $users[] = $user;
        }
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
        $validated_data = $this->validate_data($request);
        $playlist->update($validated_data);

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

    public function validate_data(Request $request)
    {
        if($request['protected'] == 1){
            $request['protected'] = true;
        }
        else{
            $request['protected'] = false;
        }

        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'protected' => 'required|bool',
            'user_id' => ['nullable', 'numeric']
        ]);
    }
}
