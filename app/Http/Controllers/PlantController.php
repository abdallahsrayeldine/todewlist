<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlantUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Plant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class PlantController extends Controller
{
    public function store(PlantUpdateRequest $request)
    {
        $plant = new Plant($request->except('plant_pic'));
        $plant->user_id = Auth::id(); // Assuming the user is logged in

        if ($request->hasFile('plant_pic')) {
            $path = $request->file('plant_pic')->store('plant_pics', 'public');
            $plant->plant_path = $path;
        }

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('ProfilePics', 'public');
            if (!is_null($request->user()->picpath)) {
                Storage::disk('public')->delete($request->user()->picpath);
            }
            $request->user()->picpath = $filePath;
        }

        $plant->save();
    }
    public function update(PlantUpdateRequest $request, $id)
    {

        $plant = Plant::findOrFail($id); // Find the plant by its ID

        if ($plant->user_id !== Auth::id()) {
            abort(403); // Ensure the plant belongs to the authenticated user
        }

        $plant->name = $request->input('name');
        $plant->species = $request->input('species');
        $plant->water = $request->input('water');
        $plant->date = $request->input('date');
        $plant->soil = $request->input('soil');
        $plant->drainage = $request->input('drainage');
        $plant->fertilizer = $request->input('fertilizer');
        $plant->sunlight = $request->input('sunlight');
        $plant->humidity = $request->input('humidity');
        $plant->notes = $request->input('notes');

        if ($request->hasFile('plant_pic')) {
            // Delete old plant picture if exists
            if ($plant->plant_path) {
                $path = $plant->plant_path;
                $plant->plant_path = $request->file('plant_pic')->store('plant_pics', 'public');
                Storage::disk('public')->delete($path);
            }
            // Store new plant picture
            else {
                $path = $request->file('plant_pic')->store('plant_pics', 'public');
                $plant->plant_path = $path;
            }
        }
        // Save changes
        $plant->save();

        // return response()->json(['success' => true, 'message' => 'Plant updated successfully']);
    }

    public function index()
    {
        // Get paginated plants for the user
        $plants = Plant::where('user_id', Auth::id())->paginate(6);
        return Inertia::render('Dashboard', [
            'plants' => $plants
        ]);
    }
}
