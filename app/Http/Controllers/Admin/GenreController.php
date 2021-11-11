<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Tracks;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:genre-list|genre-create|genre-edit|genre-delete|',
            ['only' => ['index', 'store']]
        );
        $this->middleware('permission:genre-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:genre-edit', ['only' => 'edit', 'update']);
        $this->middleware('permission:genre-delete', ['only' => 'destroy', 'delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = Genre::paginate(10);
        return view('admin.genres.index', compact(['genres']))
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
        return view('admin.genres.create', compact(['genres']));
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

        Genre::create($validated_data);

        return redirect(route('genres.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        return view('admin.genres.show', compact(['genre']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Genre $genre)
    {
        // Gets all genres for select drop down
        $all_genres = Genre::all();
        return view('admin.genres.update', compact(['genre', 'all_genres']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        $validated_data = $this->validate_data($request);
        $genre->update($validated_data);
        $genre->save();
        return redirect(route('genres.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        $tracks = Tracks::where('genre_id', $genre->id)->get();
        $genres = Genre::where('parent_id', $genre->id)->get();

        foreach($tracks as $track){
            $track->genre_id = null;
            $track->save();
        }
        foreach($genres as $_genre){
            $_genre->parent_id = null;
            $_genre->save();
        }

        $genre->delete();
        return redirect(route('genres.index'));
    }

    public function validate_data($request)
    {
        $validated_data = $request->validate([
            'name' => ['required', 'string', 'max:255',],
            'parent_id' => 'nullable|exists:genres,id',
            'icon' => 'nullable|string|max:64',
        ]);
        if (is_null($validated_data['icon'])) {
            $validated_data['icon'] = '000-default.png';
        }
        return $validated_data;
    }
}
