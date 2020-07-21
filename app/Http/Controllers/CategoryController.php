<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryStoreRequest;
use Illuminate\Support\Facades\Gate;


class CategoryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $categories = Category::all();

        if (!$categories) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, categories cannot be found.'
            ], 400);
        }
        return response()->json([
             'success' => true,
             'data' => $categories
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
    public function store(CategoryStoreRequest $request)
    {
        if(! Gate::allows('isAdmin')){
            return response()->json([
                'success' => false,
                'message' => 'Not Authorized.'
            ], 403);
        }
        $category = new Category();
        $category->fill($request->all());
       
        if ($category->save())
           return response()->json([
              'success' => true,
               'data' => $category
        ]);
    
        return response()->json([
            'success' => false,
            'message' => 'Sorry, category could not be added.'
        ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, category with id ' . $id . ' cannot be found.'
            ], 400);
        }
        return response()->json([
             'success' => true,
             'data' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
    */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
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
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, category with id ' . $id . ' cannot be found.'
            ], 400);
        }

        $updated = $category->update($request->all());

        if ($updated) {
            return response()->json([
                'success' => true
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Sorry, category could not be updated.'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
    */
    public function destroy(Category $category)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, category with id ' . $id . ' cannot be found.'
            ], 400);
        }

        if ($category->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'category could not be deleted.'
            ], 500);
        }
    }
}
