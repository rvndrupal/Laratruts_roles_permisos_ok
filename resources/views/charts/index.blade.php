@extends('layouts.admin')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __("Rendimiento") }}</h3>
        </div>
        <div class="box-body">
            <div id="chart_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-12">
                        {!! $chartjs->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
