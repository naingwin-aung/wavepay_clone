<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('backend.admin.index');
    }

    public function userIndex()
    {
        return view('backend.user.index');
    }
}
