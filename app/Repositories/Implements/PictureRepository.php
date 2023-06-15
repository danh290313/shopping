<?php
namespace App\Repositories\Implements;
use App\Repositories\Implements\BaseRepository;
use App\Repositories\Interfaces\IPicturerRepository;
use App\Models\Picture;
class PictureRepository extends BaseRepository implements PicturerRepository{
    protected $pictureModel;

    public function __construct(Picture $pictureModel){
        parent::__construct($pictureModel);
        $this->pictureModel = $pictureModel;
    }
  
}
