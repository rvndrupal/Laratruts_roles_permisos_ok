@permission('update-role')
    <a
        href="{{ route('role.edit', ['id' => $id]) }}"
        title="{{ __('Actualizar Rol') }}"
        data-id="{{ $id }}"
        class="btn btn-primary"
    >
        <i class="fa fa-pencil-alt"></i>
    </a>
@endpermission

@permission('delete-role')
<a
    href="#"
    data-route="{{ route('role.destroy', ['id' => $id]) }}"
    title="{{ __('Eliminar Rol') }}"
    data-id="{{ $id }}"
    class="btn btn-danger btn-remove"
>
    <i class="fa fa-trash-alt"></i>
</a>
@endpermission
