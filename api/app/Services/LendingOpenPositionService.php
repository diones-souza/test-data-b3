<?php

namespace App\Services;

use App\Models\LendingOpenPosition;
use Illuminate\Support\Collection;

class LendingOpenPositionService
{
    public function getPapers(array $filter)
    {
        try {
            $search = $filter['search'] ?? null;

            $query = LendingOpenPosition::select('paper')->distinct();

            if ($search) {
                $query->where('paper', 'ilike', "%$search%");
            }

            $data = $query->paginate(10);

            $items = collect($data->items());
            $items = $items->map(function ($item) {
                return $item['paper'];
            });

            return response()->json([
                'data' => $items,
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getPaperData(string $paper)
    {
        try {
            $data = LendingOpenPosition::where('paper', $paper)->get();

            return response()->json($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
