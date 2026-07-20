<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SkillController extends Controller
{
    /**
     * Display a listing of skills with search & category filter.
     */
    public function index(Request $request): View
    {
        $query = $request->user()->skills()->latest();

        // Search by name
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        // Filter by category
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }

        $skills = $query->paginate(10)->withQueryString();

        // Distinct categories for filter dropdown (scoped to this user)
        $categories = $request->user()->skills()
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('skills.index', compact('skills', 'categories'));
    }

    /**
     * Show the form for creating a new skill.
     */
    public function create(): View
    {
        return view('skills.create');
    }

    /**
     * Store a newly created skill.
     */
    public function store(StoreSkillRequest $request): RedirectResponse
    {
        $data            = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('skills/icons', 'public');
        }

        Skill::create($data);

        return redirect()->route('skills.index')
            ->with('status', 'skill-created');
    }

    /**
     * Show the form for editing the specified skill.
     * Authorization: only the owner can edit.
     */
    public function edit(Request $request, Skill $skill): View
    {
        abort_if($skill->user_id !== $request->user()->id, 403);

        return view('skills.edit', compact('skill'));
    }

    /**
     * Update the specified skill.
     */
    public function update(UpdateSkillRequest $request, Skill $skill): RedirectResponse
    {
        abort_if($skill->user_id !== $request->user()->id, 403);

        $data = $request->validated();

        if ($request->hasFile('icon')) {
            // Delete old icon if it exists
            if ($skill->icon) {
                Storage::disk('public')->delete($skill->icon);
            }
            $data['icon'] = $request->file('icon')->store('skills/icons', 'public');
        }

        $skill->update($data);

        return redirect()->route('skills.index')
            ->with('status', 'skill-updated');
    }

    /**
     * Remove the specified skill and its icon.
     */
    public function destroy(Request $request, Skill $skill): RedirectResponse
    {
        abort_if($skill->user_id !== $request->user()->id, 403);

        if ($skill->icon) {
            Storage::disk('public')->delete($skill->icon);
        }

        $skill->delete();

        return redirect()->route('skills.index')
            ->with('status', 'skill-deleted');
    }
}
