<?php
namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethodRequest;
use App\PaymentMethod;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index () {
        $title = __("Métodos de pago");
        return view('payment_methods.index', compact('title'));
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function json () {
        if (request()->ajax()) {
            $actions = 'payment_methods.datatables.actions';
            return datatables()->of(PaymentMethod::query())->addColumn('actions', $actions)->rawColumns(['actions'])->toJson();
        }
        abort(401);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create () {
        $title = __("Crear método de pago");
        $payment_method = new PaymentMethod;
        return view('payment_methods.create', compact('payment_method', 'title'));
    }

    /**
     * @param PaymentMethodRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store (PaymentMethodRequest $request) {
        try {
            DB::beginTransaction();
            hooks()->do_action('before_create_payment_method');
            $payment_method = PaymentMethod::create($request->input());
            hooks()->do_action('after_create_payment_method', $payment_method);
            DB::commit();
            return redirect(route('payment-methods.index'))
                ->with('message', ['success', __('Método de pago dado de alta correctamente')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('payment-methods.create'))
                ->with('message', ['danger', __(sprintf('Error creando el método de pago: %s', $exception->getMessage()))]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit ($id) {
        $title = __("Actualizar método de pago");
        $payment_method = PaymentMethod::findOrFail($id);
        return view('payment_methods.edit', compact('payment_method', 'title'));
    }

    /**
     * @param PaymentMethodRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update (PaymentMethodRequest $request, $id) {
        try {
            DB::beginTransaction();
            $payment_method = PaymentMethod::findOrFail($id);
            hooks()->do_action('before_update_payment_method', $payment_method);
            $payment_method->fill($request->input())->save();
            DB::commit();
            hooks()->do_action('after_update_payment_method', $payment_method);
            return redirect(route('payment-methods.edit', ['id' => $id]))
                ->with('message', ['success', __('Método de pago actualizado correctamente')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('payment-methods.edit', ['id' => $id]))
                ->with('message', ['danger', __(sprintf('Error actualizando el método de pago: %s', $exception->getMessage()))]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy ($id) {
        if (request()->ajax()) {
            if (auth()->user()->can('delete-payment-methods')) {
                $payment_method = PaymentMethod::find($id);

                if ($payment_method->customer()->count() > 0) {
                    return response()->json(['msg' => 'related']);
                }
                hooks()->do_action('before_delete_payment_method', $id);
                $payment_method->delete();
                hooks()->do_action('after_delete_payment_method', $id);
            }
        } else {
            abort(401);
        }
    }
}
