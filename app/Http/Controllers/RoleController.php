<?php

namespace App\Http\Controllers;

use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    {
        if(!Gate::allows('isAdmin')) {
            return response()->json([
                    'success' => false,
                    'message' => 'Not Authorized.'
                ], 403);
        }            
        $roles = Role::all();

        if (!$roles) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, roles cannot be found.'
            ], 400);
        }
        return response()->json([
             'success' => true,
             'data' => $roles
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        if(!Gate::allows('isAdmin')) {
            return response()->json([
                    'success' => false,
                    'message' => 'Not Authorized.'
                ], 403);
        }            
        $role = Role::find($id);
        
        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, role with id ' . $id . ' cannot be found.'
            ], 400);
        }
        return response()->json([
                'success' => true,
                'data' => $role
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
    */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
    */
    public function destroy(Role $role)
    {
        //
    }
}
