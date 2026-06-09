<?php

namespace App\Http\Controllers;

use App\Models\Musique;
use Illuminate\Http\Request;

class MusiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $musiques = Musique::with(['artistes', 'styles'])->get();
        return response()->json($musiques);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $musique = Musique::with(['album', 'styles', 'artistes'])->findOrFail($id);
        return response()->json($musique);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Musique $musique)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Musique $musique)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Musique $musique)
    {
        //
    }
}
