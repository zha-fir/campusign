<?php

namespace App\Http\Controllers\Operator;

use App\Http\Controllers\Controller;

class OperatorPageController extends Controller
{
    public function dashboard()
    {
        return view('operator.dashboard');
    }

    public function verifikasi()
    {
        return view('operator.verifikasi');
    }

    public function editor()
    {
        return view('operator.editor');
    }

    public function serahTerima()
    {
        return view('operator.serah-terima');
    }
}
