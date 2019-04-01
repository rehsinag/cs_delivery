<form method="post" enctype="multipart/form-data" id="adminUserModalForm">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $adminUser->id }}">
    <div class="form-group row">
        <label for="login" class="col-sm-3 col-form-label">Логин</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="login" name="login" value="{{ $adminUser->login }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-3 col-form-label">Пароль</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password" name="password" value="{{ $adminUser->password }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-3 col-form-label">Подтверждение пароля</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password2" name="password" value="{{ $adminUser->password }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="email" name="email" value="{{ $adminUser->email }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">Имя</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="name" name="name" value="{{ $adminUser->name }}">
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-9">
            <button class="btn btn-primary" onclick="AdminUsers.submit(); return false;">Сохранить</button>
        </div>
    </div>
</form>