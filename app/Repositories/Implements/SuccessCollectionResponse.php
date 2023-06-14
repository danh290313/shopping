<?php 
namespace App\Repositories\Implements;
use App\Repositories\Interfaces\ISuccessCollectionResponse;
class SuccessCollectionResponse implements ISuccessCollectionResponse{
    public static function createResponse($data,$statusCode = 200){
        return response()->json(['result'=>'ok','response'=>'collection',...$data],$statusCode);
    }
}

?>