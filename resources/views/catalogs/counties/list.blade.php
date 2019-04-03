<div class="d-flex-row">
    <table class="table table-bordered table-hover" id="countiesTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Код</th>
            <th>Название</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @if(count($counties))
            @foreach($counties as $county)
                <tr id="{{ $county->id }}">
                    <td>{{ $county->id }}</td>
                    <td>{{ $county->code }}</td>
                    <td><strong>{{ $county->displayName }}</strong></td>
                    <td>{{ \App\Status::code($county->status)->title}}</td>
                </tr>
            @endforeach
        @else
        @endif
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        var selectedCountyId;
        var table = $('#countiesTable').DataTable({
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
                        Counties.edit();
                    }
                },
                {
                    text: 'Редактировать',
                    className: 'btn-primary',
                    action: function ( e, dt, node, config ) {
                        Counties.edit(selectedCountyId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'countyEditButton'
                    }
                },
                {
                    text: 'Удалить',
                    className: 'btn-danger',
                    action: function ( e, dt, node, config ) {
                        Counties.delete(selectedCountyId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'countyDeleteButton'
                    }
                },
            ]
        });
        if(table.page.info().recordsTotal == 0) {
            $('#countyEditButton').hide();
            $('#countyDeleteButton').hide();
        }

        $('#countiesTable tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#countyEditButton').prop('disabled', true);
                $('#countyDeleteButton').prop('disabled', true);
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#countyEditButton').prop('disabled', false);
                $('#countyDeleteButton').prop('disabled', false);
                selectedCountyId = $(this).attr('id');
            }
        } );
    })
</script>