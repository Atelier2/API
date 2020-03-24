<?php

namespace GeoQuizz\Backoffice\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = false;

    public function getPictures()
    {
        return $this->hasMany('GeoQuizz\Backoffice\model\Picture', 'id_user');
    }

    public function getSeries()
    {
        return $this->hasMany('GeoQuizz\Backoffice\model\Series', 'id_user');
    }
}