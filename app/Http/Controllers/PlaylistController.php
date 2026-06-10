<?php

namespace App\Http\Controllers;

use App\Models\Playlist;
use Illuminate\Http\Request;
use App\Http\Requests\StorePlaylistRequest;
use App\Http\Requests\AddMusiquePlaylistRequest;

class PlaylistController extends Controller
{
    public function addMusique(AddMusiquePlaylistRequest $request, Playlist $playlist)
    {
        // On vérifie si la playlist appartient à l'utilisateur
        if($playlist->user_id !== $request->user()->id)
        {
            return response()->json(['message' => 'Accès refusé]'], 403);
        }

        $playlist->musiques()->syncWithoutDetaching([$request->musique_id]);
        return response()->json(['message' => 'Musique ajoutée avec succès']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($request->user()->playlists()->with('musiques')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlaylistRequest $request)
    {
        $playlist = $request->user()->playlists()->create($request->validated());
        return response()->json($playlist, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Playlist $playlist)
    {
        // On vérifie si c'est le propriétaire de la playlist
        if($playlist->user_id !== $request->user()->id)
        {
            return response()->json(['message' => 'Accès refusé'], 403);
        }

        return response()->json($playlist->load('musiques'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Playlist $playlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Playlist $playlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Playlist $playlist)
    {
        //
    }
}
