<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EducationController extends Controller
{
    /**
     * Display a listing of education records.
     * Supports search by school_name and sorting by start_year.
     */
    public function index(Request $request): View
    {
        $query = $request->user()->educations();

        // Search by school or university name
        if ($search = $request->input('search')) {
            $query->where('school_name', 'like', "%{$search}%");
        }

        // Sort direction: default newest first (desc)
        $sort  = $request->input('sort', 'desc');
        $order = $sort === 'asc' ? 'asc' : 'desc';
        $query->orderBy('start_year', $order);

        $educations = $query->paginate(10)->withQueryString();

        return view('educations.index', compact('educations', 'sort'));
    }

    /**
     * Show the form for creating a new education record.
     */
    public function create(): View
    {
        return view('educations.create');
    }

    /**
     * Store a newly created education record.
     */
    public function store(StoreEducationRequest $request): RedirectResponse
    {
        $data            = $request->validated();
        $data['user_id'] = $request->user()->id;

        Education::create($data);

        return redirect()->route('educations.index')
            ->with('status', 'education-created');
    }

    /**
     * Show the form for editing the specified education record.
     */
    public function edit(Request $request, Education $education): View
    {
        // abort_if($education->user_id !== $request->user()->id, 403);

        return view('educations.edit', compact('education'));
    }

    /**
     * Update the specified education record.
     */
    public function update(UpdateEducationRequest $request, Education $education): RedirectResponse
    {
        // abort_if($education->user_id !== $request->user()->id, 403);

        $education->update($request->validated());

        return redirect()->route('educations.index')
            ->with('status', 'education-updated');
    }

    /**
     * Remove the specified education record.
     */
    public function destroy(Request $request, Education $education): RedirectResponse
    {
        // abort_if($education->user_id !== $request->user()->id, 403);

        $education->delete();

        return redirect()->route('educations.index')
            ->with('status', 'education-deleted');
    }
}
