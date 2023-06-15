<?php 
namespace App\Exceptions\CustomException;
use Exception;
class BaseException extends Exception{
    private $title='unknow_exception';
    public function __construct($message,$title){
        parent::__construct($message);
        $this->title = $title;
    }
}
?>