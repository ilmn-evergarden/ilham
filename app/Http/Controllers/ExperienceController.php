<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    /**
     * Display a listing of experience records with search & sort.
     */
    public function index(Request $request): View
    {
        $query = $request->user()->experiences();

        // Search by company or position
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('company', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        // Sort by start_date — default: newest first
        $sort  = $request->input('sort', 'desc');
        $order = $sort === 'asc' ? 'asc' : 'desc';
        $query->orderBy('start_date', $order);

        $experiences = $query->paginate(10)->withQueryString();

        return view('experiences.index', compact('experiences', 'sort'));
    }

    /**
     * Show the form for creating a new experience record.
     */
    public function create(): View
    {
        return view('experiences.create');
    }

    /**
     * Store a newly created experience record.
     */
    public function store(StoreExperienceRequest $request): RedirectResponse
    {
        $data            = $request->validated();
        $data['user_id'] = $request->user()->id;

        // Normalise: if currently working, wipe end_date
        $data['is_current'] = $request->boolean('is_current');
        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        Experience::create($data);

        return redirect()->route('experiences.index')
            ->with('status', 'experience-created');
    }

    /**
     * Show the form for editing the specified experience record.
     */
    public function edit(Request $request, Experience $experience): View
    {
        // abort_if($experience->user_id !== $request->user()->id, 403);

        return view('experiences.edit', compact('experience'));
    }

    /**
     * Update the specified experience record.
     */
    public function update(UpdateExperienceRequest $request, Experience $experience): RedirectResponse
    {
        // abort_if($experience->user_id !== $request->user()->id, 403);

        $data = $request->validated();

        $data['is_current'] = $request->boolean('is_current');
        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        $experience->update($data);

        return redirect()->route('experiences.index')
            ->with('status', 'experience-updated');
    }

    /**
     * Remove the specified experience record.
     */
    public function destroy(Request $request, Experience $experience): RedirectResponse
    {
        // abort_if($experience->user_id !== $request->user()->id, 403);

        $experience->delete();

        return redirect()->route('experiences.index')
            ->with('status', 'experience-deleted');
    }
}
