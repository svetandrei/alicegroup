<?php

namespace Alice;

use Illuminate\Database\Eloquent\Model;

class Service extends Model {
    protected $table = 'services';

    protected $fillable = ['title', 'publish', 'sort', 'image', 'images', 'alias', 'text', 'desc', 'price', 'addition_price', 'desc_price', 'meta_keywords', 'meta_description', 'check_service', 'check_product'];

    public function accordions() {
        return $this->hasMany('Alice\Accordion');
    }
}
