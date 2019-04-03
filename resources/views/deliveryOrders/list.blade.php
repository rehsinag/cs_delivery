<div class="d-flex-row">
    <table class="table table-bordered table-hover" id="deliveryOrdersTable">
        <thead>
        <tr>
            <th>Дата поступления</th>
            <th>Дата доставки</th>
            <th>Номер</th>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>ИИН</th>
            <th>Телефон</th>
        </tr>
        </thead>
        <tbody>
        @if(count($deliveryOrders))
            @foreach($deliveryOrders as $deliveryOrder)
                <tr id="{{ $deliveryOrder->id }}">
                    <td>{{ \Carbon\Carbon::parse($deliveryOrder->created_at)->format('d.m.Y H:i:s') }}</td>
                    <td>{{ \Carbon\Carbon::parse($deliveryOrder->deliveryDate)->format('d.m.Y') }}</td>
                    <td>{{ $deliveryOrder->id }}</td>
                    <td>{{ $deliveryOrder->lastName }}</td>
                    <td>{{ $deliveryOrder->firstName }}</td>
                    <td>{{ $deliveryOrder->middleName }}</td>
                    <td>{{ $deliveryOrder->iin }}</td>
                    <td>{{ $deliveryOrder->phone }}</td>
                    {{--<td>{{ \App\Status::code($deliveryCompany->status)->title }}</td>--}}
                </tr>
            @endforeach
        @else
        @endif
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        var selectedDeliveryOrderId;
        var table = $('#deliveryOrdersTable').DataTable({
            language: {
                url: "{{ asset('js/dataTables/plugins/i18n/Russian.json') }}"
            },
            dom:
            "<'row'<'col-lg-6'B><'col-lg-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    text: 'Добавить',
                    action: function ( e, dt, node, config ) {
                        DeliveryOrders.edit();
                    }
                },
                {
                    text: 'Редактировать',
                    className: 'btn-primary',
                    action: function ( e, dt, node, config ) {
                        DeliveryOrders.edit(selectedDeliveryOrderId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'deliveryOrderEditButton'
                    }
                },
                {
                    text: 'Удалить',
                    className: 'btn-danger',
                    action: function ( e, dt, node, config ) {
                        DeliveryOrders.delete(selectedDeliveryOrderId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'deliveryOrderDeleteButton'
                    }
                },
            ]
        });
        if(table.page.info().recordsTotal == 0) {
            $('#deliveryOrderEditButton').hide();
            $('#deliveryOrderDeleteButton').hide();
        }

        $('#deliveryOrdersTable tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#deliveryOrderEditButton').prop('disabled', true);
                $('#deliveryOrderDeleteButton').prop('disabled', true);
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#deliveryOrderEditButton').prop('disabled', false);
                $('#deliveryOrderDeleteButton').prop('disabled', false);
                selectedDeliveryOrderId = $(this).attr('id');
            }
        } );
    })
</script>