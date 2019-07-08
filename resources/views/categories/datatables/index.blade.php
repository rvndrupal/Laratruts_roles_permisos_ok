@permission('update-categories')
    <a
        href="{{ route('categories.edit', ['id' => $id]) }}"
        title="{{ __('Actualizar categoría') }}"
        data-id="{{ $id }}"
        class="btn btn-primary"
    >
        <i class="fa fa-pencil-alt"></i>
    </a>
@endpermission

@permission('delete-categories')
<a
    href="#"
    data-route="{{ route('categories.destroy', ['id' => $id]) }}"
    title="{{ __('Eliminar categoría') }}"
    data-id="{{ $id }}"
    class="btn btn-danger btn-remove"
>
    <i class="fa fa-trash-alt"></i>
</a>
@endpermission