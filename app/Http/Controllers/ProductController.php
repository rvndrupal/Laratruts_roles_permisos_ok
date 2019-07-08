<?php
namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\Tag;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index () {
        $title = __("Productos");
        return view('products.index', compact('title'));
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function json () {
        if (request()->ajax()) {
            $actions = 'products.datatables.index';
            return datatables()->of(Product::query())->addColumn('actions', $actions)->rawColumns(['actions'])->toJson();
        }
        abort(401);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create () {
        $title = __("Crear producto");
        $arrayCategories = Category::pluck('name', 'id')->toArray();
        $arrayTags = Tag::pluck('name', 'id')->toArray();
        $categories = hooks()->apply_filters('add_custom_categories', $arrayCategories);
        $tags = hooks()->apply_filters('add_custom_tags', $arrayTags);
        $product = new Product;
        return view('products.form', compact('product', 'tags', 'categories', 'title'));
    }

    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store (ProductRequest $request) {
        try {
            DB::beginTransaction();
            $product = Product::create($request->except('tags'));
            $product->tags()->attach($request->input('tags'));
            hooks()->do_action('after_create_product', $product);
            DB::commit();
            return redirect(route('products.index'))->with('message', ['success', __('Producto dado de alta correctamente')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('products.create'))
                ->with('message', ['danger', __(sprintf('Error creando el producto: %s', $exception->getMessage()))]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit ($id) {
        $title = __("Actualizar producto");
        $arrayCategories = Category::pluck('name', 'id')->toArray();
        $arrayTags = Tag::pluck('name', 'id')->toArray();
        $categories = hooks()->apply_filters('add_custom_categories', $arrayCategories);
        $tags = hooks()->apply_filters('add_custom_categories', $arrayTags);
        $product = Product::with('tags')->findOrFail($id);
        return view('products.form', compact('product', 'categories', 'tags', 'title'));
    }

    /**
     * @param ProductRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update (ProductRequest $request, $id) {
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($id);
            hooks()->do_action('before_update_product', $product);
            $product->fill($request->except('tags'))->save();
            $product->tags()->sync($request->input('tags'));
            hooks()->do_action('after_update_product', $product);
            DB::commit();
            return redirect(route('products.edit', ['id' => $id]))->with('message', ['success', __('Producto actualizado correctamente')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('products.edit', ['id' => $id]))
                ->with('message', ['danger', __(sprintf('Error actualizando el producto: %s', $exception->getMessage()))]);
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function destroy ($id) {
        if (request()->ajax()) {
            if (auth()->user()->can('delete-products')) {
                hooks()->do_action('before_delete_product', $id);
                $product = Product::find($id);
                $product->delete();
                hooks()->do_action('after_delete_product', $id);
            }
        } else {
            abort(401);
        }
    }
}

