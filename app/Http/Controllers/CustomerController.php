<?php

namespace App\Http\Controllers;

use App\RMVC\View\View;

class CustomerController
{
    public function index()
    {
        return View::view('customer.index');
    }
}
