<div class="d-flex-row">
    <table class="table table-bordered table-hover" id="productsTable">
        <thead>
        <tr>
            <th>Код продукта</th>
            <th>Наименование</th>
            <th>Описание</th>
            <th>Статус</th>
        </tr>
        </thead>
        <tbody>
        @if(count($products))
            @foreach($products as $product)
                <tr id="{{ $product->id }}">
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->displayName }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ \App\Status::code($product->status)->title }}</td>
                </tr>
            @endforeach
        @else
        @endif
        </tbody>
    </table>
</div>


<script>
    $(document).ready(function () {
        var selectedProductId;
        var table = $('#productsTable').DataTable({
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
                        Products.edit();
                    }
                },
                {
                    text: 'Редактировать',
                    className: 'btn-primary',
                    action: function ( e, dt, node, config ) {
                        Products.edit(selectedProductId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'productEditButton'
                    }
                },
                {
                    text: 'Удалить',
                    className: 'btn-danger',
                    action: function ( e, dt, node, config ) {
                        Products.delete(selectedProductId);
                    },
                    init: function(api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).prop('disabled', 'true');
                    },
                    attr: {
                        id: 'productDeleteButton'
                    }
                },
            ]
        });
        if(table.page.info().recordsTotal == 0) {
            $('#productEditButton').hide();
            $('#productDeleteButton').hide();
        }

        $('#productsTable tbody').on( 'click', 'tr', function () {
            if ( $(this).hasClass('selected') ) {
                $(this).removeClass('selected');
                $('#productEditButton').prop('disabled', true);
                $('#productDeleteButton').prop('disabled', true);
            }
            else {
                table.$('tr.selected').removeClass('selected');
                $(this).addClass('selected');
                $('#productEditButton').prop('disabled', false);
                $('#productDeleteButton').prop('disabled', false);
                selectedProductId = $(this).attr('id');
            }
        } );
    })
</script>