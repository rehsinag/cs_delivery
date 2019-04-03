<div class="d-flex-row">
    <table class="table table-bordered table-hover" id="citiesTable">
        <thead>
        <tr>
            <th>ID</th>
            <th>Код</th>
            <th>Название</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @if(count($cities))
            @foreach($cities as $city)
                <tr id="{{ $city->id }}">
                    <td>{{ $city->id }}</td>
                    <td>{{ $city->code }}</td>
                    <td><strong>{{ $city->displayName }}</strong></td>
                    <td>{{ \App\Status::code($city->status)->title}}</td>
                </tr>
            @endforeach
        @else
        @endif
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function () {
        var selectedCityId;
        var table = $('#citiesTable').DataTable({
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
                        Cities.edit();
                    }
                },
                {
                    text: 'Редактировать',
                    className: 'btn-primary',
                    action: function ( e, dt, node, config ) {
                        Cities.edit(selectedCityId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'cityEditButton'
                    }
                },
                {
                    text: 'Удалить',
                    className: 'btn-danger',
                    action: function ( e, dt, node, config ) {
                        Cities.delete(selectedCityId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'cityDeleteButton'
                    }
                },
            ]
        });
        if(table.page.info().recordsTotal == 0) {
            $('#cityEditButton').hide();
            $('#cityDeleteButton').hide();
        }

        $('#citiesTable tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#cityEditButton').prop('disabled', true);
                $('#cityDeleteButton').prop('disabled', true);
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#cityEditButton').prop('disabled', false);
                $('#cityDeleteButton').prop('disabled', false);
                selectedCityId = $(this).attr('id');
            }
        } );
    })
</script>