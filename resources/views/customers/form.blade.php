@extends('layouts.admin')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('Formulario de clientes') }}</h3>
        </div>

        <div class="box-body">
            @if($customer->exists)
                {{ Form::model($customer, ['url' => route('customers.update', ['id' => $customer->id]), 'method' => 'put']) }}
            @else
                {{ Form::model($customer, ['url' => route('customers.store')]) }}
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

            <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                {{ Form::label('surname', __('Apellidos'), ['class' => 'control-label']) }}
                {{ Form::text('surname', null, ['class' => ['form-control'], 'id' => 'surname']) }}
                @if($errors->has('surname'))
                    <span class="help-block">
                    <strong>{{ $errors->first('surname') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                {{ Form::label('address', __('Dirección'), ['class' => 'control-label']) }}
                {{ Form::text('address', null, ['class' => ['form-control'], 'id' => 'address']) }}
                @if($errors->has('address'))
                    <span class="help-block">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                {{ Form::label('phone', __('Teléfono'), ['class' => 'control-label']) }}
                {{ Form::text('phone', null, ['class' => ['form-control'], 'id' => 'phone']) }}
                @if($errors->has('phone'))
                    <span class="help-block">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('payment_methods') ? ' has-error' : '' }}">
                {{ Form::label('payment_methods', __('Métodos de pago'), ['class' => 'control-label']) }}
                {{ Form::select('payment_methods[]', $payments, $customer->paymentMethods, ['multiple' => true, 'class' => ['form-control select2'], 'id' => 'payment_methods']) }}
                @if($errors->has('payment_methods'))
                    <span class="help-block">
                        <strong>{{ $errors->first('payment_methods') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="box-footer">
            <a href="{{ route('customers.index') }}" class="btn btn-default">{{ __('Volver') }}</a>
            {{ Form::submit($title, ['class' => 'btn btn-info pull-right']) }}
            {{ Form::close() }}
        </div>

    </div>
@stop
