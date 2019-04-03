<div class="d-flex-row">
    <table class="table table-bordered table-hover" id="adminUsersRolesTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
        </tr>
        </thead>
        <tbody>
        @if(count($adminUsersRoles))
            @foreach($adminUsersRoles as $adminUsersRole)
                <tr id="{{ $adminUsersRole->id }}">
                    <td>{{ $adminUsersRole->id }}</td>
                    <td><strong>{{ $adminUsersRole->name }}</strong></td>
                </tr>
            @endforeach
        @else
        @endif
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        var selectedAdminUsersRoleId;
        var table = $('#adminUsersRolesTable').DataTable({
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
                        AdminUsersRoles.edit();
                    }
                },
                {
                    text: 'Редактировать',
                    className: 'btn-primary',
                    action: function ( e, dt, node, config ) {
                        AdminUsersRoles.edit(selectedAdminUsersRoleId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'adminUsersRoleEditButton'
                    }
                },
                {
                    text: 'Удалить',
                    className: 'btn-danger',
                    action: function ( e, dt, node, config ) {
                        AdminUsersRoles.delete(selectedAdminUsersRoleId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'adminUsersRoleDeleteButton'
                    }
                },
            ]
        });
        if(table.page.info().recordsTotal == 0) {
            $('#adminUsersRoleEditButton').hide();
            $('#adminUsersRoleDeleteButton').hide();
        }

        $('#adminUsersRolesTable tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#adminUsersRoleEditButton').prop('disabled', true);
                $('#adminUsersRoleDeleteButton').prop('disabled', true);
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#adminUsersRoleEditButton').prop('disabled', false);
                $('#adminUsersRoleDeleteButton').prop('disabled', false);
                selectedAdminUsersRoleId = $(this).attr('id');
            }
        } );
    })
</script>