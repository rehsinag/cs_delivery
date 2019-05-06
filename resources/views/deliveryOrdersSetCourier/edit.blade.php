<form method="post" enctype="multipart/form-data" id="deliveryOrderModalForm">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $deliveryOrder->id }}">
    <div class="form-group row">
        <label for="deliveryUser" class="col-sm-3 col-form-label">Курьер</label>
        <div class="col-sm-9">
            @if(count($deliveryUsers))
            <select name="deliveryUser" id="deliveryUser" class="form-control">
                @foreach($deliveryUsers as $deliveryUser)
                    <option value="{{ $deliveryUser->id }}">{{ $deliveryUser->lastName }} {{ $deliveryUser->firstName }} {{ $deliveryUser->middleName }}</option>
                @endforeach
            </select>
            @else
                <h5>
                    Для начала необходимо добавить курьеров!
                </h5>
                <script>
                    $('#setCourierButton').attr('disabled', true);
                </script>
            @endif
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-9">
            <button id="setCourierButton" class="btn btn-primary" onclick="DeliveryOrders.submit(); return false;">Сохранить</button>
        </div>
    </div>
</form>