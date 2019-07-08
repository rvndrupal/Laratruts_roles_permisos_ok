<?php
namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\PaymentMethod;
use App\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index () {
        $title = __("Pedidos");
        return view('orders.index', compact('title'));
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function json () {
        if (request()->ajax()) {
            $actions = 'orders.datatables.index';
            return datatables()->of(Order::with('customer'))->addColumn('actions', $actions)->rawColumns(['actions'])->toJson();
        }
        abort(401);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create () {
        $title = __("Crear pedido");
        $arrayCustomers = Customer::pluck('name', 'id')->toArray();
        $arrayPaymentMethods = PaymentMethod::pluck('name', 'id')->toArray();
        $customers = hooks()->apply_filters('add_custom_customers', $arrayCustomers);
        $payment_methods = hooks()->apply_filters('add_custom_payment_methods', $arrayPaymentMethods);
        $order = new Order();
        return view('orders.create', compact('order', 'customers', 'payment_methods', 'title'));
    }

    /**
     * @param OrderRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store (OrderRequest $request) {
        try {
            DB::beginTransaction();
            hooks()->do_action('before_create_order');
            $order = Order::create($request->except('order_lines'));
            DB::commit();
            hooks()->do_action('after_create_order', $order);
            return redirect(route('orders.index'))->with('message', ['success', __('Pedido dado de alta correctamente')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('orders.create'))
                ->with('message', ['danger', __(sprintf('Error creando el pedido: %s', $exception->getMessage()))]);
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit ($id) {
        $title = __("Actualizar pedido");
        $arrayCustomers = Customer::pluck('name', 'id')->toArray();
        $arrayPaymentMethods = PaymentMethod::pluck('name', 'id')->toArray();
        $customers = hooks()->apply_filters('add_custom_customers', $arrayCustomers);
        $payment_methods = hooks()->apply_filters('add_custom_payment_methods', $arrayPaymentMethods);
        $order = Order::with('orderLines', 'customer', 'paymentMethod')->findOrFail($id);
        return view('orders.edit', compact('order', 'customers', 'payment_methods', 'title'));
    }

    /**
     * @param OrderRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update (OrderRequest $request, $id) {
        try {
            DB::beginTransaction();
            $order = Order::findOrFail($id);
            hooks()->do_action('before_update_order', $order);
            $order->fill($request->input())->save();
            DB::commit();
            hooks()->do_action('after_update_order', $order);
            return redirect(route('orders.edit', ['id' => $id]))->with('message', ['success', __('Pedido actualizado correctamente')]);
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('orders.edit', ['id' => $id]))
                ->with('message', ['danger', __(sprintf('Error actualizando el pedido: %s', $exception->getMessage()))]);
        }
    }

    /**
     * @param $id
     * @throws \Exception
     */
    public function destroy ($id) {
        if (request()->ajax()) {
            if (auth()->user()->can('delete-orders')) {
                hooks()->do_action('before_delete_order', $id);
                $order = Order::find($id);
                $order->delete();
                hooks()->do_action('after_delete_order', $id);
            }
        } else {
            abort(401);
        }
    }
}
