<?php
function debug($data, $exit = true)
{
    echo '<pre style="background: #f4f4f4; padding: 10px; border: 1px solid #ccc; color: #333;">';
    print_r($data);
    echo '</pre>';
    if ($exit) {
        exit;
    }
}
