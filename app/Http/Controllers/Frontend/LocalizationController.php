<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class LocalizationController extends Controller
{
    public function setLang($lang)
    {
        App::setlocale($lang);
        Session::put('locale', $lang);
        return redirect()->route('user.home');
    }
}
