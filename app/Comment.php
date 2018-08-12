<?php

namespace MixCode;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable = [ 'body', 'user_id', 'post_id'];

	protected $casts = [
	    'user_id' => 'integer',
	    'post_id' => 'integer',
	];

	public function post()
	{
		return $this->belongsTo(Post::class, 'post_id');
	}

	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
