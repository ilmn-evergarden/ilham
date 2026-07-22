<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects with search, status filter, featured filter & sort.
     */
    public function index(Request $request): View
    {
        $query = $request->user()->projects()->with('technologies');

        if ($search = $request->input('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($request->filled('featured')) {
            $query->where('featured', (bool) $request->input('featured'));
        }

        $query->latest();

        $projects  = $query->paginate(10)->withQueryString();
        $statuses  = Project::statuses();

        return view('projects.index', compact('projects', 'statuses'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create(): View
    {
        $technologies = Technology::orderBy('name')->get();

        return view('projects.create', compact('technologies'));
    }

    /**
     * Store a newly created project and sync technologies.
     */
    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $data            = $request->validated();
        $data['user_id'] = $request->user()->id;
        $data['featured'] = $request->boolean('featured');
        $data['slug']    = Str::slug($data['slug']);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        $technologyIds = $data['technologies'];
        unset($data['technologies']);

        $project = Project::create($data);
        $project->technologies()->sync($technologyIds);

        return redirect()->route('projects.index')
            ->with('status', 'project-created');
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Request $request, Project $project): View
    {
        // abort_if($project->user_id !== $request->user()->id, 403);

        $technologies       = Technology::orderBy('name')->get();
        $selectedTechIds    = $project->technologies->pluck('id')->toArray();

        return view('projects.edit', compact('project', 'technologies', 'selectedTechIds'));
    }

    /**
     * Update the specified project and sync technologies.
     */
    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        // abort_if($project->user_id !== $request->user()->id, 403);

        $data = $request->validated();
        $data['featured'] = $request->boolean('featured');
        $data['slug']     = Str::slug($data['slug']);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        $technologyIds = $data['technologies'];
        unset($data['technologies']);

        $project->update($data);
        $project->technologies()->sync($technologyIds);

        return redirect()->route('projects.index')
            ->with('status', 'project-updated');
    }

    /**
     * Remove the specified project, its thumbnail, all gallery images, and pivot records.
     */
    public function destroy(Request $request, Project $project): RedirectResponse
    {
        // abort_if($project->user_id !== $request->user()->id, 403);

        // Delete thumbnail
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        // Delete all gallery image files from storage
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        // Cascade deletes handle project_images & project_technologies rows via DB constraints,
        // but we already deleted the files above before the DB rows vanish.
        $project->delete();

        return redirect()->route('projects.index')
            ->with('status', 'project-deleted');
    }
}
