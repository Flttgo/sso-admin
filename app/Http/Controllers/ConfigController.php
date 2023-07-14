<?php

namespace App\Http\Controllers;

class ConfigController extends Controller
{
    //
    public function index()
    {
        return $this->success([
            'risk_url' => config('app.risk_url'),
            'dmp_url' => config('app.dmp_url'),
            'job_url' => config('app.job_url'),
            'show_job' => user()->isSuperAdmin()
        ]);
    }
}
