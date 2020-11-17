<?php

namespace Alice;

use Illuminate\Database\Eloquent\Model;

class Category extends Model{
    protected $table = 'categories';

    protected $fillable = ['title','image','alias','url','publish','text','desc','parent_id', 'meta_keywords', 'meta_description'];

    public function articles() {
        return $this->hasMany('Alice\Article');
    }

    public function parent() {
        return $this->belongsTo('Alice\Category', 'parent_id');
    }

    public function children() {
        return $this->hasMany('Alice\Category', 'parent_id', 'id');
    }
}
