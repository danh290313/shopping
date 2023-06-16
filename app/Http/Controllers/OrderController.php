<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Responses\SuccessCollectionResponse;
use App\Http\Responses\SuccessEntityResponse;
use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\ISuccessCollectionResponse;
use App\Repositories\Interfaces\ISuccessEntityResponse;
use App\Repositories\Interfaces\IUserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PhpParser\Node\NullableType;

class OrderController extends Controller
{
    protected $orderRepo;
    protected $successCollectionResponse;
    protected $successEntityResponse;
    
    public function __construct(IOrderRepository $orderRepo,ISuccessCollectionResponse $successCollectionResponse,
    ISuccessEntityResponse $successEntityResponse){
        $this->orderRepo = $orderRepo;
        $this->successCollectionResponse = $successCollectionResponse;
        $this->successEntityResponse = $successEntityResponse;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $rs = $this->orderRepo->getAllOrder();
        return $this->successCollectionResponse->createResponse($rs,200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'paid' => 'boolean|required',
            'user_id' => 'int|exists:users,id',
            'status' => ['required', 'string', 'in:canceled,pending,shipping,shipped'],
            'shipped_at' => ['nullable'],
            'created_at' => ['nullable'],
            'updated_at' => ['nullable'],
            'order_details' => [
                'array',
                'min:1'
            ],
            'order_details.*.product_detail_id' => [
                'required',
            ],
            'order_details.*.quantity' => [
                'required',
                'numeric'
            ],
            'order_details.*.regular_price' => [
                'required',
            ],
            'order_details.*.sale_price' => [
                'required',
            ],
            'order_details.*.review_id' => ['nullable'],

        ]);
        if (!array_key_exists('review_id', $validated)) {
            $validated['review_id'] = null;
        }
        if (!array_key_exists('shipped_at', $validated)) {
          
            $validated['shipped_at'] = null;
        }
    
        if (!array_key_exists('created_at', $validated)) {
            
            $validated['created_at'] = null;
        }
      
        if (!array_key_exists('updated_at', $validated)) {
         
            $validated['updated_at'] = null;
        }
        $order = $this->orderRepo->createOrder($validated);
        return $this->successEntityResponse->createResponse($order, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      
        $validated = $request->validate([
            'paid' => 'boolean|required',
            'user_id' => 'int|exists:users,id',
            'status' => ['required', 'string', 'in:canceled,pending,shipping,shipped'],
            'shipped_at' => ['nullable'],
            'created_at' => ['nullable'],
            'updated_at' => ['nullable'],
            'order_details' => [
                'array',
                'min:1'
            ],
            'order_details.*.product_detail_id' => [
                'required',
            ],
            'order_details.*.quantity' => [
                'required',
                'numeric'
            ],
            'order_details.*.regular_price' => [
                'required',
            ],
            'order_details.*.sale_price' => [
                'required',
            ],
            'order_details.*.review_id' => ['nullable'],

        ]);
        if (!array_key_exists('review_id', $validated)) {
            $validated['review_id'] = null;
        }
        if (!array_key_exists('shipped_at', $validated)) {
          
            $validated['shipped_at'] = null;
        }
    
        if (!array_key_exists('created_at', $validated)) {
            
            $validated['created_at'] = null;
        }
      
        if (!array_key_exists('updated_at', $validated)) {
         
            $validated['updated_at'] = null;
        }
        $order = $this->orderRepo->updateOrder($validated, $id);
        return $this->successEntityResponse->createResponse($order, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
