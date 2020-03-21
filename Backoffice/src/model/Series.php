<?php

namespace GeoQuizz\Backoffice\model;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = false;

    public function series_pictures()
    {
        return $this->belongsToMany('GeoQuizz\Backoffice\model\Picture', 'series_pictures', 'id', 'id_picture')->withPivot(['id', 'id_picture']);
    }
}