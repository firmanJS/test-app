<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\OrderHistory;
use DB;
use App\Inventory;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request, $order_code)
    {
        try {
            $query = 
                DB::table('orders')->where('orders.order_code',$order_code)
                ->join('order_histories', 'orders.histories_code', '=', 'order_histories.code_histories')
                ->join('inventories', 'inventories.id', '=', 'order_histories.inventory_id')
                ->join('items', 'items.id', '=', 'inventories.item_id')
                ->select(
                    'orders.order_code', 
                    'order_histories.id as histories_id', 
                    'order_histories.code_histories',  
                    'order_histories.qty', 
                    'order_histories.status', 
                    'order_histories.total', 
                    'items.id as items_id',
                    'items.name','items.price'
                );
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Get order not sucessfuly',
                'data' =>  $e->getMessage()
            ], 400);
        }
        return response()->json([
            'message' => 'Get order sucessfuly',
            'data' => $query->get()
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'code_histories' => 'required|string|max:100',
                'inventory_id' => 'required|integer',
                'qty' => 'required|integer',
                'status' =>  'required|string',
                'total' => 'required|integer',
            ]);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }

            $validationQty = $this->checkQtyBooked($request);
            if($validationQty === 'return'){
                $store = OrderHistory::create([
                    'code_histories' => $request->code_histories,
                    'inventory_id' => $request->inventory_id,
                    'qty' => $request->qty,
                    'status' => $request->status,
                    'total' => $request->total
                ]);
    
                // updated stock if booked 
                $checkStock = Inventory::findOrFail($request->inventory_id);
                $updated = [
                    'stock_reserved' => $checkStock->stock_reserved + $request->qty,
                    'stock_available' => $checkStock->stock_available - $request->qty
                ];
                $checkStock->fill($updated);
                $checkStock->save();
                return response()->json([
                    'message' => 'Order created',
                    'data' => $store
                ], 200);
            }else{
                return response()->json([
                    'message' => 'Order failed',
                    'data' => $validationQty
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Order failed created',
                'data' =>  $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validationQty = $this->checkQtyBooked($request);
            if($validationQty === 'return'){
                $model = OrderHistory::findOrFail($id);
                $model->fill($request->input());
                $model->save();
    
                // restore stock
                $checkStock = Inventory::findOrFail($request->inventory_id);
                $restored = [
                    'stock_reserved' => $checkStock->stock_reserved - $request->old_qty,
                    'stock_available' => $checkStock->stock_available + $request->old_qty
                ];
                $checkStock->fill($restored);
                $checkStock->save();
    
                // booked new stock
                $checkStockUpdated = Inventory::findOrFail($request->inventory_id);
                $updated = [
                    'stock_reserved' => $checkStockUpdated->stock_reserved + $request->qty,
                    'stock_available' => $checkStockUpdated->stock_available - $request->qty
                ];
                $checkStockUpdated->fill($updated);
                $checkStockUpdated->save();
                
                return response()->json([
                    'message' => 'Update data sucessfuly',
                    'data' => $model
                ], 200);
            }else{
                return response()->json([
                    'message' => 'Order failed',
                    'data' => $validationQty
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Update data unsucessfuly',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            // updated stock if cancel booked 
            $checkStock = Inventory::findOrFail($request->inventory_id);
            $deleted = [
                'stock_reserved' => $checkStock->stock_reserved - $request->qty,
                'stock_available' => $checkStock->stock_available + $request->qty
            ];
            $checkStock->fill($deleted);
            $checkStock->save();

            $model = OrderHistory::findOrFail($id);
            $model->delete();
            return response()->json([
                'message' => 'Delete data sucessfuly',
                'data' => $model
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Delete data unsucessfuly',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function checkout(Request $request, $code_histories)
    {
        try {
            $validator = Validator::make($request->all(), [
                'order_code' => 'required|string',
                'total' => 'required|integer',
            ]);

            $checkout = Order::create([
                'histories_code' => $code_histories,
                'order_code' => $request->order_code,
                'total' => $request->total,
            ]);

            // updated status order history to complete
            OrderHistory::where('code_histories',$code_histories)->update(['status' => 'complete']);

            return response()->json([
                'message' => 'Order created',
                'data' => $checkout
            ], 200);

            if($validator->fails()){
                return response()->json($validator->errors(), 422);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Update data unsucessfuly',
                'data' => $e->getMessage()
            ], 500);
        }
    }

    public function checkQtyBooked($request){
        $checkStock = Inventory::findOrFail($request->inventory_id);
        $check = $request->qty > $checkStock->stock_available ? "can't order more than stock" : "return";
        return $check;
    }

}
