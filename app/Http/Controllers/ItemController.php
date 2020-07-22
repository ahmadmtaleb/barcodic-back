<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemStoreRequest;
use Illuminate\Support\Facades\Gate;

class ItemController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if(! Gate::allows('isAdmin')){
            return response()->json([
                'success' => false,
                'message' => 'Not Authorized.'
            ], 403);
        }
        $items = Item::all();

        if (!$items) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, items cannot be found.'
            ], 400);
        }
        return response()->json([
             'success' => true,
             'data' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        if(! Gate::allows('isAdmin')){
            return response()->json([
                'success' => false,
                'message' => 'Not Authorized.'
            ], 403);
        }
        $item = new Item();
        $item->fill($request->all());
       
        if ($item->save())
           return response()->json([
              'success' => true,
               'data' => $item
        ]);
    
        return response()->json([
            'success' => false,
            'message' => 'Sorry, item could not be added.'
        ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        if(! Gate::allows('isAdmin')){
            return response()->json([
                'success' => false,
                'message' => 'Not Authorized.'
            ], 403);
        }
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, item with id ' . $id . ' cannot be found.'
            ], 400);
        }
        return response()->json([
             'success' => true,
             'data' => $item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
    */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!Gate::allows('isAdmin')){
            return response()->json([
                'success' => false,
                'message' => 'Not Authorized.'
            ], 403);
        }
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, item with id ' . $id . ' cannot be found.'
            ], 400);
        }

        $updated = $item->update($request->all());

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Sorry, item could not be updated.'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        if(! Gate::allows('isAdmin')){
            return response()->json([
                'success' => false,
                'message' => 'Not Authorized.'
            ], 403);
        }
        $item = Item::find($id);

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, item with id ' . $id . ' cannot be found.'
            ], 400);
        }

        if ($item->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'item could not be deleted.'
            ], 500);
        }
    }

    /*
    * getting info of item per its barcode 
    *
    */
    public function getInfo($request)
    {
        $result = Item::where('barcode', '=', $request)->get();
            
        if (!$result) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, information cannot be found.'
            ], 400);
        }
        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
}
