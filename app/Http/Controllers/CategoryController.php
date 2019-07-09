<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index () {
        $title = __('Categorías');
        return view('categories.index', compact('title'));
    }

    public function json () {
        if (request()->ajax()) {
            $actions = 'categories.datatables.index';
            return datatables()->of(Category::query())->addColumn('actions', $actions)
                ->rawColumns(['actions'])
                ->toJson();
        }
    }

    public function create () {
        $title = __('Crear categoría');
        $category = new Category;
        //dd($category);
        return view('categories.form', compact('category', 'title'));
    }

    /**
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store (CategoryRequest $request) {
        try {
            \DB::beginTransaction();
            hooks()->do_action('before_create_category');
            $category = Category::create($request->input());
            hooks()->do_action('after_create_category', $category);
            \DB::commit();
            return redirect(route('categories.index'))->with('message', [
                'success', __("Categoría creada correctamente")
            ]);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect(route('categories.index'))->with('message', [
                'danger', __(sprintf("Error creando la categoría: %s", $exception->getMessage()))
            ]);
        }
    }

    public function edit ($id) {
        $title = __('Actualizar categoría');
        $category = Category::find($id);
        return view('categories.form', compact('category', 'title'));
    }

    /**
     * @param CategoryRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update (CategoryRequest $request, $id) {
        try {
            \DB::beginTransaction();
            $category = Category::findOrFail($id);
            hooks()->do_action('before_update_category', $category);
            $category->fill($request->input())->save();
            hooks()->do_action('after_update_category', $category);
            \DB::commit();
            return redirect(route('categories.index'))->with('message', [
                'success', __("Categoría actualizada correctamente")
            ]);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect(route('categories.index'))->with('message', [
                'danger', __(sprintf("Error actualizando la categoría: %s", $exception->getMessage()))
            ]);
        }
    }

    public function destroy ($id) {
        if (request()->ajax()) {
            if (auth()->user()->can('delete-categories')) {
                try {
                    \DB::beginTransaction();
                    $category = Category::find($id);
                    if ($category->product()->exists()) {
                        return response()->json(['msg' => __('Esta categoría está relacionada con un producto')]);
                    }
                    hooks()->add_action('before_delete_category', $category);
                    $category->delete();
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
