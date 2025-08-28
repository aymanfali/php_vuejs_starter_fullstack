<?php

namespace App\Http\Controllers\Dashboard;

use App\Core\APIController;
use App\Models\User;

class DashboardHomeController extends APIController
{
    function index()
    {
        $users = (new User())->countUsers();

        $this->jsonResponse([
            'users' => $users,
        ], 200);
    }
}
