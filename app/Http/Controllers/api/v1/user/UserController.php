<?php

namespace App\Http\Controllers\api\v1\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::orderBy('id', 'DESC')->get();
    }

    public function currentUser() {
        $user = Auth::user();
        $user_permission = $user->getAllPermissions();
        return response([
            'user' => $user, 
            'user_permission' => $user_permission
        ]);
        // return $user;
    }

    public function permission($id) {
        $user = User::find($id, 'id');
        $roles = $user->roles;
        $permissions = $user->permissions;
        return response([
            'roles' => $roles,
            'permissions' => $permissions,
        ], 200);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id, 'id');
        $user->syncRoles();
        $user->syncPermissions();
            
        if( count($request->input('role')) > 0) {
            foreach ( $request->input('role') as $role ) {
                $r = Role::findByName($role['name']);
                $user->assignRole($r);
            }
        }

        if( count($request->input('permission')) > 0) {

            foreach ( $request->input('permission') as $permission ) {
                $p = Permission::findByName($permission['name']);
                $user->givePermissionTo($p);
            }
        }

        // $role->name = $request->input('name');
        
        // $role->save();
    
        return response([
            'user' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id, 'id');

        // Delete role assign user and permission assign user
        // $user->syncRoles();
        // $user->syncPermissions();

        $user->delete();
        return response([
            'result' => 'success'
        ], 200);
    }
}
