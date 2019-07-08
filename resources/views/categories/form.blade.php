@extends('layouts.admin')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('Formulario de categorías') }}</h3>
        </div>

        <div class="box-body">
            @if($category->exists)
                {{ Form::model($category, ['url' => route('categories.update', ['id' => $category->id]), 'method' => 'put']) }}
            @else
                {{ Form::model($category, ['url' => route('categories.store')]) }}
            @endif

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {{ Form::label('name', __('Nombre'), ['class' => 'control-label']) }}
                {{ Form::text('name', null, ['class' => ['form-control'], 'id' => 'name']) }}
                @if($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="box-footer">
            <a href="{{ route('categories.index') }}" class="btn btn-default">{{ __('Volver') }}</a>
            {{ Form::submit($title, ['class' => 'btn btn-info pull-right']) }}
            {{ Form::close() }}
        </div>

    </div>
@stop
