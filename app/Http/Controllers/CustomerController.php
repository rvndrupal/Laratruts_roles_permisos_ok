<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\CustomerRequest;
use App\PaymentMethod;

class CustomerController extends Controller
{
    public function index () {
        $title = __('Clientes');
        return view('customers.index', compact('title'));
    }

    public function json () {
        if (request()->ajax()) {
            $actions = 'customers.datatables.index';
            return datatables()->of(Customer::query())->addColumn('actions', $actions)
                ->rawColumns(['actions'])
                ->toJson();
        }
    }

    public function create () {
        $title = __('Crear cliente');
        $paymentMethods = PaymentMethod::pluck('name', 'id')->toArray();
        $payments = hooks()->apply_filters('add_custom_payment_methods', $paymentMethods);
        $customer = new Customer;
        return view('customers.form', compact('customer', 'payments', 'title'));
    }

    /**
     * @param CustomerRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store (CustomerRequest $request) {
        try {
            \DB::beginTransaction();
            hooks()->do_action('before_create_customer');
            $customer = Customer::create($request->except('payment_methods'));
            $customer->paymentMethods()->attach($request->input('payment_methods'));
            hooks()->do_action('after_create_customer', $customer);
            \DB::commit();
            return redirect(route('customers.index'))->with('message', [
                'success', __("Cliente creado correctamente")
            ]);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect(route('customers.index'))->with('message', [
                'danger', __(sprintf("Error creando el cliente: %s", $exception->getMessage()))
            ]);
        }
    }

    public function edit ($id) {
        $title = __('Actualizar cliente');
        $paymentMethods = PaymentMethod::pluck('name', 'id')->toArray();
        $payments = hooks()->apply_filters('add_custom_payment_methods', $paymentMethods);
        $customer = Customer::with('paymentMethods')->findOrFail($id);
        return view('customers.form', compact('customer', 'payments', 'title'));
    }

    /**
     * @param CustomerRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update (CustomerRequest $request, $id) {
        try {
            \DB::beginTransaction();
            $customer = Customer::findOrFail($id);
            hooks()->do_action('before_update_customer', $customer);
            $customer->fill($request->except('payment_methods'))->save();
            $customer->paymentMethods()->sync($request->input('payment_methods'));
            hooks()->do_action('after_update_customer', $customer);
            \DB::commit();
            return redirect(route('customers.edit', ['id' => $id]))->with('message', [
                'success', __("Cliente actualizado correctamente")
            ]);
        } catch (\Exception $exception) {
            \DB::rollBack();
            return redirect(route('customers.index'))->with('message', [
                'danger', __(sprintf("Error actualizando el cliente: %s", $exception->getMessage()))
            ]);
        }
    }
}
