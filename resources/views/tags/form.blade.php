@extends('layouts.admin')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('Formulario de etiquetas') }}</h3>
        </div>

        <div class="box-body">
            @if($tag->exists)
                {{ Form::model($tag, ['url' => route('tags.update', ['id' => $tag->id]), 'method' => 'put']) }}
            @else
                {{ Form::model($tag, ['url' => route('tags.store')]) }}
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
            <a href="{{ route('tags.index') }}" class="btn btn-default">{{ __('Volver') }}</a>
            {{ Form::submit($title, ['class' => 'btn btn-info pull-right']) }}
            {{ Form::close() }}
        </div>

    </div>
@stop
