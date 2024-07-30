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

        // return response()->json(['success' => true, 'message' => 'Plant updated successfully']);
    }

    public function index(Request $request)
    {
        // Debugging request parameters
        // dd($request->OrderType, $request->FieldType);

        // Initialize the query
        $query = Plant::where('user_id', Auth::id());

        // Apply search filter if present
        if ($request->has('key')) {
            $query->where('name', 'like', '%' . $request->input('key') . '%');
        }

        // Apply sorting if OrderType and FieldType are present
        if ($request->has('OrderType') && $request->has('FieldType')) {
            $order = filter_var($request->OrderType, FILTER_VALIDATE_BOOLEAN) ? 'asc' : 'desc';
            switch ($request->FieldType) {
                case 'Child Name':
                    $field = 'name';
                    break;
                case 'Species/ Varieties':
                    $field = 'Species';
                    break;
                case 'Watering':
                    $field = 'water';
                    break;
                case 'Date Planted':
                    $field = 'date';
                    break;
                case 'Soil Type':
                    $field = 'soil';
                    break;
                case 'Drainage':
                    $field = 'drainage';
                    break;
                case 'Fertilizer':
                    $field = 'fertilizer';
                    break;
                case 'Sunlight':
                    $field = 'sunlight';
                    break;
                case 'Humidity':
                    $field = 'humidity';
                    break;
                case 'Notes':
                    $field = 'notes';
                    break;
                default:
                    $field = null;
                    break;
            }
            if ($field) {
                $query->orderBy($field, $order);
            }
        }

        $plants = $query->paginate(6);
        return Inertia::render('Dashboard', [
            'plants' => $plants
        ]);
    }
}
