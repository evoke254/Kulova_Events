<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function buyTicket(Request $request, Event $event)
    {
        return view('buy-tickets', compact('event'));

    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }


    public function stkPushCallback(Request $request)
    {
        $data = $request->json()->all(); // Get request body as an array
        Log::info(json_encode($data));
        try {
            // Validate required fields
            $this->validate($request, [
                'Body.stkCallback.ResultCode' => 'required|integer',
                'Body.stkCallback.CheckoutRequestID' => 'required|string',
            ]);

            // Extract relevant data
            $resultCode = $data['Body']['stkCallback']['ResultCode'];
            $resultDesc = $data['Body']['stkCallback']['ResultDesc'];
            $checkoutRequestId = $data['Body']['stkCallback']['CheckoutRequestID'];
            $merchantRequestId = $data['Body']['stkCallback']['MerchantRequestID'];

            // Find the matching order by CheckoutRequestID
            $order = Order::where('CheckoutRequestID', $checkoutRequestId)
                ->where('MerchantRequestID', $merchantRequestId)
                ->first();

            if (!$order) {
                Log::error("Order not found for CheckoutRequestID: $checkoutRequestId");
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Update order based on ResultCode
            if ($resultCode === 0) {
                $order->status = 'PAYMENT SUCCESSFUL - ' . $resultDesc ;
                $message = 'Payment successful.';
            } else {
                $order->status = 'PAYMENT ERROR - ' . $resultDesc;
                $message = "Payment failed (ResultCode: $resultCode)";
            }
            $order->save();

            // Log the response for reference
            Log::info("STK Push callback: $message - Order ID: {$order->id}");

            return response()->json(['message' => $message]);

        } catch (\Exception $e) {
            Log::error("Error processing STK Push callback: " . $e->getMessage());
            return response()->json(['message' => 'Error processing request'], 500);
        }
    }

}
