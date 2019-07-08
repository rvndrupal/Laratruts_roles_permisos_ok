@extends('layouts.admin')

@section('title', 'AdminLTE')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('Listado de pedidos') }}</h3>
        </div>
        <div class="box-body">
            <div id="orders_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="orders" class="table table-bordered table-hover dataTable" role="grid">
                            <thead>
                                <tr>
                                    <th>{{ __("ID") }}</th>
                                    <th>{{ __("Cliente") }}</th>
                                    <th>{{ __("Coste") }}</th>
                                    @if(auth()->user()->can('update-orders') || auth()->user()->can('delete-orders'))
                                        <th width="60">{{ __("Acciones") }}</th>
                                    @endif
                                </tr>

                            {{ auth()->user()->can('update-orders') }}
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        jQuery(document).ready(function ($) {
            dt = $("#orders").DataTable({
                pageLength: 5,
                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                processing: true,
                serverSide: true,
                ajax: '{{ route('orders.json') }}',
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                columns: [
                    {data: 'id', visible: false},
                    {data: 'customer.name'},
                    {data: 'cost'},
                    @if(auth()->user()->can('update-orders') || auth()->user()->can('delete-orders'))
                        {data: 'actions'}
                    @endif
                ]
            });
        })
    </script>
@endpush