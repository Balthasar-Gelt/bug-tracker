<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use Inertia\Inertia;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller
{
    function __construct()
    {
        $this->middleware('userProjects')->except(['index', 'create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Project/Index', [
            'projects' => Auth::user()->projects()
                ->withCount(['bugs', 'users'])
                ->get()->toArray(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Project/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $project = Project::create(
            $request->validated() + ['created_by' => Auth::user()->id]
        );

        $project->users()->attach(Auth::user()->id);

        return Redirect::route('projects.index')->with('message', 'Project successfully created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return Inertia::render('Project/Show', [
            'project' => $project,
        ]);
    }

    public function users(Project $project)
    {
        return $project->users()->withCount([
            'bugs as assigned_bugs' => function ($query) use ($project) {
                $query->where('is_resolved', 0)->where('project_id', $project->id);
            }, 'bugs as resolved_bugs' => function ($query) use ($project) {
                $query->where('is_resolved', 1)->where('project_id', $project->id);
            }
        ])
            ->orderBy('name', 'asc')
            ->paginate(10);
    }

    public function bugs(Project $project)
    {
        return $project->bugs()->with('priority')->orderBy('name', 'asc')
            ->paginate(10);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return Inertia::render('Project/Edit', [
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return Redirect::route('projects.index')->with('message', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return Redirect::back()->with('message', 'Project deleted successfully');;
    }
}
