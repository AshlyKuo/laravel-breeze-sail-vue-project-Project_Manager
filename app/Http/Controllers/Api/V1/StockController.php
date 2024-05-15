<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\StockResource;
use App\Http\Resources\Api\V1\StockCollection;
use App\Services\V1\StockQuery;
use App\Http\Requests\Api\V1\StoreStockRequest;
use App\Http\Requests\Api\V1\UpdateStockRequest;


class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new StockQuery();
        $queryItems = $filter->transform($request);

        if(count($queryItems) == 0){
            return new StockCollection(Stock::all());
        }else{
            return new StockCollection(Stock::where($queryItems)->get());
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
    public function store(StoreStockRequest $request)
    {
        return new StockResource(Picture::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Stock $stock)
    {
        return new StockResource($stock);
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
    public function update(UpdateStockRequest $request, Stock $picture)
    {

        $stock->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $stock = Picture::find($id);

        if(!$stock){
            return response()->json(['message' => 'Stock not found'], 404);
        }

        $stock->delete();

        return response()->json(['message' => 'Stock has been deleted']);
    }

}
