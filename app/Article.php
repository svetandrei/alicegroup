<?php

namespace Alice;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {
    protected $table = "articles";

    protected $fillable = ['title', 'url', 'publish', 'image', 'alias', 'text', 'desc', 'category_id'];

    public function category(){
        return $this->belongsTo('Alice\Category');
    }
}
