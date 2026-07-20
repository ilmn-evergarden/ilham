<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use App\Models\Technology;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class TechnologyController extends Controller
{
    /**
     * Display a listing of technologies with search & sort.
     * Technology is global master data (not scoped per user).
     */
    public function index(Request $request): View
    {
        $query = Technology::query();

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Sort A–Z by default; allow desc toggle
        $sort  = $request->input('sort', 'asc');
        $order = $sort === 'desc' ? 'desc' : 'asc';
        $query->orderBy('name', $order);

        $technologies = $query->withCount('projects')->paginate(15)->withQueryString();

        return view('technologies.index', compact('technologies', 'sort'));
    }

    /**
     * Show the form for creating a new technology.
     */
    public function create(): View
    {
        return view('technologies.create');
    }

    /**
     * Store a newly created technology.
     */
    public function store(StoreTechnologyRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('technologies/icons', 'public');
        }

        Technology::create($data);

        return redirect()->route('technologies.index')
            ->with('status', 'technology-created');
    }

    /**
     * Show the form for editing the specified technology.
     */
    public function edit(Technology $technology): View
    {
        return view('technologies.edit', compact('technology'));
    }

    /**
     * Update the specified technology.
     */
    public function update(UpdateTechnologyRequest $request, Technology $technology): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('icon')) {
            // Delete old icon before storing the new one
            if ($technology->icon) {
                Storage::disk('public')->delete($technology->icon);
            }
            $data['icon'] = $request->file('icon')->store('technologies/icons', 'public');
        }

        $technology->update($data);

        return redirect()->route('technologies.index')
            ->with('status', 'technology-updated');
    }

    /**
     * Remove the specified technology.
     * Guard: prevent deletion if the technology is still linked to any project.
     */
    public function destroy(Technology $technology): RedirectResponse
    {
        // Guard: prevent deletion if still linked to at least one project
        if ($technology->projects()->exists()) {
            return redirect()->route('technologies.index')
                ->with('error', "Technology \"{$technology->name}\" tidak dapat dihapus karena masih digunakan oleh " . $technology->projects()->count() . ' project.');
        }

        if ($technology->icon) {
            Storage::disk('public')->delete($technology->icon);
        }

        $technology->delete();

        return redirect()->route('technologies.index')
            ->with('status', 'technology-deleted');
    }
}
