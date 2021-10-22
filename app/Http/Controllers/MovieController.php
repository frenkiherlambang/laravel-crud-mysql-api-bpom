<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::all();
        return response()->json($movies, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => ['required','min:3', 'max:255'],
            'foto' => ['required','min:15', 'max:255']
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 412);
        }

        $movie = Movie::create([
            'judul' => Str::title($request->judul),
            'deskripsi' => $request->deskripsi,
            'foto' => $request->foto,
        ]);
        return response()->json($movie, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        return response()->json($movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $validator = Validator::make($request->all(), [
            'judul' => ['required','min:3', 'max:255'],
            'foto' => ['required','min:15', 'max:255']
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 412);
        }

        $movie->update([
            'judul' => Str::title($request->judul),
            'deskripsi' => $request->deskripsi,
            'foto' => $request->foto,
        ]);
        return response()->json($movie, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json(['message' => 'Movie with id:'.$movie->id.' successfully deleted'], 200);
    }
}
