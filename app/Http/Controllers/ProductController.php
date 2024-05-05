<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function addItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
            'manufactorer' => 'required|string',
            'expiry_date' => 'required|date',
            'unit_price' => 'required|numeric',
            'available_quantity' => 'required|integer',
            'minimum_quantity' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        try {
            $medicine = new Product();

            $medicine->name = $request->input('name');
            $medicine->description = $request->input('description');
            $medicine->category = $request->input('category');
            $medicine->manufactorer = $request->input('manufactorer');
            $medicine->expiry_date = $request->input('expiry_date');
            $medicine->unit_price = $request->input('unit_price');
            $medicine->available_quantity = $request->input('available_quantity');
            $medicine->minimum_quantity = $request->input('minimum_quantity');

            $medicine->save();
            return response()->json($medicine);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
        
    }

    public function removeItem($id)
    {
        $item = Product::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item removed successfully']);
    }

    public function editItem(Request $request, $id)
    {
        $item = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'expiry_date' => 'required|date',
            'unit_price' => 'required|numeric|min:0',
            'available_quantity' => 'required|integer|min:0',
            'minimum_quantity' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $item->update($request->all());

        return response()->json($item);
    }
}
