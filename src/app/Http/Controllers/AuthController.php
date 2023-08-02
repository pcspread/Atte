<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * view表示
     * stamp.blade.php
     * @param void
     * @return view
     */
    public function index()
    {
        return view('stamp');
    }
}
