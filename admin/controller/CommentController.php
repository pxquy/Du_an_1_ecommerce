<?php
class CommentController{
    private $comment;
    public function __construct()
    {
        $this->comment = new Comment();
    }
}