@permission('update-user')
    <a
        href="{{ route('user.edit', ['id' => $id]) }}"
        title="{{ __('Actualizar usuario') }}"
        data-id="{{ $id }}"
        class="btn btn-primary"
    >
        <i class="fa fa-pencil-alt"></i>
    </a>
@endpermission

@permission('delete-user')
<a
    href="#"
    data-route="{{ route('user.destroy', ['id' => $id]) }}"
    title="{{ __('Eliminar usuario') }}"
    data-id="{{ $id }}"
    class="btn btn-danger btn-remove"
>
    <i class="fa fa-trash-alt"></i>
</a>
@endpermission
