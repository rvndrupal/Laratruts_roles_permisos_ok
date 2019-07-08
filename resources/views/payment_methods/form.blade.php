@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('Formulario de métodos de pago') }}</h3>
        </div>

        @if($payment_method->exists)
            {{ Form::model($payment_method, ['url' => route('payment-methods.update', ['id' => $payment_method->id]), 'method' => 'put']) }}
        @else
            {{ Form::model($payment_method, ['url' => route('payment-methods.store'), 'method' => 'POST']) }}
        @endif
                @csrf
                <div class="box-body">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        {{ Form::label('name', __('Nombre'), ['class' => 'control-label']) }}
                        {{ Form::text('name', null, ['class' => ['form-control'], 'id' => 'name']) }}
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        {{ Form::label('description', __('Descripción'), ['class' => 'control-label']) }}
                        {{ Form::textarea('description', null, ['class' => ['form-control'], 'id' => 'description']) }}
                        @if ($errors->has('description'))
                            <span class="help-block">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="box-footer">
                    <a href="{{ route('payment-methods.index') }}" class="btn btn-default">{{ __('Volver') }}</a>
                    <button type="submit" class="btn btn-info pull-right">{{ __($title) }}</button>
                </div>
            {{ Form::close() }}
    </div>
@stop