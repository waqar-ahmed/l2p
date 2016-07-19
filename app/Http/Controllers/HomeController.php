<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;


use View;

class HomeController extends BaseController
{
    public function index()
    {
    	return View::make('app');
    }
}