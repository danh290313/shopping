<?php
namespace App\Repositories\Implements;
use App\Repositories\Implements\BaseRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Models\Bank;
use Illuminate\Support\Facades\DB; 
class ProductRepository extends BaseRepository implements IProductRepository{
    protected $modelProduct;
    protected $modelProdctDetail;
    public function __construct($modelProduct,$modelProdctDetail){
        parent::__construct($modelProduct);
        $this->modelProduct = $modelProduct;
        $this->modelProdctDetail = $modelProdctDetail;
    }
    public function getAllProduct($data){
        if($data['includes'] && in_array('tag',$data['includes'])){
            $rs = $this->modelProduct->with('tags')->paginate($data['limit'] ?? 10)->toArray();
        }else{

            $rs = $this->modelProduct->paginate($data['limit'] ?? 10)->toArray();
        }
        return $rs;
    }
    public function createProduct($data){
        $product = DB::transaction(function () use ($data) {
            $product = $this->modelProduct->create(['name'=>$data['name'], 'brand'=>$data['brand'], 
            'description'=>$data['description'], 'slug'=>$data['slug']]);
            if(is_array($data['tags'])){
                foreach($data['tags'] as $tag){
                    $product->tags()->attach($tag['id']);
                }
            }
            return $product;
        });
        return $product;
    }
    public function updateProduct($data,$id){
        $product = $this->getById($id);
        if(!$product) throw new ModelNotFoundException('Product not found for id='.$id.'.');
        $product =  DB::transaction(function () use ($data,$product) {
            // $credentials = $data->only(['name','brand','description','slug']);
            $product->update($data);
            if(is_array($data['tags'])){
                $product->tags()->detach();
                foreach($data['tags'] as $tag){
                    $product->tags()->attach($tag['id']);
                }
            }
            return $product;
        });
        return $product;
    }
}
