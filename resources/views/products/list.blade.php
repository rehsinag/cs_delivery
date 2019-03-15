<div class="d-flex-row">
    <button class="btn btn-secondary" onclick="Products.edit();">Добавить</button>
    <button class="btn btn-primary" disabled="disabled">Редактировать</button>
    <button class="btn btn-danger" disabled="disabled">Удалить</button>
    {{--<table class="table table-bordered" id="table">--}}
        {{--<thead>--}}
        {{--<tr>--}}
            {{--<th>1</th>--}}
            {{--<th>2</th>--}}
            {{--<th>3</th>--}}
        {{--</tr>--}}
        {{--</thead>--}}
        {{--<tbody>--}}
        {{--<tr>--}}
            {{--<td>1</td>--}}
            {{--<td>2</td>--}}
            {{--<td>3</td>--}}
        {{--</tr>--}}
        {{--</tbody>--}}
    {{--</table>--}}
</div>


<script>
    $(document).ready(function () {
        $('#table').DataTable();
    })
</script>