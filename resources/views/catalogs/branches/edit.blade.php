<form method="post" enctype="multipart/form-data" id="branchModalForm">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $branch->id }}">
    <div class="form-group row">
        <label for="code" class="col-sm-3 col-form-label">Код</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="code" name="code" value="{{ $branch->code }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="displayName" class="col-sm-3 col-form-label">Название</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="displayName" name="displayName" value="{{ $branch->displayName }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="status" class="col-sm-3 col-form-label">Статус</label>
        <div class="col-sm-9">
            <select name="status" id="status" class="form-control">
                <option value="{{ \App\Status::ACTIVE }}" @if( $branch->status == \App\Status::ACTIVE) selected="selected" @endif>{{ \App\Status::code(\App\Status::ACTIVE)->title}}</option>
                <option value="{{ \App\Status::INACTIVE }}" @if( $branch->status == \App\Status::INACTIVE) selected="selected" @endif>{{ \App\Status::code(\App\Status::INACTIVE)->title}}</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-9">
            <button class="btn btn-primary" onclick="Branches.submit(); return false;">Сохранить</button>
        </div>
    </div>
</form>