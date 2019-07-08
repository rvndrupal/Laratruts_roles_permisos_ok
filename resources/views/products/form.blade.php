@extends('layouts.admin')

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ __('Formulario de productos') }}</h3>
        </div>

        <div class="box-body">
            @if($product->exists)
                {{ Form::model($product, ['url' => route('products.update', ['id' => $product->id]), 'method' => 'put', 'files' => true]) }}
            @else
                {{ Form::model($product, ['url' => route('products.store'), 'files' => true]) }}
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

            @if($product->image)
                {{ Html::image('storage/products/' . $product->image) }}
            @endif
            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                {{ Form::label('image', __('Imagen'), ['class' => 'control-label']) }}
                {{ Form::file('image', null, ['class' => ['form-control'], 'id' => 'image']) }}
                @if($errors->has('image'))
                    <span class="help-block">
                    <strong>{{ $errors->first('image') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                {{ Form::label('description', __('Descripción'), ['class' => 'control-label']) }}
                {{ Form::textarea('description', null, ['class' => ['form-control'], 'id' => 'description']) }}
                @if($errors->has('description'))
                    <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('stock') ? ' has-error' : '' }}">
                {{ Form::label('stock', __('Stock'), ['class' => 'control-label']) }}
                {{ Form::number('stock', null, ['class' => ['form-control'], 'id' => 'stock']) }}
                @if($errors->has('stock'))
                    <span class="help-block">
                    <strong>{{ $errors->first('stock') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                {{ Form::label('price', __('Precio'), ['class' => 'control-label']) }}
                {{ Form::number('price', null, ['class' => ['form-control'], 'id' => 'price']) }}
                @if($errors->has('price'))
                    <span class="help-block">
                    <strong>{{ $errors->first('price') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                {{ Form::label('category_id', __('Categoría'), ['class' => 'control-label']) }}
                {{ Form::select('category_id', $categories, $product->category_id, ['class' => ['form-control select2']]) }}
                @if($errors->has('category_id'))
                    <span class="help-block">
                    <strong>{{ $errors->first('category_id') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group {{ $errors->has('tags') ? 'has-error' : '' }}">
                {{ Form::label('tags', __('Etiquetas'), ['class' => 'control-label']) }}
                {{ Form::select('tags[]', $tags, $product->tags, ['multiple' => true, 'class' => ['form-control select2']]) }}
                @if($errors->has('tags'))
                    <span class="help-block">
                <strong>{{ $errors->first('tags') }}</strong>
            </span>
                @endif
            </div>

        </div>

        <div class="box-footer">
            <a href="{{ route('products.index') }}" class="btn btn-default">{{ __('Volver') }}</a>
            {{ Form::submit($title, ['class' => 'btn btn-info pull-right']) }}
            {{ Form::close() }}
        </div>

    </div>
@stop
