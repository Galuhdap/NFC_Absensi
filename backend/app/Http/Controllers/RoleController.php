<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Role::all();

        $result = RoleResource::collection($data);

        return $this->sendResponse($result, "Succesful Get");
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
    public function store(StoreRoleRequest $request)
    {
        $data = new RoleResource(Role::create($request->validated()));


        return $this->sendResponse($data, "Succesful Store");
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $cek = Role::find($role->id);

        if (!$cek) {
            abort(404, "Object Not Found");
        }

        $data = new RoleResource($cek);

        return $this->sendResponse($data, "Succesful");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoleRequest $request, Role $role)
    {
        $role->update($request->validated());

        $result = new RoleResource($role);

        return $this->sendResponse($result, "Succesful Update");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $result = $role->delete();

        return $this->sendResponse($result, "Succesful Delete");
    }
}
