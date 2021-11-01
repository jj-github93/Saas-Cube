<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-list|role-create|role-edit|role-delete|',
            ['only' => ['index', 'store']]
        );
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-edit', ['only' => 'edit', 'update']);
        $this->middleware('permission:role-delete', ['only' => 'destroy', 'delete']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderby('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $all_permissions = Permission::get();
        return view('roles.create', compact('all_permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'unique:roles,name'],
            'permissions' => ['required'],
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('roles.index')
            ->with('success', 'Role added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $rolePermissions = Permission::join('role_has_permissions', 'role_has_permissions.permission_id', '=', 'permission.id')
            ->where('role_has_permissions.role_id', $role->id)
            ->get();

        return view('role.show', compact(['role', 'rolePermissions']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        view('roles.edit', compact(['permission', 'rolePermissions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => ['required|string'],
            'permissions' => ['required']
        ]);

        if ($request['name'] != $role->name && !is_null($request['name'])) {
            $role->name = $request->input('name');
        }
        $role->save();
        $role->syncPermissions($request->input('permissions'));

        return redirect()->route('roles.index')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        DB::table('roles')->where('id', $role->id)->delete();

        return redirect()->route('roles.index')
            ->with('success', "Role deleted successfully");
    }
}
