@extends('adminlte::page')

@section('title', $title)

@section('content_header')
    @if(session('message'))
        <div class="alert alert-{{ session('message')[0] }} alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i>{{ __("Mensaje") }}</h4>
            {{ session('message')[1] }}
        </div>
    @endif

    <h1>{{ $title }}</h1>
@stop

@push('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
@endpush


@yield('scripts')

@push('js')
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        var dt;
        jQuery(document).ready(function ($) {

            $(".select2").select2();

            jQuery(document).on('click', '.btn-remove', function () {
               jQuery.ajax({
                   url: $(this).data('route'),
                   type: 'DELETE',
                   headers: {
                       'x-csrf-token': $("meta[name=csrf-token]").attr('content')
                   },
                   success: (res) => {
                       if (res.hasOwnProperty('msg')) {
                           alert(res.msg);
                       }
                       dt.ajax.reload();
                   }
               })
            })
        });
    </script>
@endpush
