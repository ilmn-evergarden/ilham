<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectImageRequest;
use App\Http\Requests\UpdateProjectImageRequest;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProjectImageController extends Controller
{
    /**
     * Resolve the project and authorise ownership.
     * Keeps all methods DRY.
     */
    private function authorisedProject(Request $request, int|string $projectId): Project
    {
        $project = Project::findOrFail($projectId);
        // abort_if($project->user_id !== $request->user()->id, 403);

        return $project;
    }

    /**
     * Show all images for the given project, ordered by sort_order.
     */
    public function index(Request $request, Project $project): View
    {
        // abort_if($project->user_id !== $request->user()->id, 403);

        $images = $project->images()->orderBy('sort_order')->orderBy('id')->paginate(20);

        return view('project-images.index', compact('project', 'images'));
    }

    /**
     * Show the upload form for the given project.
     */
    public function create(Request $request, Project $project): View
    {
        // abort_if($project->user_id !== $request->user()->id, 403);

        return view('project-images.create', compact('project'));
    }

    /**
     * Store one or more uploaded images for the project.
     * Supports batch upload: each file gets its own row.
     */
    public function store(StoreProjectImageRequest $request, Project $project): RedirectResponse
    {
        // abort_if($project->user_id !== $request->user()->id, 403);

        // Determine starting sort_order to append after existing images
        $maxOrder = $project->images()->max('sort_order') ?? -1;

        foreach ($request->file('images') as $index => $file) {
            $maxOrder++;
            $project->images()->create([
                'image'      => $file->store("projects/{$project->id}/images", 'public'),
                'caption'    => $request->input("captions.{$index}"),
                'sort_order' => $request->input("sort_orders.{$index}") ?? $maxOrder,
            ]);
        }

        return redirect()->route('projects.images.index', $project)
            ->with('status', 'images-uploaded');
    }

    /**
     * Show the edit form for a single image.
     */
    public function edit(Request $request, Project $project, ProjectImage $image): View
    {
        // abort_if($project->user_id !== $request->user()->id, 403);
        abort_if($image->project_id !== $project->id, 404);

        return view('project-images.edit', compact('project', 'image'));
    }

    /**
     * Update the specified image (optionally replacing the file).
     */
    public function update(UpdateProjectImageRequest $request, Project $project, ProjectImage $image): RedirectResponse
    {
        // abort_if($project->user_id !== $request->user()->id, 403);
        abort_if($image->project_id !== $project->id, 404);

        $data = $request->validated();

        if ($request->hasFile('image')) {
            // Delete old file then store the new one
            Storage::disk('public')->delete($image->image);
            $data['image'] = $request->file('image')->store("projects/{$project->id}/images", 'public');
        } else {
            unset($data['image']); // keep existing path
        }

        $image->update($data);

        return redirect()->route('projects.images.index', $project)
            ->with('status', 'image-updated');
    }

    /**
     * Delete the specified image and its file from storage.
     */
    public function destroy(Request $request, Project $project, ProjectImage $image): RedirectResponse
    {
        // abort_if($project->user_id !== $request->user()->id, 403);
        abort_if($image->project_id !== $project->id, 404);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return redirect()->route('projects.images.index', $project)
            ->with('status', 'image-deleted');
    }
}
