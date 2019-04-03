<div class="d-flex-row">
    <table class="table table-bordered table-hover" id="branchesTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Код</th>
            <th>Название</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @if(count($branches))
            @foreach($branches as $branch)
                <tr id="{{ $branch->id }}">
                    <td>{{ $branch->id }}</td>
                    <td>{{ $branch->code }}</td>
                    <td><strong>{{ $branch->displayName }}</strong></td>
                    <td>{{ \App\Status::code($branch->status)->title}}</td>
                </tr>
            @endforeach
        @else
        @endif
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        var selectedBranchId;
        var table = $('#branchesTable').DataTable({
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
                        Branches.edit();
                    }
                },
                {
                    text: 'Редактировать',
                    className: 'btn-primary',
                    action: function ( e, dt, node, config ) {
                        Branches.edit(selectedBranchId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'branchEditButton'
                    }
                },
                {
                    text: 'Удалить',
                    className: 'btn-danger',
                    action: function ( e, dt, node, config ) {
                        Branches.delete(selectedBranchId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'branchDeleteButton'
                    }
                },
            ]
        });
        if(table.page.info().recordsTotal == 0) {
            $('#branchEditButton').hide();
            $('#branchDeleteButton').hide();
        }

        $('#branchesTable tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#branchEditButton').prop('disabled', true);
                $('#branchDeleteButton').prop('disabled', true);
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#branchEditButton').prop('disabled', false);
                $('#branchDeleteButton').prop('disabled', false);
                selectedBranchId = $(this).attr('id');
            }
        } );
    })
</script>