@extends('layouts.admin')

@permission('read-user')
@section('content')


        <div class="box">
            <div class="box-header">
                <h3 class="box-title">{{ __('Formulario de Roles') }}</h3>
            </div>

            <div class="box-body">
                @if($roles->exists)
                    {{ Form::model($roles, ['url' => route('role.update', ['id' => $roles->id]), 'method' => 'put']) }}
                @else
                    {{ Form::model($roles, ['url' => route('role.store')]) }}
                @endif


                <div class="from-group">
                    {!! Form::label('name','Nombre') !!}

                    {!! Form::text('name', null, ['class' => 'form-control']) !!}

            </div>
            <div class="from-group">
                    {!! Form::label('display_name','Display name') !!}

                    {!! Form::text('display_name', null, ['class' => 'form-control']) !!}

            </div>
            <div class="from-group">
                    {!! Form::label('description','Descripción') !!}

                    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}

            </div>



                <h3>Lista de Permisos</h3><hr>
                {{--  <div class="form-group">
                        {{ Form::select('permissions[]', $permissions, null, ['class' => 'form-control permissions','multiple']) }}
                </div>  --}}
                <div class="form-group">
                        <ul class="list-unstyled">
                            @foreach ($permissions as $permission )
                                <li>
                                    <label>
                                    {{ Form::checkbox('permissions[]', $permission->id, null) }}
                                    {{ $permission->name }}
                                    <em>( {{ $permission->description ?: 'N/A' }})</em>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                </div>



            </div>

            <div class="box-footer">
                <a href="{{ route('user.index') }}" class="btn btn-default">{{ __('Volver') }}</a>
                {{ Form::submit($title, ['class' => 'btn btn-info pull-right']) }}
                {{ Form::close() }}
            </div>

        </div>


@stop
@endpermission



<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>


