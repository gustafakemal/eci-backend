<?php

namespace App\Http\Controllers;

use App\Models\SalaryLevel;

class SalaryLevelController extends Controller
{
    public function index()
    {
        $data = SalaryLevel::orderBy('gaji_min')->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }
}
