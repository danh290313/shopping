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
use App\Exceptions\CustomException\UnprocessaleContents;
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
            'includes.*'=>'in:tag,detail,all,picture'
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
            'tags.*.id'=>'int|exists:tag,id',
            'pictures' => 'required|min:1|array',      
            'pictures.*' => 'image',     
            'colors'=> 'required|array',
            'colors.*.id' => 'int|required|exists:colors,id|distinct',            
            'colors.*.picture' => 'int|required|distinct',
            'colors.*.regular_price' => 'decimal:2|required',
            'colors.*.quantity' => 'int|required',
            'colors.*.active' => 'boolean|required',
        ]);
        $rs = $this->productRepo->createProduct($request->all());
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
            'slug'=>'string|max:255|unique:products,slug,'.$id,
            'tags'=>'array',
            'tags.*.id'=>'int|exists:tags,id', 
            'pictures' => 'array',      
            'pictures.*' => 'int|exists:pictures,id', //picture_id , user call api add picture and pass id here when add new pictures
            'colors'=> 'array',
            'colors.*.id' => 'int|required|exists:colors,id|distinct',            
            'colors.*.picture_id' => 'int|min:0|distinct',
            'colors.*.regular_price' => 'decimal:2',
            'colors.*.quantity' => 'int',
            'colors.*.active' => 'boolean',
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
