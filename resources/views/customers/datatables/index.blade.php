@permission('update-customers')
    <a
        href="{{ route('customers.edit', ['id' => $id]) }}"
        title="{{ __('Actualizar cliente') }}"
        data-id="{{ $id }}"
        class="btn btn-primary"
    >
        <i class="fa fa-pencil-alt"></i>
    </a>
@endpermission

@permission('delete-customers')
<a
    href="#"
    data-route="{{ route('customers.destroy', ['id' => $id]) }}"
    title="{{ __('Eliminar cliente') }}"
    data-id="{{ $id }}"
    class="btn btn-danger btn-remove"
>
    <i class="fa fa-trash-alt"></i>
</a>
@endpermission