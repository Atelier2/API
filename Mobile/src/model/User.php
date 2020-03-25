<?php 

namespace GeoQuizz\Mobile\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model 
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = false;

    public function pictures(){
        return $this->hasMany('GeoQuizz\Mobile\model\Picture', 'id_user');
    }
}