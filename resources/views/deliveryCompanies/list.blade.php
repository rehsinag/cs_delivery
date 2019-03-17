<div class="d-flex-row">
    <table class="table table-bordered table-hover" id="deliveryCompaniesTable">
        <thead>
        <tr>
            <th>Код компании</th>
            <th>Наименование</th>
            <th>Описание</th>
            <th>Адрес</th>
            <th>Контакт</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @if(count($deliveryCompanies))
            @foreach($deliveryCompanies as $deliveryCompany)
                <tr id="{{ $deliveryCompany->id }}">
                    <td>{{ $deliveryCompany->code }}</td>
                    <td>{{ $deliveryCompany->displayName }}</td>
                    <td>{{ $deliveryCompany->description }}</td>
                    <td>{{ $deliveryCompany->address }}</td>
                    <td>{{ $deliveryCompany->contacts }}</td>
                    <td>{{ \App\Status::code($deliveryCompany->status)->title }}</td>
                </tr>
            @endforeach
        @else
        @endif
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        var selectedDeliveryCompanyId;
        var table = $('#deliveryCompaniesTable').DataTable({
            dom:
            "<'row'<'col-lg-6'B><'col-lg-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                {
                    text: 'Добавить',
                    action: function ( e, dt, node, config ) {
                        DeliveryCompanies.edit();
                    }
                },
                {
                    text: 'Редактировать',
                    className: 'btn-primary',
                    action: function ( e, dt, node, config ) {
                        DeliveryCompanies.edit(selectedDeliveryCompanyId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'deliveryCompanyEditButton'
                    }
                },
                {
                    text: 'Удалить',
                    className: 'btn-danger',
                    action: function ( e, dt, node, config ) {
                        DeliveryCompanies.delete(selectedDeliveryCompanyId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'deliveryCompanyDeleteButton'
                    }
                },
            ]
        });
        if(table.page.info().recordsTotal == 0) {
            $('#deliveryCompanyEditButton').hide();
            $('#deliveryCompanyDeleteButton').hide();
        }

        $('#deliveryCompaniesTable tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#deliveryCompanyEditButton').prop('disabled', true);
                $('#deliveryCompanyDeleteButton').prop('disabled', true);
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#deliveryCompanyEditButton').prop('disabled', false);
                $('#deliveryCompanyDeleteButton').prop('disabled', false);
                selectedDeliveryCompanyId = $(this).attr('id');
            }
        } );
    })
</script>