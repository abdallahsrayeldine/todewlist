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
            $plant->plant_path = $request->file('plant_pic')->store('plant_pics', 'public');
        }

        $plant->save();
    }
    public function update(PlantUpdateRequest $request, $id)
    {
        // dd($request->all());

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
                if ($path !== "pic.png") {
                    $plant->plant_path = $request->file('plant_pic')->store('plant_pics', 'public');
                    Storage::disk('public')->delete($path);
                } else {
                    $plant->plant_path = $request->file('plant_pic')->store('plant_pics', 'public');
                }
            }
            // Store new plant picture
            else {
                $path = $request->file('plant_pic')->store('plant_pics', 'public');
                $plant->plant_path = $path;
            }
        }
        // Save changes
        $plant->save();
    }

    public function index(Request $request)
    {
        // Initialize the query
        $query = Plant::where('user_id', Auth::id());

        // Apply search filter if present
        if ($request->has('key')) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', "%{$request->input('key')}%")
                    ->orWhere('species', 'like', "%{$request->input('key')}%")
                    ->orWhere('water', 'like', "%{$request->input('key')}%")
                    ->orWhere('date', 'like', "%{$request->input('key')}%")
                    ->orWhere('soil', 'like', "%{$request->input('key')}%")
                    ->orWhere('drainage', 'like', "%{$request->input('key')}%")
                    ->orWhere('fertilizer', 'like', "%{$request->input('key')}%")
                    ->orWhere('sunlight', 'like', "%{$request->input('key')}%")
                    ->orWhere('humidity', 'like', "%{$request->input('key')}%")
                    ->orWhere('notes', 'like', "%{$request->input('key')}%");
            });
        }

        // Apply sorting if OrderType and FieldType are present
        if ($request->has('OrderType') && $request->has('FieldType')) {
            $order = $request->OrderType;
            $fieldMap = [
                'Child Name' => 'name',
                'Species/ Varieties' => 'species',
                'Watering' => 'water',
                'Date Planted' => 'date',
                'Soil Type' => 'soil',
                'Drainage' => 'drainage',
                'Fertilizer' => 'fertilizer',
                'Sunlight' => 'sunlight',
                'Humidity' => 'humidity',
                'Notes' => 'notes'
            ];

            $field = $fieldMap[$request->FieldType] ?? null;

            if ($field) {
                $query->orderBy($field, $order);
            }
        }

        $plants = $query->paginate(6)->withQueryString();
        return Inertia::render('Dashboard', [
            'plants' => $plants
        ]);
    }

    public function show($plantId)
    {
        $plant = Plant::findOrFail($plantId);
        return $plant;
    }
}
