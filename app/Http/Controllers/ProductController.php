<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Responses\SuccessCollectionResponse;
use App\Http\Responses\SuccessEntityResponse;
use App\Http\Responses\ErrorResponse;
use App\Repositories\Interfaces\IProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class ProductController extends Controller
{
    protected $productRepo;
    
    public function __construct(IProductRepository $productRepo){
        return $this->productRepo = $productRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $rs = $this->productRepo->paginate($request['limit'] ?? 10)->toArray();
        return SuccessCollectionResponse::createResponse($rs,200);
       ;
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
        $rs = Product::create(['name'=>$request['name'], 'brand'=>$request['brand'], 
        'description'=>$request['description'], 'slug'=>$request['slug']]);
        return  SuccessEntityResponse::createResponse($rs,200);
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
        return SuccessEntityResponse::createResponse($product);
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
        $product = $this->productRepo->getById($id);
        if(!$product) throw new ModelNotFoundException('Product not found for id='.$id.'.');
        $credentials = $request->only(['name','brand','description','slug']);
        $product->update($credentials);
        return SuccessEntityResponse::createResponse($product);
      
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
