<form method="post" enctype="multipart/form-data" id="productModalForm">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $product->id }}">
    <div class="form-group row">
        <label for="code" class="col-sm-3 col-form-label">Код продукта</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="code" name="code" value="{{ $product->code }}" autofocus>
        </div>
    </div>
    <div class="form-group row">
        <label for="displayName" class="col-sm-3 col-form-label">Наименование</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="displayName" name="displayName" value="{{ $product->displayName }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="description" class="col-sm-3 col-form-label">Описание</label>
        <div class="col-sm-9">
            <textarea id="description" name="description" cols="30" rows="3" class="form-control">{{ $product->description }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="status" class="col-sm-3 col-form-label">Статус</label>
        <div class="col-sm-9">
            <select name="status" id="status" class="form-control">
                <option value="{{ \App\Status::ACTIVE }}" @if( $product->status == \App\Status::ACTIVE) selected="selected" @endif>{{ \App\Status::code(\App\Status::ACTIVE)->title}}</option>
                <option value="{{ \App\Status::INACTIVE }}" @if( $product->status == \App\Status::INACTIVE) selected="selected" @endif>{{ \App\Status::code(\App\Status::INACTIVE)->title}}</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-9">
            <button class="btn btn-primary" onclick="Products.submit(); return false;">Сохранить</button>
        </div>
    </div>
</form>