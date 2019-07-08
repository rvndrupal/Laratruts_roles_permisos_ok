@extends('layouts.admin')

@section('title', $title)

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('Formulario de pedidos') }}</h3>
        </div>

        @if($order->exists)
            {{ Form::model($order, ['url' => route('orders.update', ['id' => $order->id]), 'method' => 'put']) }}
        @else
            {{ Form::model($order, ['url' => route('orders.store'), 'method' => 'POST']) }}
        @endif
                @csrf
                <div class="box-body">
                    <div class="form-group {{ $errors->has('cost') ? 'has-error' : '' }}">
                        {{ Form::label('cost', __('Coste'), ['class' => 'control-label']) }}
                        {{ Form::number('cost', null, ['class' => ['form-control'], 'id' => 'cost']) }}
                        @if ($errors->has('cost'))
                            <span class="help-block">
                                <strong>{{ $errors->first('cost') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group {{ $errors->has('notes') ? 'has-error' : '' }}">
                        {{ Form::label('notes', __('Notas'), ['class' => 'control-label']) }}
                        {{ Form::textarea('notes', null, ['class' => ['form-control'], 'id' => 'notes']) }}
                        @if ($errors->has('notes'))
                            <span class="help-block">
                                <strong>{{ $errors->first('notes') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('created_at') ? 'has-error' : '' }}">
                        {{ Form::label('created_at', __('Fecha de alta'), ['class' => 'control-label']) }}
                        {{ Form::date('created_at', null, ['class' => ['form-control'], 'id' => 'created_at']) }}
                        @if ($errors->has('created_at'))
                            <span class="help-block">
                                <strong>{{ $errors->first('created_at') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('customer_id') ? 'has-error' : '' }}">
                        {{ Form::label('customer_id', __('Cliente'), ['class' => 'control-label']) }}
                        {{ Form::select('customer_id', $customers, $order->customer_id, ['class' => ['form-control select2']]) }}
                        @if($errors->has('customer_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('customer_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('payment_method_id') ? 'has-error' : '' }}">
                        {{ Form::label('payment_method_id', __('Método de pago'), ['class' => 'control-label']) }}
                        {{ Form::select('payment_method_id', $payment_methods, $order->payment_method, ['class' => ['form-control select2']]) }}
                        @if($errors->has('payment_method_id'))
                            <span class="help-block">
                                <strong>{{ $errors->first('payment_method_id') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="box-footer">
                    <a href="{{ route('orders.index') }}" class="btn btn-default">{{ __('Volver') }}</a>
                    <button type="submit" class="btn btn-info pull-right">{{ __($title) }}</button>
                </div>
            {{ Form::close() }}
    </div>
@stop