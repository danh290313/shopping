<?php
namespace App\Repositories\Implements;
use App\Repositories\Implements\BaseRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\IPictureRepository;
use Illuminate\Support\Facades\DB; 
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Exceptions\CustomException\UnprocessaleContent;
class ProductRepository extends BaseRepository implements IProductRepository{
    protected $modelProduct;
    protected $modelProdctDetail;
    protected $modelPicture;
    public function __construct($modelProduct,$modelProdctDetail,$modelPicture){
        parent::__construct($modelProduct);
        $this->modelProduct = $modelProduct;
        $this->modelProdctDetail = $modelProdctDetail;
        $this->modelPicture = $modelPicture;
    }
    public function getAllProduct($data){
        if(array_key_exists('includes',$data)){
            $includes = [];
          foreach($data['includes'] as $include){
            switch($include){
                case 'all':
                    array_push($includes,'tags','details.color','details.picture','pictures');
                    break 2;
                case 'tag':
                   array_push($includes,'tags');
                   break;
                case 'detail':
                    array_push($includes,'details.color','details.picture');
                    break;
                case 'picture':
                    array_push($includes,'pictures');
                    break;
            }
          }
            $rs = $this->modelProduct->with($includes)->paginate($data['limit'] ?? 10)->toArray();
        }else{

            $rs = $this->modelProduct->paginate($data['limit'] ?? 10)->toArray();
        }
    
        // $rs = $this->modelProdctDetail->with('color')->paginate($data['limit'] ?? 10)->toArray();
        return $rs;
    }
    public function createProduct($data){
        $product = DB::transaction(function () use ($data) {
            $product = $this->modelProduct->create(['name'=>$data['name'], 'brand'=>$data['brand'], 
            'description'=>$data['description'], 'slug'=>$data['slug']]);
            if(array_key_exists('tags',$data)){
                foreach($data['tags'] as $tag){
                    $product->tags()->attach($tag['id']);
                }
            }
            foreach($data['colors'] as $color){
                if(!array_key_exists($color['picture']-1,$data['pictures'])) 
                    throw new UnprocessaleContent('image with index '.$color['picture'].' not exist in uploaded pictures');
                // $uploadedFileUrl = Cloudinary::upload($color('picture')->getRealPath())->getSecurePath();
                $result =$data['pictures'][$color['picture']-1] ->storeOnCloudinary('digitic');
                $uploadedFileUrl = $result->getSecurePath(); 
                $picture = $this->modelPicture->create(['source'=>$uploadedFileUrl,'product_id'=>$product->id]);
                $product->colors()->attach($color['id'], 
                [
                    'picture_id' => $picture->id,
                    'regular_price' => $color['regular_price'],
                    'active' => $color['active'],
                    'quantity' => $color['quantity'],
                ]);
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
            if(array_key_exists('tags',$data)){
                $product->tags()->detach();
                foreach($data['tags'] as $tag){
                    $product->tags()->attach($tag['id']);
                }
            }
            foreach($data['pictures']->add as  $picture_id){

            }

            foreach($data['colors'] as $color){
                if(!array_key_exists($color['picture']-1,$data['pictures'])) 
                    throw new UnprocessaleContent('image with index '.$color['picture'].' not exist in uploaded pictures');
                // $uploadedFileUrl = Cloudinary::upload($color('picture')->getRealPath())->getSecurePath();
                $result =$data['pictures'][$color['picture']-1] ->storeOnCloudinary('digitic');
                $uploadedFileUrl = $result->getSecurePath(); 
                $picture = $this->modelPicture->create(['source'=>$uploadedFileUrl,'product_id'=>$product->id]);
                $product->colors()->attach($color['id'], 
                [
                    'picture_id' => $picture->id,
                    'regular_price' => $color['regular_price'],
                    'active' => $color['active'],
                    'quantity' => $color['quantity'],
                ]);
            }

            return $product;
        });
        return $product;
    }
}
