<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use Session;

class PermissionController extends Controller
{
   
    public function index()
    {
        $title = __('Permisos');
        return view('permission.index',compact('title'));
    }


    public function json()
    {
        if (request()->ajax()) {
            $actions = 'permission.datatables.index';
            return datatables()->of(Permission::query())->addColumn('actions', $actions)
                ->rawColumns(['actions'])
                ->toJson();
        }

    }


    public function create()
    {      
        $title = __('Crear nuevo Permiso');
        $permission= new Permission();
        return view('permission.form',compact('title', 'permission'));
      
    }


    public function store(Request $request)
    {
        //$permiso=Permission::create($request->all());
       
        $permiso=new Permission();
        $permiso->name = $request->name;
        $permiso->display_name = $request->name;
        $permiso->description = $request->description;
        $permiso->save();

        return redirect(route('permission.index'))->with('message', ['success', __("Permiso creado correctamente")]);
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        $title = __('Editar Permiso');
        $permission = Permission::where('id', $id)->first();
        return view('permission.form',compact('permission','title'));
    }

    
    public function update(Request $request, $id)
    {
        $permiso = Permission::find($id);

        $permiso->fill($request->all())->save();

        return redirect(route('permission.index'))->with('message', ['success', __("Permiso actualizado correctamente")]);
    }

  
    public function destroy($id)
    {
        if (request()->ajax()) {
            if (auth()->user()->can('delete-permission')) {
                try {
                    \DB::beginTransaction();
                    $permission = Permission::find($id);
                    $permission->delete();
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
