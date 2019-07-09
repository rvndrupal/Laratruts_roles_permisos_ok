@permission('update-permission')
    <a
        href="{{ route('permission.edit', ['id' => $id]) }}"
        title="{{ __('Actualizar Permiso') }}"
        data-id="{{ $id }}"
        class="btn btn-primary"
    >
        <i class="fa fa-pencil-alt"></i>
    </a>
@endpermission

@permission('delete-permission')
<a
    href="#"
    data-route="{{ route('permission.destroy', ['id' => $id]) }}"
    title="{{ __('Eliminar Permiso') }}"
    data-id="{{ $id }}"
    class="btn btn-danger btn-remove"
>
    <i class="fa fa-trash-alt"></i>
</a>
@endpermission
