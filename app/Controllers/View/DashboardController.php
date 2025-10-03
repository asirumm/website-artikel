<?php

namespace App\Controllers\View;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view("dashboard/index");
    }
}