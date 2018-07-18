<?php

namespace MixCode\Presenters;

class PostPresenter
{
   protected $post;
   
    public function __construct($post) 
    {
       $this->post = $post;
    }

    public function __get($key)
    {
       if (method_exists($this, $key)) {
           return $this->$key();
       }

       return $this->$key;
    }

    public function show()
    {
        return route('posts.show', $this->post);
    }

    public function edit()
    {
        return route('posts.edit', $this->post);
    }

    public function update()
    {
        return route('posts.update', $this->post);
    }

    
    public function delete()
    {
        return route('posts.delete', $this->post);
    }


}