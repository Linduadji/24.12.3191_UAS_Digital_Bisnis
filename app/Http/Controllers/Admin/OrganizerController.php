<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $organizers = Organization::withCount(['events as total_events', 'events as active_events' => function ($query) {
            $query->where('date', '>=', now());
        }])
        ->when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        })
        ->latest()
        ->paginate(12)
        ->appends(['search' => $search]);

        return view('admin.organizers.index', compact('organizers', 'search'));
    }
}
