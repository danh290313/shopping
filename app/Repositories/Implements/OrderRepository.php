<?php
namespace App\Repositories\Implements;
use App\Repositories\Implements\BaseRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Models\Order;
class OrderRepository extends BaseRepository implements IOrderRepository{
    protected $orderModel;

    public function __construct($orderModel){
        parent::__construct($orderModel);
        $this->orderModel = $orderModel;
    }
    public function updateById(array $data, $id){
        // $tag = $this->getById($id);
        // if(!$tag) throw new ModelNotFoundException('Tag not found for id='.$id.'.');
        // $tag = parent::updateById($data, $id);
        // return $tag;
    }
    public function createOrder($data){
        $order = DB::transaction(function () use ($data) {
            $order = $this->orderModel->create($data);
            // if(is_array($data['tags'])){
            //     foreach($data['tags'] as $tag){
            //         $order->tags()->attach($tag['id']);
            //     }
            // }
            return $order;
        });
        return $order;

    }
}
