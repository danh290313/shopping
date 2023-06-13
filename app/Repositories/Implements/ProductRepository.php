<?php
namespace App\Repositories\Implements;
use App\Repositories\Implements\BaseRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Models\Bank;

class ProductRepository extends BaseRepository implements IProductRepository{
    protected $modelProduct;

    public function __construct($modelProduct){
        parent::__construct($modelProduct);
        $this->modelProduct = $modelProduct;
    }
}
