<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Picture;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\PictureResource;
use App\Http\Resources\Api\V1\PictureCollection;
use App\Services\V1\PictureQuery;
use App\Http\Requests\Api\V1\StorePictureRequest;
use App\Http\Requests\Api\V1\UpdatePictureRequest;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new PictureQuery();
        $queryItems = $filter->transform($request);

        if(count($queryItems) == 0){
            return new PictureCollection(Picture::all());
        }else{
            return new PictureCollection(Picture::where($queryItems)->get());
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
    public function store(StorePictureRequest $request)
    {
        return new PictureResource(Picture::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Picture $picture)
    {
        return new PictureResource($picture);
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
    public function update(UpdatePictureRequest $request, Picture $picture)
    {

        $picture->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $picture = Picture::find($id);

        if(!$picture){
            return response()->json(['message' => 'Picture not found'], 404);
        }

        $picture->delete();

        return response()->json(['message' => 'Picture has been deleted']);
    }

}
