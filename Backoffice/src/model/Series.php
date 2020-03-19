<?php
namespace GeoQuizz\Backoffice\model;

use Illuminate\Database\Eloquent\Model;

class Series extends Model {
    protected $table = 'series';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = false;
}