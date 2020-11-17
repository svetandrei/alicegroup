<?php

namespace Alice;

use Illuminate\Database\Eloquent\Model;

class Accordion extends Model {
    protected $table = 'accordion';

    protected $fillable = ['title', 'publish', 'sort', 'image', 'desc', 'service_id'];

    public function service(){
        return $this->belongsTo('Alice\Service');
    }
}
