<?php

/**
* debug function
 * @param data of any type
 */
function dd($data){
    echo '<pre style="background-color: black;padding: 10px 15px; color: #fff;">';
    var_dump($data);
    echo '</pre>';
}


