<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return Inertia::render('Dashboard', [
            'auth' => [
                'user' => $user,
            ],
        ]);
    }
}
