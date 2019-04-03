<form method="post" enctype="multipart/form-data" id="deliveryOrderModalForm">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $deliveryOrder->id }}">
    <div class="form-group row">
        <label for="city" class="col-sm-3 col-form-label">Город</label>
        <div class="col-sm-9">
            <select name="city" id="city" class="form-control">
                @foreach($cities as $city)
                <option value="{{ $city->id }}" @if( $deliveryOrder->city == $city->id) selected="selected" @endif>{{ $city->displayName }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="county" class="col-sm-3 col-form-label">Район</label>
        <div class="col-sm-9">
            <select name="county" id="county" class="form-control">
                @foreach($counties as $county)
                    <option value="{{ $county->id }}" @if( $deliveryOrder->county == $county->id) selected="selected" @endif>{{ $county->displayName }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="street" class="col-sm-3 col-form-label">Улица</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="street" name="street" value="{{ $deliveryOrder->street }}" autofocus>
        </div>
    </div>
    <div class="form-group row">
        <label for="house" class="col-sm-3 col-form-label">Дом</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="house" name="house" value="{{ $deliveryOrder->house }}" autofocus>
        </div>
    </div>
    <div class="form-group row">
        <label for="apartment" class="col-sm-3 col-form-label">Квартира</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="apartment" name="apartment" value="{{ $deliveryOrder->apartment }}" autofocus>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-9">
            <button class="btn btn-primary" onclick="DeliveryOrders.submit(); return false;">Сохранить</button>
        </div>
    </div>
</form>