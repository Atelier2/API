<?php
namespace GeoQuizz\Player\model;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model {
    protected $table = 'picture';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = false;
}