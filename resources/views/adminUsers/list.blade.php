<div class="d-flex-row">
    <table class="table table-bordered table-hover" id="adminUsersTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Логин</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Дата регистрации</th>
        </tr>
        </thead>
        <tbody>
        @if(count($adminUsers))
            @foreach($adminUsers as $adminUser)
                <tr id="{{ $adminUser->id }}">
                    <td>{{ $adminUser->id }}</td>
                    <td><strong>{{ $adminUser->login }}</strong></td>
                    <td>***</td>
                    <td>{{ $adminUser->email }}</td>
                    <td>{{ \Carbon\Carbon::parse($adminUser->created_at)->format('d.m.Y H:i:s') }}</td>
                </tr>
            @endforeach
        @else
        @endif
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        var selectedAdminUserId;
        var table = $('#adminUsersTable').DataTable({
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
                        AdminUsers.edit();
                    }
                },
                {
                    text: 'Редактировать',
                    className: 'btn-primary',
                    action: function ( e, dt, node, config ) {
                        AdminUsers.edit(selectedAdminUserId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'adminUserEditButton'
                    }
                },
                {
                    text: 'Удалить',
                    className: 'btn-danger',
                    action: function ( e, dt, node, config ) {
                        AdminUsers.delete(selectedAdminUserId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'adminUserDeleteButton'
                    }
                },
            ]
        });
        if(table.page.info().recordsTotal == 0) {
            $('#adminUserEditButton').hide();
            $('#adminUserDeleteButton').hide();
        }

        $('#adminUsersTable tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#adminUserEditButton').prop('disabled', true);
                $('#adminUserDeleteButton').prop('disabled', true);
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#adminUserEditButton').prop('disabled', false);
                $('#adminUserDeleteButton').prop('disabled', false);
                selectedAdminUserId = $(this).attr('id');
            }
        } );
    })
</script>