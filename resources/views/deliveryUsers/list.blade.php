<div class="d-flex-row">
    <table class="table table-bordered table-hover" id="deliveryUsersTable">
        <thead>
        <tr>
            <th>Компания</th>
            <th>Логин</th>
            <th>Пароль</th>
            <th>Email</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Отчество</th>
            <th>Описание</th>
            <th>Роль</th>
            <th>Филиал</th>
            <th>Попыток входа</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @if(count($deliveryUsers))
            @foreach($deliveryUsers as $deliveryUser)
                <tr id="{{ $deliveryUser->id }}">
                    <td>{{ isset($deliveryUser->deliveryCompany) ? $deliveryUser->deliveryCompany->displayName : '' }}</td>
                    <td>{{ $deliveryUser->login }}</td>
                    <td>***</td>
                    <td>{{ $deliveryUser->email }}</td>
                    <td>{{ $deliveryUser->firstName }}</td>
                    <td>{{ $deliveryUser->lastName }}</td>
                    <td>{{ $deliveryUser->middleName }}</td>
                    <td>{{ $deliveryUser->description }}</td>
                    <td>{{ \App\DeliveryUserRole::code($deliveryUser->role)->title }}</td>
                    <td>{{ isset($deliveryUser->branch) ? $deliveryUser->branch->displayName : '' }}</td>
                    <td>{{ $deliveryUser->loginAttemptsCount }}</td>
                    <td>{{ \App\Status::code($deliveryUser->status)->title }}</td>
                </tr>
            @endforeach
        @else
        @endif
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        var selectedDeliveryUserId;
        var table = $('#deliveryUsersTable').DataTable({
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
                        DeliveryUsers.edit();
                    }
                },
                {
                    text: 'Редактировать',
                    className: 'btn-primary',
                    action: function ( e, dt, node, config ) {
                        DeliveryUsers.edit(selectedDeliveryUserId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'deliveryUserEditButton'
                    }
                },
                {
                    text: 'Удалить',
                    className: 'btn-danger',
                    action: function ( e, dt, node, config ) {
                        DeliveryUsers.delete(selectedDeliveryUserId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'deliveryUserDeleteButton'
                    }
                },
            ]
        });
        if(table.page.info().recordsTotal == 0) {
            $('#deliveryUserEditButton').hide();
            $('#deliveryUserDeleteButton').hide();
        }

        $('#deliveryUsersTable tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#deliveryUserEditButton').prop('disabled', true);
                $('#deliveryUserDeleteButton').prop('disabled', true);
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#deliveryUserEditButton').prop('disabled', false);
                $('#deliveryUserDeleteButton').prop('disabled', false);
                selectedDeliveryUserId = $(this).attr('id');
            }
        } );
    })
</script>