<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Spatie\Permission\Models\Role;

class AdminUsersRolesController extends Controller
{
    public function index()
    {
        return view('adminUsersRoles.index');
    }

    public function pList()
    {
        $params = Input::all();

        $adminUsersRoles = Role::all();

//        if(count($adminUsers))
//        {
//            foreach ($deliveryUsers as $deliveryUser)
//            {
//                $deliveryUser->init();
//            }
//        }

        return view('adminUsersRoles.list', [
            'adminUsersRoles' => $adminUsersRoles
        ]);
    }

    public function editForm()
    {
        $adminUsersRoleId = Input::get('adminUsersRoleId');

        $adminUsersRole = new Role();
        if($adminUsersRoleId)
        {
            $adminUsersRole = Role::find($adminUsersRoleId);
        }

//        $deliveryCompanies = DeliveryCompany::getCollection(['actual' => 1])->get();
//
//        $branches = Branch::getCollection(['actual' => 1])->get();

        return view('adminUsersRoles.edit', [
            'adminUsersRole' => $adminUsersRole,
//            'deliveryCompanies' => $deliveryCompanies,
//            'branches' => $branches
        ]);
    }

    public function submitForm()
    {
        $adminUsersRoleData = Input::all();

        $successMessage = $adminUsersRoleData['id'] ? 'Роль была успешно обновлена.' : 'Роль была успешно добавлена.';

        if(!isset($adminUsersRoleData['name']) || $adminUsersRoleData['name'] == null)
        {
            return response()->json([
                'success' => false,
                'message' => 'Необходимо указать название роли'
            ]);
        }
        else
        {
            $adminUsersRole = new Role();

            if($adminUsersRoleData['id'])
                $adminUsersRole = Role::findById($adminUsersRoleData['id']);

            $adminUsersRole->name           = trim($adminUsersRoleData['name']);
            $adminUsersRole->displayName    = trim($adminUsersRoleData['displayName']);
            $adminUsersRole->guard_name     = 'web';

            if($adminUsersRole->save())
            {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }
        }
    }
}
