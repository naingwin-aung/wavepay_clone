<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function setting()
    {
        return view('frontend.settings');
    }

    public function changeLanguage()
    {
        return view('frontend.changeLanguage');
    }
}
