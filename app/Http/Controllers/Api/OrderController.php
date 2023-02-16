<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Order;
use App\Http\Resources\OrderResource;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id);

        if ($orders->count() == 0) {
            return $this->respondNotFound([
                'success' => false,
                'errors' => 'Orders Not Found!',
                'data' => null
            ]);
        }
        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => OrderResource::collection($orders->get())
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'amount' => 'required'
        ]);

        $order = new Order($request->all());
        $order->user_id = $request->user()->id;
        $order->save();
        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => new OrderResource($order)
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::where([['uuid', $id], ['user_id', $request->user()->id]])->first();
        if (empty($order)) {
            return $this->respond([
                'status' => false,
                'message' => 'Order Category Not Found',
                'data' =>  []
            ]);
        }

        $order->name = $request->name;
        $order->amount = $request->amount;
        $order->qty = $request->qty;
        $order->description = $request->description;
        $order->save();

        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => new OrderResource($order)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {

        if (empty($order)) {
            return $this->respondNotFound([
                'success' => false,
                'errors' => 'Order Not Found!',
                'data' => null
            ]);
        }

        $order->forceDelete();
        return $this->respond([
            'success' => true,
            'errors' => null,
            'data' => null
        ]);
    }
}
