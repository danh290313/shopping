<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Responses\SuccessCollectionResponse;
use App\Http\Responses\SuccessEntityResponse;
use App\Http\Responses\ErrorResponse;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ITagRepository;
use App\Repositories\Interfaces\ISuccessCollectionResponse;
use App\Repositories\Interfaces\ISuccessEntityResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
class ProductController extends Controller
{
    protected $productRepo;
    protected $tagRepo;
    protected $successCollectionResponse;
    protected $successEntityResponse;
    
    public function __construct(IProductRepository $productRepo,ITagRepository $tagRepo,ISuccessCollectionResponse $successCollectionResponse,
    ISuccessEntityResponse $successEntityResponse){
        $this->productRepo = $productRepo;
        $this->tagRepo = $tagRepo;
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
        $validated = $request->validate([
            'includes' => 'array',
            'includes.*'=>'in:tag'
        ]);
        $rs = $this->productRepo->getAllProduct($request->all());
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
            'name' => 'required|max:200',
            'brand' => 'required|max:50',
            'description'=>'required',
            'slug'=>'required|max:255|unique:products',
            'tags'=>'array|min:1',
            'tags.*.id'=>'int|exists:tag,id'      
        ]);
        $rs = $this->productRepo->createProduct($request->all());
        return  $this->successEntityResponse->createResponse($products,200);
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
            'slug'=>'string|max:255|unique:products,slug,'.$id,
            'tags'=>'array|min:1',
            'tags.*.id'=>'int|exists:tags,id',      
            'product_details'=>'array|required',
            'product_details'
        ]);
        $product = $this->productRepo->updateProduct($request->all(),$id);
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
