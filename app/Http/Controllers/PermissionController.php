<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    function index()
    {
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::all();
        $permissions = Permission::all();
        return view('permissions', compact('users', 'roles', 'permissions'));
    }

    function givePermit(Request $request)
    {
        $request->validate([
            'role' => 'required|exists:roles,name',
            'permission' => 'array',
            'permission.*' => 'exists:permissions,name',
        ]);

        $role = Role::findByName($request->role);
        $role->syncPermissions($request->permission);

        Alert::toast('Permissions updated.', 'success');
        return redirect()->back();
    }

    public function getPermissions($roleName)
    {
        $role = Role::where('name', $roleName)->first();

        if (!$role) {
            return response()->json([]);
        }

        return response()->json(
            $role->permissions->pluck('name')
        );
    }

    public function addPermission(Request $request)
    {
        $request->validate([
            'permission_name' => 'required|string|max:255|unique:permissions,name'
        ]);
        Permission::firstOrCreate(['name' => $request->permission_name]);
        Alert::toast('Permissions added.', 'success');
        return redirect()->back();
    }
}
