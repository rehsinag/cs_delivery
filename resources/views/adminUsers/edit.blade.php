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
            <input type="password" class="form-control" id="password" name="password" value="">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-3 col-form-label">Подтверждение пароля</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password2" name="password" value="">
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
    <div class="form-group row">
        <label for="role" class="col-sm-3 col-form-label">Роль</label>
        <div class="col-sm-9">
            <select name="role" id="role" class="form-control">
                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                    <option value="{{ $role->name }}" @if($adminUser->hasRole($role->name)) selected="selected" @endif>{{ $role->displayName }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row supervisorBranch">
        <label for="branch" class="col-sm-3 col-form-label">Филиал</label>
        <div class="col-sm-9">
            <select name="branch" id="branch" class="form-control">
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" @if($adminUser->branchObj && $adminUser->branchObj->id == $branch->id) selected="selected" @endif>{{ $branch->displayName }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-9">
            <button class="btn btn-primary" onclick="AdminUsers.submit(); return false;">Сохранить</button>
        </div>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('.supervisorBranch').hide();

        @if( $adminUser->hasRole('supervisor')  )
            $('.supervisorBranch').show();
        @endif

        $('#role').change(function () {
            if(this.value == 'supervisor')
                $('.supervisorBranch').show();
            else
                $('.supervisorBranch').hide();
        });
    })
</script>