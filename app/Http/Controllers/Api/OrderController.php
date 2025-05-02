<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            Log::error('[OrderController@index] Authenticated user not found.');
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 401);
        }

        $orders = $user->orders()->with('product')->get();

        return response()->json([
            'success' => true,
            'data' => $orders,
        ]);
    }

    /**
     * Store a newly created order in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error.',
                'errors'  => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!$user) {
            Log::error('[OrderController@store] Authenticated user not found.');
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 401);
        }

        $product = Product::findOrFail($request->product_id);
        $total   = $product->price * $request->quantity;

        $order = Order::create([
            'user_id'    => $user->id,
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity,
            'total'      => $total,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully.',
            'data'    => $order->load('product'),
        ], 201);
    }

    /**
     * Display the specified order.
     */
    public function show(Request $request, $id)
    {
        $user = $request->user();

        if (!$user) {
            Log::error('[OrderController@show] Authenticated user not found.');
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access.',
            ], 401);
        }

        $order = Order::where('id', $id)
                      ->where('user_id', $user->id)
                      ->with('product')
                      ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $order,
        ]);
    }

    /**
 * Remove the specified order from storage.
 */
public function destroy(Request $request, $id)
{
    $user = $request->user();

    if (!$user) {
        Log::error('[OrderController@destroy] Authenticated user not found.');
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized access.',
        ], 401);
    }

    $order = Order::where('id', $id)
                  ->where('user_id', $user->id)
                  ->first();

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'Order not found.',
        ], 404);
    }

    $order->delete();

    return response()->json([
        'success' => true,
        'message' => 'Order deleted successfully.',
    ]);
}
}
