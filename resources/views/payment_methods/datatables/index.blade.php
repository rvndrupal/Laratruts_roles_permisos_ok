@permission('update-payment-methods')
    <a
        href="{{ route('payment-methods.edit', ['id' => $id]) }}"
        title="{{ __("Actualizar método de pago") }}"
        data-id="{{$id}}"
        class="btn btn-primary"
    >
        <i class="fa fa-pencil-alt"></i>
    </a>
@endpermission

@permission('delete-payment-methods')
    <a
        href="#"
        data-route="{{ route('payment-methods.destroy', ['id' => $id]) }}"
        title="{{ __("Eliminar método de pago") }}"
        class="btn btn-danger btn-remove"
    >
        <i class="fa fa-trash-alt"></i>
    </a>
@endpermission