<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProjectResource;
use App\Http\Resources\Api\V1\ProjectCollection;
use App\Services\V1\ProjectQuery;
use App\Http\Requests\Api\V1\StoreProjectRequest;
use App\Http\Requests\Api\V1\UpdateProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ProjectQuery();
        $queryItems = $filter->transform($request);

        if(count($queryItems) == 0){
            return new ProjectCollection(Project::all());
        }else{
            return new ProjectCollection(Project::where($queryItems)->get());
        }
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
        return new ProjectResource(Project::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show($houseCode)
    {
        $project = Project::where('house_code', $houseCode)->firstOrFail();
        return new ProjectResource($project);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, $houseCode)
    {
        $project = Project::where('house_code', $houseCode)->firstOrFail();
        $validated = $request->all();
        unset($validated['house_code']);
        unset($validated['clientSatisfaction']);

        $project->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($houseCode)
    {
        $project = Project::where('house_code', $houseCode)->firstOrFail();

        if(!$project){
            return response()->json(['message' => 'Project not found'], 404);
        }

        $project->delete();

        return response()->json(['message' => 'Project has been deleted']);
    }
}
