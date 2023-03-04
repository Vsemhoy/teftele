<?php

/**

Laravel - A PHP Framework For Web Artisans
@Package Laravel
@author Taylor Otwell taylor@laravel.com
*/
$uri = urldecode(
parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' && file_exists($_SERVER['DOCUMENT_ROOT'] .'laraveltest/public'.$uri)) {
return false;
}
// if (isset($_SESSION['user_login_attempts']) 
// && $_SESSION['user_login_attempts'] > 5){
//     //return "HELLOW";
//     die("You broken my heart:(");
//    // echo "Pass";
// }
require_once $_SERVER['DOCUMENT_ROOT'] .'/public/index.php';

?>