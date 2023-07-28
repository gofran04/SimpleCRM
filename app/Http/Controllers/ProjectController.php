<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Http\Resources\ProjectResource;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view-all-projects');
        $projects = Project::all();
        return ProjectResource::collection($projects);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $this->authorize('create-project');
        $project = Project::create($request->validated());
        return (new ProjectResource($project))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $this->authorize('view-project');
        return new ProjectResource($project);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('edit-project');
        $project->update($request->validated());

        return (new ProjectResource($project))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete-project');
        $project->delete();
        return response()->json([
            'message' => __('Project successfully deleted')
        ]);
        //return response(null, Response::HTTP_NO_CONTENT);
    }
}
