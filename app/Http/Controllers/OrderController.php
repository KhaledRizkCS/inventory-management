<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;

class OrderController extends Controller
{

    public function __construct(
        private OrderService $orderService
    ) {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = $this->orderService->createOrder($request->validated());
        return response()->json($order, 201);
    }
}
