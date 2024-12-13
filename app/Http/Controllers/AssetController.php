<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function get_all_assets()
    {
        try {
            $assetModel = Asset::with('warehouses')->get();

            if (count($assetModel) > 0) {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully fetched assets data',
                    'data' => $assetModel
                ])->setStatusCode(200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'No asset data available',
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
            $assetModel = Asset::with('warehouses')->find($request->id);

            if ($assetModel) {
                return response()->json([
                    'status' => true,
                    'message' => 'Successfully fetched asset data',
                    'data' => $assetModel
                ])->setStatusCode(200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Asset not found',
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
                'message' => 'An error occurred while fetching data asset by id: ' . $exception->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'purchase_price' => 'required|numeric',
                'devaluation_percentage' => 'nullable|integer',
                'warehouse_id' => 'required|exists:warehouses,id',
            ]);

            DB::beginTransaction();

            $assetModel = Asset::create([
                'name' => $request->name,
                'purchase_price' => $request->purchase_price,
                'devaluation_percentage' => $request->devaluation_percentage ?? null,
                'warehouse_id' => $request->warehouse_id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'New asset created successfully!',
                'data' => $assetModel
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
                'message' => 'An error occurred while creating new asset: ' . $exception->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
                'purchase_price' => 'required|numeric',
                'devaluation_percentage' => 'nullable|integer',
                'warehouse_id' => 'required|exists:warehouses,id',
            ]);

            DB::beginTransaction();

            $assetModel = Asset::find($id);

            if (!$assetModel) {
                return response()->json([
                    'status' => false,
                    'message' => 'Asset not found'
                ])->setStatusCode(404);
            }

            $assetModel->update([
                'name' => $request->name,
                'purchase_price' => $request->purchase_price,
                'devaluation_percentage' => $request->devaluation_percentage ?? null,
                'warehouse_id' => $request->warehouse_id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Asset updated successfully!',
                'data' => $assetModel
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
                'message' => 'An error occurred while updating asset: ' . $exception->getMessage()
            ])->setStatusCode(500);
        }
    }

    public function delete($id)
    {
        try {
            DB::beginTransaction();

            $assetModel = Asset::find($id);

            if (!$assetModel) {
                return response()->json([
                    'status' => false,
                    'message' => 'Asset not found'
                ])->setStatusCode(404);
            }

            $assetModel->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Asset deleted successfully!'
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
                'message' => 'An error occurred while deleting asset: ' . $exception->getMessage()
            ])->setStatusCode(500);
        }
    }
}
