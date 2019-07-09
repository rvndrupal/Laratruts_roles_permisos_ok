@extends('layouts.admin')

@permission('read-permission')
@section('content')


        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ __('Formulario de Permisos') }}</h3>
            </div>

            <div class="box-body">
                @if($permission->exists)
                    {{ Form::model($permission, ['url' => route('permission.update', ['id' => $permission->id]), 'method' => 'put']) }}
                @else
                    {{ Form::model($permission, ['url' => route('permission.store')]) }}
                @endif  
                
            <h4>Ayuda: comienza con: </h4><p>
            <h4>read-create-update-delete</h4>
                
            <div class="from-group">
                    {!! Form::label('name','Nombre') !!}

                    {!! Form::text('name', null, ['class' => 'form-control']) !!}

            </div>
          
            {{--  <div class="from-group">
                    {!! Form::label('display_name','Display name') !!}

                    {!! Form::text('display_name', null, ['class' => 'form-control']) !!}

            </div>  --}}
            <div class="from-group">
                    {!! Form::label('description','Descripción') !!}

                    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}

            </div>           



            </div>

            <div class="box-footer">
                <a href="{{ route('permission.index') }}" class="btn btn-default">{{ __('Volver') }}</a>
                {{ Form::submit($title, ['class' => 'btn btn-info pull-right']) }}
                {{ Form::close() }}
            </div>

        </div>



@stop
@endpermission



<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>



