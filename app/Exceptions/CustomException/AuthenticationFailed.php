<?php 
namespace App\Exceptions\CustomException;
class AuthenticationFailed extends BaseException{
    private $title='authentication_failed';
    private $statusCode = 401;
    public function __construct($message){
        parent::__construct($message, $this->title,$this->statusCode);
    }

}
?>