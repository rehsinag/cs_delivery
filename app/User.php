<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setDataFromArray($data)
    {
        if(isset($data['id']) && trim($data['id']))
            $this->id = trim($data['id']);

        if(isset($data['login']) && trim($data['login']))
            $this->login = trim($data['login']);

        if(isset($data['password']) && trim($data['password']))
            $this->password = trim($data['password']);

        if(isset($data['email']) && trim($data['email']))
            $this->email = trim($data['email']);

        if(isset($data['name']) && trim($data['name']))
            $this->name = trim($data['name']);

        if(isset($data['role']) && trim($data['role']))
            $this->role = trim($data['role']);

        if(isset($data['branch']) && trim($data['branch']))
            $this->branch = trim($data['branch']);
    }

    public function validateData()
    {
        $errors = null;

        if(!$this->login || $this->login == null)
            $errors[] = 'Необходимо указать логин пользователя';

        if(!$this->id && (!$this->password || $this->password == null))
            $errors[] = 'Необходимо указать пароль пользователя';

        if(!$this->email || $this->email == null)
            $errors[] = 'Необходимо указать email пользователя';

        if(!$this->name || $this->name == null)
            $errors[] = 'Необходимо указать имя пользователя';

        if($this->role == UserRole::SUPERVISOR && (!$this->branch || $this->branch == null))
            $errors[] = 'Необходимо указать филиал пользователя';


        return $errors;
    }

    public function submitData()
    {
        $adminUser = new self();

        if($this->id)
            $adminUser = self::find($this->id);

        $adminUser->login           = $this->login;
        if($this->password)
            $adminUser->password        = bcrypt($this->password);
        $adminUser->email           = $this->email;
        $adminUser->name            = $this->name;

        $adminUser->syncRoles($this->role);

        $adminUser->save();

        if($this->role == UserRole::SUPERVISOR && $this->branch)
        {
            UserByBranch::updateOrCreate(
                [
                    'userId' => $adminUser->id,
                ],
                [
                    'branchId' => $this->branch
                ]
            );
        }
        else
        {
            UserByBranch::where('userId', $adminUser->id)->delete();
        }


        return $adminUser;
    }

    public function initBranch()
    {
        $userBranchId = UserByBranch::where('userId', $this->id)->first();

        if($userBranchId)
        {
            $this->branchObj = BranchCatalog::find($userBranchId->branchId);
        }
    }
}
