<?php
namespace App\Repositories\Implements;
use App\Repositories\Implements\BaseRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\IPictureRepository;
use Illuminate\Support\Facades\DB; 
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Exceptions\CustomException\UnprocessableContent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Models\Sale;
use App\Models\OrderDetail;
use App\Models\ProductDetail;
use App\Models\Color;
use App\Http\Resources\ProductResource;
// use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder;
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
        $rs = $this->modelProduct;
        if(array_key_exists('sort_by',$data)) {
            switch($data['sort_by']){
                case 'best_selling':
                    $rs = $rs->orderByDesc(ProductDetail::selectRaw('sum(product_details.quantity)')
                    ->join('order_details','product_details.id','=','order_details.product_detail_id')
                    ->whereColumn('product_details.product_id','products.id')->groupBy('products.id'));
                    break;
                case 'title_ascending':
                    $rs = $rs->orderBy('products.name');
                    break;
                case 'title_descending':
                    $rs = $rs->orderByDesc('products.name');
                    break;
                case 'price_ascending':
                    $rs = $rs->orderBy(ProductDetail::select('regular_price')
                    ->whereColumn('products.id','product_details.product_id')->limit(1));
                    break;
                case 'price_descending':
                    $rs = $rs->orderByDesc(ProductDetail::select('regular_price')
                    ->whereColumn('products.id','product_details.product_id')->limit(1));
                    break;
                case 'created_ascending':
                    $rs = $rs->orderBy('products.created_at');
                    break;
                case 'created_descending':
                    $rs = $rs->orderByDesc('products.created_at');
                    break;
            }
        };
        if(array_key_exists('avalibylities',$data)){
            $rs = $rs->whereExists(function($query) use($data){
                        $query->select('products.id')->from('product_details')
                        ->whereColumn('products.id','product_details.product_id')
                        ->where(function($query) use ($data) {
                            foreach($data['avalibylities'] as $avai){
                                $query->orWhere('product_details.active',$avai);
                            };
                        });
            });
        }
        if(array_key_exists('colors',$data)){
           $rs = $rs->whereExists(function($query) use($data){
                $query->from('product_details')->join('colors','product_details.color_id','colors.id')
                ->whereColumn('products.id','product_details.product_id')
                ->where(function($query) use ($data) {
                    foreach($data['colors'] as $color){
                        $query->orWhere('colors.hex_value',$color);
                    }
                });
           });
        }
        if(array_key_exists('sizes',$data)){
            $rs = $rs->whereExists(function($query) use($data){
                $query->from('sizes')->whereColumn('sizes.product_id','products.id')
                ->where(function($query) use ($data) {
                    foreach($data['sizes'] as $size){
                        $query->orWhere('sizes.name',$size);
                    };
                });
            });
         }
         if(array_key_exists('tags',$data)){
            $rs = $rs->whereExists(function($query) use($data){
                $query->from('product_tags')->whereColumn('product_tags.product_id','products.id')
                ->join('tags','tags.id','=','product_tags.tag_id')
                ->where(function($query) use ($data) {
                    foreach($data['tags'] as $tags){
                        $query->orWhere('tags.name',$tags);
                    };
                });
            });
         }
        if(array_key_exists('includes',$data)){
            $includes = [];
          foreach($data['includes'] as $include){
            switch($include){
                case 'all':
                    array_push($includes,'tags','details.color','details.picture','pictures','details.sales');
                    break 2;
                case 'tag':
                   array_push($includes,'tags');
                   break;
                case 'sale':
                    array_push($includes,'details.sales');
                    break;
                case 'detail':
                    array_push($includes,'details.color','details.picture');
                    break;
                case 'picture':
                    array_push($includes,'pictures');
                    break;
            }
          }
            $rs = $rs->with($includes)->paginate($data['limit'] ?? 10)->withQueryString()->toArray();
        }else{
            $rs = $rs->paginate($data['limit'] ?? 10)->withQueryString()->toArray();
        }
    
        return $rs;
    }
    public function createProduct($data){
        $product = DB::transaction(function () use ($data) {
            $product = $this->modelProduct->create(['name'=>$data['name'], 'brand'=>$data['brand'], 
            'description'=>$data['description'], 'slug'=>$data['slug']]);
            if(array_key_exists('tags',$data)){
                foreach($data['tags'] as $tag){
                    if(!is_array($tag)) return throw new UnprocessableContent("Tags must be an array of object.");
                    $product->tags()->attach($tag['id']);
                }
            }
            $pictureAddedUrls = [];

            // foreach($data['pictures'] as $picture){
            //     $url = Cloudinary::upload($picture->getRealPath())->getSecurePath();
            //     $picture = $this->modelPicture->create(['source'=>$url,'product_id'=>$product->id]);
            //     array_push($pictureAddedUrls,$picture->id);
            // }
            // foreach($data['colors'] as $color){
            //     if(!array_key_exists($color['picture']-1,$data['pictures'])) 
            //         throw new UnprocessableContent('Image with index '.$color['picture'].' not exist in uploaded pictures. Total uploaded '.count($data['pictures']).' pictures.');
            //     $uploadedFileUrl =$pictureAddedUrls[$color['picture']-1];
            //     // $result =$data['pictures'][$color['picture']-1] ->storeOnCloudinary('digitic')->getSecurePath();
            //     $pictureId = $pictureAddedUrls[$color['picture']-1];
            //     $product->colors()->attach($color['id'], 
            //     [
            //         'picture_id' => $pictureId,
            //         'regular_price' => $color['regular_price'],
            //         'active' => $color['active'],
            //         'quantity' => $color['quantity'],
            //     ]);
            // }

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
            return $product;
        });
        return $product;
    }
    public function showProduct($data,$id){
        if(array_key_exists('includes',$data)){
            $includes = [];
          foreach($data['includes'] as $include){
            switch($include){
                case 'all':
                    array_push($includes,'tags','details.color','details.picture','pictures','details.sales');
                    break 2;
                case 'tag':
                   array_push($includes,'tags');
                   break;
                case 'detail':
                    array_push($includes,'details.color','details.picture','details.sales');
                    break;
                case 'picture':
                    array_push($includes,'pictures');
                    break;
            }
          }
            $rs = $this->getById($id);
            if(!$rs ) throw new ModelNotFoundException('Product not found for id = '.$id.'.');
            $rs = $rs->load( $includes);
        }else{
            $rs = $this->getById($id);
            if(!$rs ) throw new ModelNotFoundException('Product not found for id = '.$id.'.');
        }
        // $product = $this->productRepo->getById($id);
        return $rs;
    }
  
}
