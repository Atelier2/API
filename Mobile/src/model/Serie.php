<?php 

namespace GeoQuizz\Mobile\model;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model 
{
    protected $table = 'series';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = false;

    public function getSerie_picture(){
        return $this->belongToMany('GeoQuizz\Mobile\model\Picture', 'series_pictures', 'id', 'id_picture')
                                    ->withPivot(['id', 'id_picture']);
    }
}