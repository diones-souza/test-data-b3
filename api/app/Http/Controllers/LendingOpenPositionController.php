<?php

namespace App\Http\Controllers;

use App\Services\LendingOpenPositionService;
use Illuminate\Http\Request;

class LendingOpenPositionController extends Controller
{
    private $service;

    public function __construct(LendingOpenPositionService $service)
    {
        $this->service = $service;
    }

    public function getPapers(Request $request)
    {
        try {
            return $this->service->getPapers($request->all());
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
