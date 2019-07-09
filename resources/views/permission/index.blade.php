@extends('layouts.admin')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __("Permisos") }}</h3>
        </div>
        <div class="box-body">
            <div id="permission_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="permission" class="table table-bordered table-hover dataTable" role="grid">
                            <thead>
                                <tr>
                                    <th>{{ __("ID") }}</th>
                                    <th>{{ __("Nombre") }}</th>
                                    <th>{{ __("Descripcion") }}</th>
                                    <th width="60">{{ __("Acciones") }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        jQuery(document).ready(function ($) {
            dt = $("#permission").DataTable({    //este es el ide de la tabla para que convierta en datatebles
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 75, 100, 250, 500],
                processing: true,
                serverSide: true,
                ajax: '{{ route('permission.json') }}',
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json'
                },
                columns: [
                    { data: 'id', visible: false },
                    { data: 'name' },
                    { data: 'description' },
                    { data: 'actions' }
                ]
            })
        })
    </script>
@endpush
