<?php

namespace App\Http\Controllers;

use App\Services\LendingOpenPositionService;
use Illuminate\Support\Facades\Validator;
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

    public function getPaperData(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'paper' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "statusCode" => 400,
                    "error" => $validator->errors()
                ]);
            }
            return $this->service->getPaperData($request->input('paper'));
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
