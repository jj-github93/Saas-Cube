<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    function __construct(){
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
        $request->validate([

            'name' => ['required', 'string', 'max:255',],

            'parent_id' => ['required', 'integer',],

            'icon' => ['string', 'max:255'],

        ]);
        Genre::create([
            'name' => $request->input('name'),
            'parent_id' => ($request->input('parent_id') == 0) ? null : (int)$request->input('parent_id'),
            'icon' => $request->input('icon'),
        ]);

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
        $request->validate([
            'name' => ['required', 'string', 'max:255',],
            'icon' => ['string', 'max:255'],
            'parent_id' => ['required', 'integer',],
        ]);

        if (isset($request['name']) && ($request->input != $genre->name)) {
            $genre->name = $request->input('name');
        }
        if (isset($request['name']) && ($request->input != $genre->name)) {
            $genre->icon = $request->input('icon');
        }

        // Sets the parent_id variable to null if the request value is 0
        $genre->parent_id = ($request->input('parent_id') == 0) ? null : $request->input('parent_id');

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
        $genre->delete();
        return redirect(route('genres.index'));
    }
}
