<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class EmployeeController extends Controller
{
    public function index(Request $request) {
        try {
            $name = $request->get('name');
            $divisionId = $request->get('division_id');

            $employeeQuery = Employee::with('division');

            if ($name) {
                $employeeQuery->where('name', 'like', '%' . $name . '%');
            }

            if ($divisionId) {
                $employeeQuery->where('division_id', $divisionId);
            }

            $employeeData = $employeeQuery->paginate(10);

            $transformedData = $employeeData->map(function($employee) {
                return [
                    'id' => $employee->id,
                    'image' => $employee->image,
                    'name' => $employee->name,
                    'phone' => $employee->phone,
                    'division' => [
                        'id' => $employee->division->id,
                        'name' => $employee->division->name,
                    ],
                    'position' => $employee->position,
                ];
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Data fetched successfully',
                'data' => [
                    'employees' => $transformedData
                ],
                'pagination' => [
                    'total' => $employeeData->total(),
                    'per_page' => $employeeData->perPage(),
                    'current_page' => $employeeData->currentPage(),
                    'last_page' => $employeeData->lastPage(),
                    'from' => $employeeData->firstItem(),
                    'to' => $employeeData->lastItem(),
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

    public function store(Request $request) {
        try {
            $request->validate([
                'image' => 'required|image|max:1024|mimes:jpg,jpeg,png',
                'name' => 'required|string',
                'phone' => 'required|numeric|digits_between:10,12',
                'division' => 'required|numeric',
                'position' => 'required|string'
            ]);

            $imageUpload = $request->file('image');
            $imageName = $imageUpload->hashName();
            $imageUpload->move(public_path('image'), $imageName);

            $employeeNewData = [
                'image' => $imageName,
                'name' => $request->post('name'),
                'phone' => $request->post('phone'),
                'division_id' => $request->post('division'),
                'position' => $request->post('position')
            ];
    
            Employee::create($employeeNewData);

            return response()->json([
                'status' => 'success',
                'message' => 'Employee created successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create employee: ' . $e->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $id) {
        try {
            $request->validate([
                'name' => 'required|string',
                'phone' => 'required|numeric|digits_between:10,12',
                'division' => 'required|numeric',
                'position' => 'required|string'
            ]);
    
            $employeeData = Employee::where('id', $id)->first();
    
            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'required|image|max:1024|mimes:jpg,jpeg,png'
                ]);
    
                if ($employeeData->image) {
                    File::delete(public_path('image').'/'. $employeeData->image);
                }
    
                $imageUpload = $request->file('image');
                $imageName = $imageUpload->hashName();
                $imageUpload->move(public_path('image'), $imageName);
    
                $employeeData->update([
                    'image' => $imageName,
                ]);
            }
    
            $employeeData->update([
                'name' => $request->post('name'),
                'phone' => $request->post('phone'),
                'division_id' => $request->post('division'),
                'position' => $request->post('position'),
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Employee updated successfully',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to updated employee: ' . $e->getMessage(),
            ]);
        }
    }

    public function destroy($id) {
        $employeeData = Employee::where('id', $id)->first();

        if (!$employeeData) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to deleted employee'
            ]);
        }

        if ($employeeData->image) {
            File::delete(public_path('image').'/'. $employeeData->image);
        }

        $employeeData->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Employee deleted successfully'
        ]);
    }
}
