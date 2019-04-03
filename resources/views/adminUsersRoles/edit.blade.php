<form method="post" enctype="multipart/form-data" id="adminUsersRoleModalForm">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $adminUsersRole->id }}">
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Название</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="name" name="name" value="{{ $adminUsersRole->name }}">
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-9">
            <button class="btn btn-primary" onclick="AdminUsersRoles.submit(); return false;">Сохранить</button>
        </div>
    </div>
</form>