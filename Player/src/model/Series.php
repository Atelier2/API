<?php
namespace GeoQuizz\Player\model;

use Illuminate\Database\Eloquent\Model;

class Series extends Model {
    protected $table = 'series';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public $incrementing = false;

    public function pictures() {
        return $this->belongsToMany(Picture::class, "series_pictures", "id", "id_picture");
    }
}