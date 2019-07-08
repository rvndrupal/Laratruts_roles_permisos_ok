@permission('update-products')
    <a
        href="{{ route('products.edit', ['id' => $id]) }}"
        title="{{ __('Actualizar producto') }}"
        data-id="{{ $id }}"
        class="btn btn-primary"
    >
        <i class="fa fa-pencil-alt"></i>
    </a>
@endpermission

@permission('delete-products')
<a
    href="#"
    data-route="{{ route('products.destroy', ['id' => $id]) }}"
    title="{{ __('Eliminar producto') }}"
    data-id="{{ $id }}"
    class="btn btn-danger btn-remove"
>
    <i class="fa fa-trash-alt"></i>
</a>
@endpermission