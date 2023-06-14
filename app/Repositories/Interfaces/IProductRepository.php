<?php
namespace App\Repositories\Interfaces;
use App\Repositories\Interfaces\IBaseRepository;
use App\Models\Bank;

interface IProductRepository extends IBaseRepository{
    public function createProduct($data);
    public function getAllProduct($data);
    public function updateProduct($data,$id);
}
