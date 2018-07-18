<?php

namespace MixCode;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use MixCode\Presenters\PostPresenter;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends Model
{
    use Searchable, LogsActivity;

    protected $fillable = ['title', 'body'];

    protected static $logFillable = true;

    public function getDescriptionForEvent(string $eventName) : string
    {
        return "This Model Has Been {$eventName}";
    }

    // protected static $logAttributes = ['title', 'body'];
    // protected static $logAttributes = ['*'];

    // protected $appends = [
    //     'url'
    // ];

    // public function getUrlAttribute()
    // {
    //     return new PostPresenter($this);
    // }
}
