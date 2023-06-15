<?php 
namespace App\Exceptions\CustomException;
class PivotKeyExists extends BaseException{
    public function __construct($message){
        parent::__construct($message,"pivot_key_exist");

    }

}
?>