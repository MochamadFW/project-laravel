<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    public function get_all_warehouses()
    {
        try {
            $warehouseModel = Warehouse::with('assets')->get();

            if (count($warehouseModel) > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully fetched warehouses data',
                    'data' => $warehouseModel
                ])->setStatusCode(200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No warehouse data available',
                    'data' => null
                ])->setStatusCode(200);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ])->setStatusCode(422);
        } catch (QueryException $queryException) {
            return response()->json([
                'status' => false,
                'message' => 'Database Error: ' . $queryException->getMessage()
            ])->setStatusCode(500);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching assets: ' . $exception->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function get_by_id(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required'
            ]);
            $warehouseModel = Warehouse::with('assets')->find($request->id);

            if ($warehouseModel) {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully fetched warehouse data',
                    'data' => $warehouseModel
                ])->setStatusCode(200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Warehouse not found',
                    'data' => null
                ])->setStatusCode(404);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ])->setStatusCode(422);
        } catch (QueryException $queryException) {
            return response()->json([
                'status' => false,
                'message' => 'Database Error: ' . $queryException->getMessage()
            ])->setStatusCode(500);
        } catch (Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while fetching data warehouse by id: ' . $exception->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'location' => 'required',
                'person_in_charge' => 'nullable',
                'year_of_establishment' => 'nullable'
            ]);

            DB::beginTransaction();

            $warehouseModel = Warehouse::create([
                'name' => $request->name,
                'location' => $request->location,
                'person_in_charge' => $request->person_in_charge ?? null,
                'year_of_establishment' => $request->year_of_establishment ?? null
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'New warehouse created successfully!',
                'data' => $warehouseModel
            ])->setStatusCode(201);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ])->setStatusCode(422);
        } catch (QueryException $queryException) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Database Error: ' . $queryException->getMessage()
            ])->setStatusCode(500);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while creating new warehouse: ' . $exception->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'location' => 'required',
                'person_in_charge' => 'nullable',
                'year_of_establishment' => 'nullable'
            ]);

            DB::beginTransaction();

            $warehouseModel = Warehouse::find($id);

            if (!$warehouseModel) {
                return response()->json([
                    'status' => false,
                    'message' => 'Warehouse not found'
                ])->setStatusCode(404);
            }

            $warehouseModel->update([
                'name' => $request->name,
                'location' => $request->location,
                'person_in_charge' => $request->person_in_charge ?? null,
                'year_of_establishment' => $request->year_of_establishment ?? null
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Warehouse updated successfully!',
                'data' => $warehouseModel
            ])->setStatusCode(200);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->errors()
            ])->setStatusCode(422);
        } catch (QueryException $queryException) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Database Error: ' . $queryException->getMessage()
            ])->setStatusCode(500);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while updating warehouse: ' . $exception->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $warehouseModel = Warehouse::find($id);

            if (!$warehouseModel) {
                return response()->json([
                    'status' => false,
                    'message' => 'Warehouse not found'
                ])->setStatusCode(404);
            }

            $warehouseModel->delete();

            DB::commit(); 

            return response()->json([
                'status' => true,
                'message' => 'Warehouse deleted successfully!'
            ])->setStatusCode(200);

        } catch (QueryException $queryException) {
            DB::rollBack(); 
            return response()->json([
                'status' => false,
                'message' => 'Database Error: ' . $queryException->getMessage()
            ])->setStatusCode(500);
        } catch (Exception $exception) {
            DB::rollBack(); 
            return response()->json([
                'status' => false,
                'message' => 'An error occurred while deleting warehouse: ' . $exception->getMessage()
            ])->setStatusCode(500);
        }
    }
}
