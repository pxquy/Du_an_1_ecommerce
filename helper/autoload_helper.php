<?php
function loadHelper(){
    $path = [
        PATH_ROOT . 'helper/admin/*.php',
        PATH_ROOT . 'helper/client/*.php',
        PATH_ROOT . 'helper/general/*.php',
    ];
    foreach($path as $pattern){
        foreach(glob($pattern) as $file)
        require_once $file;
    }
}