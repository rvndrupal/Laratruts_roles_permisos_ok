@permission('update-tags')
    <a
        href="{{ route('tags.edit', ['id' => $id]) }}"
        title="{{ __('Actualizar etiqueta') }}"
        data-id="{{ $id }}"
        class="btn btn-primary"
    >
        <i class="fa fa-pencil-alt"></i>
    </a>
@endpermission

@permission('delete-tags')
<a
    href="#"
    data-route="{{ route('tags.destroy', ['id' => $id]) }}"
    title="{{ __('Eliminar etiqueta') }}"
    data-id="{{ $id }}"
    class="btn btn-danger btn-remove"
>
    <i class="fa fa-trash-alt"></i>
</a>
@endpermission