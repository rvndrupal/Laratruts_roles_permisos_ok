<?php

if ( ! function_exists('hooks')) {
    function hooks () {
        return \voku\helper\Hooks::getInstance();
    }
}

if ( ! function_exists('action_after_create_category')) {
    /**
     * @param \App\Category $category
     * @throws Exception
     */
    function action_after_create_category (\App\Category $category) {
        $check = substr($category->name, 0, 1);
        if ($check === '_') {
            $category->delete();
        }
    }
    hooks()->add_action('after_create_category', 'action_after_create_category');
}

if ( ! function_exists('filter_add_custom_payment_methods')) {
    function filter_add_custom_payment_methods ($paymentMethods) {
        if ( ! in_array('Transferencia Bancaria', $paymentMethods)) {
            $paymentMethod = \App\PaymentMethod::create([
                'name' => 'Transferencia Bancaria',
                'description' => 'Permitimos también transferencias bancarias'
            ]);
            $paymentMethods[$paymentMethod->id] = $paymentMethod->name;
        }
        return $paymentMethods;
    }
    hooks()->add_filter('add_custom_payment_methods', 'filter_add_custom_payment_methods');
}

if ( ! function_exists('action_after_create_product')) {
    /**
     * @param \App\Product $product
     */
    function action_after_create_product (\App\Product $product) {
        if (request()->hasFile('image')) {
            request()->file('image')->store('products');
            $filename = request()->file('image')->hashName();
            $product->image = $filename;
            $product->save();
        }
    }
    hooks()->add_filter('after_create_product', 'action_after_create_product');
}

if ( ! function_exists('action_after_update_product')) {
    /**
     * @param \App\Product $product
     */
    function action_after_update_product (\App\Product $product) {
        if (request()->hasFile('image')) {
            \Illuminate\Support\Facades\Storage::delete('products/' . $product->image);
            request()->file('image')->store('products');
            $filename = request()->file('image')->hashName();
            $product->image = $filename;
            $product->save();
        }
    }
    hooks()->add_filter('after_update_product', 'action_after_update_product');
}
