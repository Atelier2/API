<?php
namespace GeoQuizz\Mobile\model;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model {
    protected $table = 'picture';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = false;

    public function series() {
        return $this->belongsToMany(Picture::class, "series_pictures", "id_picture", "id");
    }
}