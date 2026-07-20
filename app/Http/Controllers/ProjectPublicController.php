<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectPublicController extends Controller
{
    public function index(Request $request): View
    {
        $query = Project::with(['technologies', 'images'])->orderByDesc('start_date');

        // Search by title or description
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by technology (by id or name)
        if ($tech = $request->input('technology')) {
            $query->whereHas('technologies', function ($q) use ($tech) {
                $q->where('technologies.id', $tech)
                  ->orWhere('technologies.name', 'like', "%{$tech}%");
            });
        }

        $projects = $query->paginate(9)->withQueryString();
        $technologies = Technology::orderBy('name')->get();

        return view('projects.public.index', compact('projects', 'technologies'));
    }

    public function show(string $slug): View
    {
        $project = Project::where('slug', $slug)
            ->with(['technologies', 'images'])
            ->firstOrFail();

        $related = Project::where('id', '!=', $project->id)
            ->whereHas('technologies', function ($q) use ($project) {
                $q->whereIn('technologies.id', $project->technologies->pluck('id'));
            })
            ->limit(3)
            ->get();

        return view('projects.public.show', compact('project', 'related'));
    }
}
