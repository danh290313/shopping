<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();

        return response()->json([
            'success' => true,
            'data' => $sizes
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:size,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $size = Size::create([
            'name' => $request->input('name')
        ]);

        return response()->json([
            'success' => true,
            'data' => $size
        ], 201);
    }

    public function show($id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json([
                'success' => false,
                'message' => 'Size not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $size
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:sizes,name,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $size = Size::find($id);

        if (!$size) {
            return response()->json([
                'success' => false,
                'message' => 'Size not found'
            ], 404);
        }

        $size->name = $request->input('name');
        $size->save();

        return response()->json([
            'success' => true,
            'data' => $size
        ]);
    }

    public function destroy($id)
    {
        $size = Size::find($id);

        if (!$size) {
            return response()->json([
                'success' => false,
                'message' => 'Size not found'
            ], 404);
        }

        $size->delete();

        return response()->json([
            'success' => true,
            'message' => 'Size deleted successfully'
        ]);
    }
}
