<?php

namespace MixCode;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use MixCode\Presenters\PostPresenter;
use Spatie\Activitylog\Traits\LogsActivity;

class Post extends Model
{
    use Searchable, LogsActivity;

    /**
     * @{inheritDocs}
     */
    protected $fillable = ['title', 'body', 'archive', 'user_id'];

    protected static $logFillable = true;

    /**
     * @{inheritDocs}
     */
    protected $casts = ['archive' => 'boolean'];

    public function getDescriptionForEvent(string $eventName) : string
    {
        return "This Model Has Been {$eventName}";
    }

    public function archive()
    {
        if ($this->isArchive()) return;
        $this->update(['archive' => true]);        
    }

    
    public function unArchive()
    {
        if (! $this->isArchive()) return;
        $this->update(['archive' => false]);        
    }

    public function isArchive()
    {
        return $this->archive;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id');
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
