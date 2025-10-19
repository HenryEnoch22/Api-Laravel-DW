<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePetRequest;
use App\Http\Requests\UpdatePetRequest;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::all();
        return response()->json($pets);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePetRequest $request)
    {
        $petValidated = $request->validated();

        if($request->hasFile('photo_path')){
            $file = $request->file('photo_path');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            // Guarda en storage/app/public/pets/photos
            $photoPath = $file->storeAs('', $fileName, 'photo_pets'); // guardo en storage/petPhotos
        }

        Pet::create([
            'owner_id' => $petValidated['owner_id'],
            'name' => $petValidated['name'],
            'species' => $petValidated['species'],
            'breed' => $petValidated['breed'] ?? null,
            'sex' => $petValidated['sex'] ?? 'unknown',
            'size' => $petValidated['size'] ?? null,
            'color' => $petValidated['color'] ?? null,
            'birth_date' => $petValidated['birth_date'] ?? null,
            'weight_kg' => $petValidated['weight_kg'] ?? null,
            'sterilized' => $petValidated['sterilized'] ?? false,
            'photo_path' => $photoPath,
            'status' => 'active',
            'admission_date' => now(),
            'last_visit_at' => null,
        ]);

        return response()->json(['message' => 'Pet registered successfully.'], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show( $petId)
    {
        $pet = Pet::find($petId);
        if (!$pet) {
            return response()->json(['message' => 'Pet not found.'], 404);
        }
        return response()->json($pet, 200);

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePetRequest $request, $petId)
    {
        $pet = Pet::find($petId);
        if (!$pet) {
            return response()->json(['message' => 'Pet not found.'], 404);
        }

        $petValidated = $request->validated();
        Log::info('Updating pet with data: ', $petValidated);

        if($request->hasFile('photo_path')){
            if($pet->photo_path){
                // Elimino la foto anterior si existe
                Storage::disk('photo_pets')->delete($pet->photo_path);
            }
            $file = $request->file('photo_path');
            $fileName = uniqid() . '_' . $file->getClientOriginalName();
            // Guarda en storage/app/public/pets/photos
            $photoPath = $file->storeAs('', $fileName, 'photo_pets'); // guardo en storage/petPhotos
            $petValidated['photo_path'] = $photoPath;
        }

        $pet->update($petValidated);


        return response()->json([
            'message' => 'Pet updated successfully.',
            'data'    => $pet->fresh()],
            201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $petId)
    {
        $pet = Pet::find($petId);
        if (!$pet) {
            return response()->json(['message' => 'Pet not found.'], 404);
        }

        $pet->delete();

        return response()->json(['message' => 'Pet deleted successfully.'], 200);
    }
}
