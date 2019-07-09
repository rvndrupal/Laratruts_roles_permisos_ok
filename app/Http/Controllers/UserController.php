<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = __('Usuarios');
        return view('user.index', compact('title'));
    }


    public function json () {
        if (request()->ajax()) {
            $actions = 'user.datatables.index';
            return datatables()->of(User::query())->addColumn('actions', $actions)
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
        $roles = Role::all();
        //dd($roles);

        $title = __('Crear Usuario');
        $user = new User;
        return view('user.form', compact('user', 'title','roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());
        $user->password= bcrypt( $request->input("password") );

        $user->roles()->sync($request->get('roles'));

        $user->save();

        return redirect()->route('user.index')->with('message', [
            'success', __("Usuario creado correctamente")]);
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
        $title = __('Actualizar Usuario');
        $user = User::find($id);
        $roles = Role::all();
        return view('user.form', compact('user', 'title','roles'));
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
        try {
            \DB::beginTransaction();
            $user = User::findOrFail($id);
            hooks()->do_action('before_update_user', $user);
            $user->fill($request->input())->save();
            hooks()->do_action('after_update_user', $user);
            $user->roles()->sync($request->get('roles'));
            \DB::commit();
            return redirect(route('user.index'))->with('message', [
                'success', __("Usuario actualizado correctamente")
            ]);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect(route('user.index'))->with('message', [
                'danger', __(sprintf("Error actualizando la categoría: %s", $exception->getMessage()))
            ]);
        }
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
            if (auth()->user()->can('delete-user')) {
                try {
                    \DB::beginTransaction();
                    $user = User::find($id);

                    hooks()->add_action('before_delete_user', $user);
                    $user->delete();
                    hooks()->add_action('after_delete_category', $id);
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
