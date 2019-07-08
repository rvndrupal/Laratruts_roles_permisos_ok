@extends('layouts.admin')

@section('title', 'AdminLTE')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('Listado de métodos de pago') }}</h3>
        </div>
        <div class="box-body">
            <div id="payment_methods_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="payment_methods" class="table table-bordered table-hover dataTable" role="grid">
                            <thead>
                                <tr>
                                    <th>{{ __("ID") }}</th>
                                    <th>{{ __("Nombre") }}</th>
                                    <th>{{ __("Descripción") }}</th>
                                    <th width="60">{{ __("Acciones") }}</th>
                                </tr>
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
            dt = $("#payment_methods").DataTable({
                pageLength: 5,
                lengthMenu: [ 5, 10, 25, 50, 75, 100 ],
                processing: true,
                serverSide: true,
                ajax: '{{ route('payment-methods.json') }}',
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                },
                columns: [
                    {data: 'id', visible: false},
                    {data: 'name'},
                    {data: 'description'},
                    {data: 'actions'}
                ]
            });
        })
    </script>
@endpush