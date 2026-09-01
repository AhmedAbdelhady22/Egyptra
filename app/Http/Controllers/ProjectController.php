<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::query()
            ->published()
            ->latest('completed_at')
            ->get();

        return view('pages.projects.index', [
            'projects' => $projects,
            'seoTitle' => __('Projects'),
            'seoDescription' => __('Browse our completed projects.'),
        ]);
    }

    public function show(string $locale, Project $project)
    {
        $project->load(['images', 'videos']);

        return view('pages.projects.show', [
            'project' => $project,
            'seoTitle' => $project->seoTitle(),
            'seoDescription' => $project->seoDescription(),
            'seoImage' => $project->ogImageUrl(),
        ]);
    }
}
