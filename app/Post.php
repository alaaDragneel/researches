<?php

namespace MixCode;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use MixCode\Presenters\PostPresenter;

class Post extends Model
{
    use Searchable;

    // protected $appends = [
    //     'url'
    // ];

    // public function getUrlAttribute()
    // {
    //     return new PostPresenter($this);
    // }
}
