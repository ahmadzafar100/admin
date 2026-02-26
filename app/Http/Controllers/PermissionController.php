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
            'permission' => 'required|array',
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
}
