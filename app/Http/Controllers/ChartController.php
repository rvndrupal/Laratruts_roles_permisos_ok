<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\Product;

class ChartController extends Controller
{
    public function index () {
        $title = __('Gráficas');
        $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $begin = date_create('2019-01-01');
        $end = date_create('2019-12-31');
        $i = new \DateInterval('P1M'); //pasa de un mes de duración.
        $period = new \DatePeriod($begin, $i, $end);

        $orders = Order::select(
            \DB::raw('COUNT(*) as total'),
            \DB::raw('MONTH(created_at) as months')
        )
            ->whereYear('created_at', '=', 2019)
            ->groupBy('months')
            ->get();

        $products = Product::select(
            \DB::raw('COUNT(*) as total'),
            \DB::raw('MONTH(created_at) as months')
        )
            ->whereYear('created_at', '=', 2019)
            ->groupBy('months')
            ->get();

        $customers = Customer::select(
            \DB::raw('COUNT(*) as total'),
            \DB::raw('MONTH(created_at) as months')
        )
            ->whereYear('created_at', '=', 2019)
            ->groupBy('months')
            ->get();

        $data = [];
        foreach ($orders as $order) {
            $data['_orders'][$order['months']] = [
                'month' => $order['months'],
                'total' => $order['total']
            ];
        }
        foreach ($products as $product) {
            $data['_products'][$product['months']] = [
                'month' => $product['months'],
                'total' => $product['total']
            ];
        }
        foreach ($customers as $customer) {
            $data['_customers'][$customer['months']] = [
                'month' => $customer['months'],
                'total' => $customer['total']
            ];
        }

        foreach ($period as $date) {
            $month = (int) $date->format('m'); //la magia de los meses en cero
            $data['orders'][] = isset($data['_orders'][$month]) ? $data['_orders'][$month]['total'] : 0;
            $data['products'][] = isset($data['_products'][$month]) ? $data['_products'][$month]['total'] : 0;
            $data['customers'][] = isset($data['_customers'][$month]) ? $data['_customers'][$month]['total'] : 0;
         }

        $chartjs = app()->chartjs
            ->name('lineChartPOS')
            ->type('line')
            ->size(['width' => 400, 'height' => 200])
            ->labels($months)
            ->datasets([
                [
                    "label" => __('Pedidos'),
                    'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $data['orders'],
                ],
                [
                    "label" => __('Clientes'),
                    'backgroundColor' => "rgba(98, 85, 204, 0.31)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $data['customers'],
                ],
                [
                    "label" => __('Productos'),
                    'backgroundColor' => "rgba(208, 125, 125, 0.5)",
                    'borderColor' => "rgba(38, 185, 154, 0.7)",
                    "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                    "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                    "pointHoverBackgroundColor" => "#fff",
                    "pointHoverBorderColor" => "rgba(220,220,220,1)",
                    'data' => $data['products'],
                ]
            ])
            ->options([]);

        return view('charts.index', compact('chartjs', 'title'));
    }
}
