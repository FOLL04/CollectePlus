<?php
namespace App\Http\Controllers;

use App\Models\Hangar;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Models\Marche;

class HangarController extends Controller
{
    // Dans la méthode index() de HangarController
public function index()
{
    $query = Hangar::with(['zone.marche']);
    
    if (request('marche_id')) {
        $query->whereHas('zone.marche', function($q) {
            $q->where('id', request('marche_id'));
        });
    }
    
    $hangars = $query->get();
    $marches = Marche::all(); // Assure-toi d'avoir le modèle Marche
    
    return view('hangars.index', compact('hangars', 'marches'));
}

    public function create()
    {
        $zones = Zone::with('marche')->get();
        return view('hangars.create', compact('zones'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:hangars,code',
            'zone_id' => 'required|exists:zones,id',
            'type' => 'required|string|in:standard,boutique',
        ]);

        Hangar::create($validated);

        return redirect()->route('hangars.index')->with('success', 'Hangar créé avec succès.');
    }

    public function show($id)
    {
        $hangar = Hangar::with('zone.marche')->findOrFail($id);
        return view('hangars.show', compact('hangar'));
    }

    public function edit($id)
    {
        $hangar = Hangar::findOrFail($id);
        $zones = Zone::with('marche')->get();
        return view('hangars.edit', compact('hangar', 'zones'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10',
            'zone_id' => 'required|exists:zones,id',
            'type' => 'required|string|in:standard,boutique',
        ]);

        $hangar = Hangar::findOrFail($id);
        $hangar->update($validated);

        return redirect()->route('hangars.index')->with('success', 'Hangar mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $hangar = Hangar::findOrFail($id);
        $hangar->delete();

        return redirect()->route('hangars.index')->with('success', 'Hangar supprimé avec succès.');
    }
}
