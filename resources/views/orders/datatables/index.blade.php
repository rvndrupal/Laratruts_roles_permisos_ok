@permission('update-orders')
    <a
        href="{{ route('orders.edit', ['id' => $id]) }}"
        title="{{ __("Actualizar pedido") }}"
        data-id="{{$id}}"
        class="btn btn-primary"
    >
        <i class="fa fa-pencil-alt"></i>
    </a>
@endpermission

@permission('delete-orders')
    <a
        href="#"
        data-route="{{ route('orders.destroy', ['id' => $id]) }}"
        title="{{ __("Eliminar pedido") }}"
        class="btn btn-danger btn-remove"
    >
        <i class="fa fa-trash-alt"></i>
    </a>
@endpermission