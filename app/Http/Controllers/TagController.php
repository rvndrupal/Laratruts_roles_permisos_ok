<?php
namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Tag;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index () {
        $title = __("Etiquetas");
        return view('tags.index', compact('title'));
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function json () {
        if (request()->ajax()) {
            $actions = 'tags.datatables.index';
            return datatables()->of(Tag::query())->addColumn('actions', $actions)->rawColumns(['actions'])->toJson();
        }
        abort(401);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create () {
        $title = __("Crear etiqueta");
        $tag = new Tag;
        return view('tags.form', compact('tag', 'title'));
    }

    /**
     * @param TagRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store (TagRequest $request) {
        try {
            DB::beginTransaction();
            hooks()->do_action('before_create_tag');
            $tag = Tag::create($request->input());
            DB::commit();
            hooks()->do_action('after_create_tag', $tag);
            return redirect(route('tags.index'))
                ->with('message', ['success', __('Etiqueta dada de alta correctamente')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('tags.create'))
                ->with('message', ['danger', __(sprintf('Error creando la etiqueta: %s', $exception->getMessage()))]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit ($id) {
        $title = __("Actualizar etiqueta");
        $tag = Tag::findOrFail($id);
        return view('tags.form', compact('tag', 'title'));
    }

    /**
     * @param TagRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update (TagRequest $request, $id) {
        try {
            DB::beginTransaction();
            $tag = Tag::findOrFail($id);
            hooks()->do_action('before_update_tag', $tag);
            $tag->fill($request->input())->save();
            DB::commit();
            hooks()->do_action('after_update_tag', $tag);
            return redirect(route('tags.edit', ['id' => $id]))
                ->with('message', ['success', __('Etiqueta actualizada correctamente')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('tags.edit', ['id' => $id]))
                ->with('message', ['danger', __(sprintf('Error actualizando la etiqueta: %s', $exception->getMessage()))]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy ($id) {
        if (request()->ajax()) {
            if (auth()->user()->can('delete-tags')) {
                $tag = Tag::find($id);
                if ($tag->products()->exists()) {
                    return response()->json(['msg' => 'La etiqueta ya está relacionada con un producto']);
                }
                hooks()->do_action('before_delete_tag', $id);
                $tag->delete();
                hooks()->do_action('after_delete_tag', $id);
            }
        } else {
            abort(401);
        }
    }
}

