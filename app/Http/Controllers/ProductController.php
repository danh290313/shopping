<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Responses\SuccessCollectionResponse;
use App\Http\Responses\SuccessEntityResponse;
use App\Http\Responses\ErrorResponse;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ISuccessCollectionResponse;
use App\Repositories\Interfaces\ISuccessEntityResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class ProductController extends Controller
{
    protected $productRepo;
    protected $successCollectionResponse;
    protected $successEntityResponse;
    
    public function __construct(IProductRepository $productRepo,ISuccessCollectionResponse $successCollectionResponse,
    ISuccessEntityResponse $successEntityResponse){
        $this->productRepo = $productRepo;
        $this->successCollectionResponse = $successCollectionResponse;
        $this->successEntityResponse = $successEntityResponse;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rs = $this->productRepo->paginate($request['limit'] ?? 1)->toArray();
        $response = $this->successCollectionResponse->createResponse($rs, 200);
        return $response;
       
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
            'name' => 'required|max:200',
            'brand' => 'required|max:50',
            'description'=>'required',
            'slug'=>'required|max:255|unique:products'
        ]);
        $rs = $this->productRepo->create(['name'=>$request['name'], 'brand'=>$request['brand'], 
        'description'=>$request['description'], 'slug'=>$request['slug']]);
        return  $this->successEntityResponse->createResponse($rs,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $product = $this->productRepo->getById($id);
        if(!$product) throw new ModelNotFoundException('Product not found for id='.$id.'.');
        return $this->successEntityResponse->createResponse($product);
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
            'name' => 'string|max:200',
            'brand' => 'string|max:50',
            'description'=>'string',
            'slug'=>'string|max:255|unique:products,slug,'.$id
        ]);
        $product = $this->productRepo->getById($id);
        if(!$product) throw new ModelNotFoundException('Product not found for id='.$id.'.');
        $credentials = $request->only(['name','brand','description','slug']);
        $product->update($credentials);
        return $this->successEntityResponse->createResponse($product);
      
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = $this->productRepo->getById($id);
        if(!$product) throw new ModelNotFoundException('Product not found for id='.$id.'.');
        $product->delete();
        return response()->json(["result"=> "ok"]);
    }
    public function restoreAll(){
        $product = $this->productRepo->restoreAll();
        return response()->json(["result"=> "ok"]);
    }
}
