<?php
class NewsController 
{
    private $news;
    public function __construct()
    {
        $this->news = new News();
    }
}