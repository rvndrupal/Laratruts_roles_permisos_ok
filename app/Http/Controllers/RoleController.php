<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use Session;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $title = __('Roles');
      return view('roles.index',compact('title'));
    }

    public function json () {
        if (request()->ajax()) {
            $actions = 'roles.datatables.index';
            return datatables()->of(Role::query())->addColumn('actions', $actions)
                ->rawColumns(['actions'])
                ->toJson();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$permissions = Permission::orderBy('id', 'ASC')->pluck('name', 'id');
        $permissions=Permission::all();
        $title = __('Crear nuevo rol');
        $roles = new Role;
        return view('roles.form', compact('permissions', 'title','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $role=Role::create($request->all());
        //actualizamos los permisos
        $role->permissions()->sync($request->get('permissions'));
        return redirect(route('role.index'))->with('message', ['success', __("Rol creado correctamente")]);
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
      $title = __('Editar Rol');
      $roles = Role::where('id', $id)->with('permissions')->first();
      $permissions = Permission::all(); //aqui obtiene todos los permisos seleccionados
      return view('roles.form',compact('roles','permissions','title'));
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
         $role = Role::findOrFail($id);
         $role->update($request->all());
         $role->permissions()->sync($request->get('permissions'));
         return redirect(route('role.index'))->with('message', ['success', __("Rol actualizado correctamente")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->ajax()) {
            if (auth()->user()->can('delete-role')) {
                try {
                    \DB::beginTransaction();
                    $role = Role::find($id);
                    $role->delete();
                    \DB::commit();
                } catch (\Exception $exception) {
                    \DB::rollBack();
                    //TODO hacer lo que sea necesario
                }
            }
        } else {
            abort(401);
        }
    }
}
