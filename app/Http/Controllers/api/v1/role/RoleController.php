<?php

namespace App\Http\Controllers\api\v1\role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::orderBy('id', 'DESC')->get();
    }

    public function permission($id) {
        $role = Role::find($id, 'id');
        $permissions = $role->permissions;
        return response([
            'permissions' => $permissions
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
        $this->validate($request, [
            'name' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->input('name'),
        ]);

        if( count($request->input('permission')) > 0) {
            foreach ( $request->input('permission') as $permission ) {
                $p = Permission::findByName($permission['name']);
                $p->assignRole($role);
            }
        }

        return response([
            'role' => $role
        ], 200);

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
        $this->validate($request, [
            'name' => 'required',
        ]);
    
        // $role = Role::find($id, 'id');
        $role = Role::findByName($request->input('oldName'));
        $role->syncPermissions();

        if( count($request->input('permission')) > 0) {
            foreach ( $request->input('permission') as $permission ) {
                $p = Permission::findByName($permission['name']);
                $p->assignRole($role);
            }
        }

        $role->name = $request->input('name');
        
        $role->save();
    
        return response([
            'role' => $role
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
        $role = Role::find($id, 'id');

        // Delete user has role and permission assign role
        $role->syncPermissions();

        $role->delete();
        return response([
            'result' => 'success'
        ], 200);
    }
}
