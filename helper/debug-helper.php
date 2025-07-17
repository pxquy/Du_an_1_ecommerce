<?php function genId($n, $prefix = null){
    $character = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $id = $prefix;
    $maxIndex = strlen($character)-1;
    for($i=0;$i<$n-1;$i++){
        $id .= $character[random_int(0, $maxIndex)];
    }
    return $id;
}

