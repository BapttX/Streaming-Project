<?php

namespace App\Http\Controllers;

use App\Models\Facture;
use Illuminate\Http\Request;

class FactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return response()->json($request->user()->factures);
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
    public function store(StoreFactureRequest $request)
    {
        $musique = Musique::findOrFail($request->musique_id);
        $user = $request->user();

        // Si déjà acheté
        if($user->factures()->whereHas('musiques', function($query) use ($musique) {
            $query->where('musiques.id', $musique->id);
        })->exists()){
            return response()->json(['message' => 'Tu possèdes déjà ce titre.'], 400);
        }

        $facture = $user->factures()->create([
            'montant_total' => $musique->prix
        ]);
        $facture->musiques()->attach($musique->id, [
            'prix_unitaire' => $musique->prix
        ]);
        return response()->json(['message' => 'Achat réussi', 'facture' => $facture], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $facture = $request->user()->factures()->findOrFail($id);
        return response()->json($facture);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facture $facture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facture $facture)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facture $facture)
    {
        //
    }
}
