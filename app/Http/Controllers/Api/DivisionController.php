<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Exception;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index(Request $request) {
        try {
            $name = $request->get('name');

            if ($name) {
                $divisionData = Division::where('name', 'like', '%' . $name . '%')->paginate(10);
            } else {
                $divisionData = Division::paginate(10);
            }

            $tranformedData = $divisionData->map(function($division) {
                return [
                    'id' => $division->id,
                    'name' => $division->name
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully',
                'data' => [
                    'divisions' => $tranformedData
                ],
                'pagination' => [
                    'total' => $divisionData->total(),
                    'per_page' => $divisionData->perPage(),
                    'current_page' => $divisionData->currentPage(),
                    'last_page' => $divisionData->lastPage(),
                    'from' => $divisionData->firstItem(),
                    'to' => $divisionData->lastItem(),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch data',
                'data' => null,
                'pagination' => null,
            ]);
        }
    }
}
