<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return RoleResource
     */
    public function index()
    {
        $this->authorize('view-all-roles');
        $roles = Role::all();
        return new RoleResource($roles);
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function store(CreateRoleRequest $request)
    {
        $this->authorize('create-role');
        $validated = $request->validated();
        $role = Role::create(['name' => $validated['name']]);
        if($request->permission)
        {
            $role->syncPermissions($validated['permission']);
        }
        return response()->json([
            'message' => __('Role successfully registered'),
            'data' => new RoleResource($role)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return mixed
     */
    public function show(Role $role)
    {
        $this->authorize('view-role');
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$role->id)
            ->get();

        return response()->json([
            'message' => __('Role successfully retreived'),
            'data' => new RoleResource($role),
            'permissions' => $rolePermissions
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return mixed
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize('edit-role');
        $validated = $request->validated();
        $role->update(['name' => $validated['name']]);
        $role->syncPermissions($validated['permission']);
        return response()->json([
            'message' => __('Role successfully updated'),
            'data' => new RoleResource($role)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return mixed
     */
    public function destroy(Role $role)
    {
        $this->authorize('delete-role');
        $role->delete();
        return response()->json([
            'message' => __('Role successfully deleted')
        ]);
    }
}
