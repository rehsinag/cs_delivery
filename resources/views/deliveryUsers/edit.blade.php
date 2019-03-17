<form method="post" enctype="multipart/form-data" id="deliveryUserModalForm">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $deliveryUser->id }}">
    <div class="form-group row">
        <label for="companyId" class="col-sm-3 col-form-label">Компания</label>
        <div class="col-sm-9">
            @if(isset($deliveryCompanies) && count($deliveryCompanies))
            <select name="companyId" id="companyId" class="form-control">
                @foreach($deliveryCompanies as $deliveryCompany)
                <option value="{{ $deliveryCompany->id }}" @if( $deliveryUser->companyId == $deliveryCompany->id) selected="selected" @endif>{{ $deliveryCompany->displayName}}</option>
                @endforeach
            </select>
            @else
            <small>
                Не найдены курьерские компании.
            </small>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label for="login" class="col-sm-3 col-form-label">Логин</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="login" name="login" value="{{ $deliveryUser->login }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-3 col-form-label">Пароль</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password" name="password" value="{{ $deliveryUser->password }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-3 col-form-label">Подтверждение пароля</label>
        <div class="col-sm-9">
            <input type="password" class="form-control" id="password2" name="password" value="{{ $deliveryUser->password }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">Email</label>
        <div class="col-sm-9">
            <input type="email" class="form-control" id="email" name="email" value="{{ $deliveryUser->email }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="firstName" class="col-sm-3 col-form-label">Имя</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="firstName" name="firstName" value="{{ $deliveryUser->firstName }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="lastName" class="col-sm-3 col-form-label">Фамилия</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="lastName" name="lastName" value="{{ $deliveryUser->lastName }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="middleName" class="col-sm-3 col-form-label">Отчество</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="middleName" name="middleName" value="{{ $deliveryUser->middleName }}">
        </div>
    </div>
    <div class="form-group row">
        <label for="description" class="col-sm-3 col-form-label">Описание</label>
        <div class="col-sm-9">
            <textarea id="description" name="description" cols="30" rows="3" class="form-control">{{ $deliveryUser->description }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="status" class="col-sm-3 col-form-label">Роль</label>
        <div class="col-sm-9">
            <select name="role" id="role" class="form-control">
                @foreach(\App\DeliveryUserRole::all() as $role)
                <option value="{{ $role->code }}" @if( $deliveryUser->role == $role->code) selected="selected" @endif>{{ $role->title }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="status" class="col-sm-3 col-form-label">Статус</label>
        <div class="col-sm-9">
            <select name="status" id="status" class="form-control">
                <option value="{{ \App\Status::ACTIVE }}" @if( $deliveryUser->status == \App\Status::ACTIVE) selected="selected" @endif>{{ \App\Status::code(\App\Status::ACTIVE)->title}}</option>
                <option value="{{ \App\Status::INACTIVE }}" @if( $deliveryUser->status == \App\Status::INACTIVE) selected="selected" @endif>{{ \App\Status::code(\App\Status::INACTIVE)->title}}</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="branchId" class="col-sm-3 col-form-label">Филиал</label>
        <div class="col-sm-9">
            @if(isset($branches) && count($branches))
                <select name="branchId" id="branchId" class="form-control">
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" @if( $deliveryUser->branchId == $branch->id) selected="selected" @endif>{{ $branch->displayName}}</option>
                    @endforeach
                </select>
            @else
                <small>
                    Не найдены филиалы.
                </small>
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label for="loginAttemptsCount" class="col-sm-3 col-form-label">Попыток входа</label>
        <div class="col-sm-9">
            <input type="number" class="form-control" id="loginAttemptsCount" name="loginAttemptsCount" value="{{ $deliveryUser->loginAttemptsCount }}" min="0">
        </div>
    </div>
    <hr>
    <div class="form-group row">
        <div class="col-sm-9">
            <button class="btn btn-primary" onclick="DeliveryUsers.submit(); return false;">Сохранить</button>
        </div>
    </div>
</form>