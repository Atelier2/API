<?php 

namespace GeoQuizz\Mobile\model;

use Illuminate\Database\Eloquent\Model;

class User extends Model 
{
    protected $table = 'user';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = false;
}