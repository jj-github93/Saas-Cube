<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
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
            'name' => 'required',
            'parent_id' => 'required',
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
        $patches = [
            'name' => !is_null($request->input('name')) ? $request->input('name') : $genre->name,
            'icon' => !is_null($request->input('icon')) ? $request->input('icon') : $genre->icon,
            'parent_id' => ($request->input('parent_id') == 0) ? null : $request->input('parent_id'),
        ];
        $genre->update($patches);
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
        //redirect(route('genres.delete'), compact(['genre']));

    }

}
