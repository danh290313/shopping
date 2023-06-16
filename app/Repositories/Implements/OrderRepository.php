<?php
namespace App\Repositories\Implements;
use App\Repositories\Implements\BaseRepository;
use App\Repositories\Interfaces\IOrderRepository;
use Illuminate\Support\Facades\DB; 
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderRepository extends BaseRepository implements IOrderRepository{
    protected $orderModel, $userModel;

    public function __construct($orderModel, $userModel){
        parent::__construct($orderModel);
        $this->orderModel = $orderModel;
        $this->userModel = $userModel;
    }

    public function getAllOrder(){
        $orders = $this->orderModel->All();
        foreach($orders as $index => $order)
        {
            $orders[$index]['user'] = $this->userModel->find($orders[$index]['user_id']);
            unset($orders[$index]['user_id']);
        }
        return $orders;
    }
  
    public function createOrder($data){
        $order = DB::transaction(function () use ($data) {
            $order = $this->orderModel->create(['paid' => $data['paid'],'user_id' => $data['user_id'], 'status' => $data['status'],
                'shipped_at' => $data['shipped_at'],'created_at' => $data['created_at'],'updated_at' => $data['updated_at']]);
            
            foreach($data['order_details'] as $orderDetails)
            {
                $order->product_details()->attach(
                  $orderDetails['product_detail_id'],
                  [
                    'regular_price' => $orderDetails['regular_price'],
                    'sale_price' => $orderDetails['sale_price'],
                    'quantity' => $orderDetails['quantity'],
                    'review_id' => $orderDetails['review_id'] ?? null,
                  ]
                  );
            }    
          
            return $order;
        });
        $order->load('order_details');
        return $order;
    }
    
    public function updateOrder($data, $id){
        $order = $this->orderModel->find($id);
        if(!$order) throw new ModelNotFoundException('Order not found for id='.$id.'.');
        $order = DB::transaction(function () use ($data, $order) {
           
            $order->update($data);
            foreach($data['order_details'] as $orderDetails)
            {
                $order->product_details()->updateExistingPivot(
                  $orderDetails['product_detail_id'],
                  [
                    'regular_price' => $orderDetails['regular_price'],
                    'sale_price' => $orderDetails['sale_price'],
                    'quantity' => $orderDetails['quantity'],
                    'review_id' => $orderDetails['review_id'] ?? null,
                  ]
                  );
            }    
          
            return $order;
        });
        $order->load('order_details');
        return $order;
    }
}
