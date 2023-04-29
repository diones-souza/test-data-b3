<?php

namespace App\Http\Controllers;

use App\Models\LendingOpenPosition;

class LendingOpenPositionController extends Controller
{
    public function index()
    {
        $lendingOpenPositions = LendingOpenPosition::all();
        return response()->json($lendingOpenPositions);
    }

}
