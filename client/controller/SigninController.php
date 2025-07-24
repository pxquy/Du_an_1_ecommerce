<?php
require_once("./client/models/user.php");
class SigninController
{
    protected $client;
    public function __construct()
    {
        $this->client = new User();
    }
    public function signin()
    {
        $views = "/signin";
        $title = "signin";
        require_once PATH_VIEW_CLIENT . $views . '.php';
    }
}
