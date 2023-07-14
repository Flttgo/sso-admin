<?php

namespace App\Http\Controllers;

class ConfigController extends Controller
{
    //
    public function index()
    {
        return $this->success([
            'test1_url' => config('app.test1_url'),
            'test2_url' => config('app.test2_url'),
            'test3_url' => config('app.test3_url'),
            'show_job' => user()->isSuperAdmin()
        ]);
    }
}
