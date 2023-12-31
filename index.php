<?php 
namespace bookweb\engine;

use bookweb\engine as E;

if (version_compare(PHP_VERSION,'5.5.0','<')){
    exit("Your php version is: ".PHP_VERSION.". This script requires php version 5.5.0 and above.");
}
if (!extension_loaded('mbstring')){
    exit("This script needs mbstring extension, Please install extension.");
}

//define protocol with if else statement
if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on'){
    define('PROT','https://');
} else { 
    define('PROT','https://');
}

// define ROOT_PATH and ROOT_URL
define('ROOT_URL',PROT.$_SERVER['HTTP_HOST'].str_replace('\\','',dirname(htmlspecialchars($_SERVER['PHP_SELF'],ENT_QUOTES))).'/');
define('ROOT_PATH',__DIR__.'/');

try{
    require(ROOT_PATH.'engine/loader.php');
    E\loader::getInstance()->init();
    $aParams = ['ctrl' => (!empty($_GET['p']) ? $_GET['p'] : 'blog'), 'act' => (!empty($_GET['a']) ? $_GET['a'] : 'index')]; // I use the new PHP 5.4 short array syntax
    E\Router::run($aParams);
} catch(\Exception $oE){
    echo $oE->getMessage();
}
?>