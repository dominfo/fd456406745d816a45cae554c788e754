<?php
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(dirname(__FILE__)));
spl_autoload_register(function($class){
	require_once (ROOT . DS . "lib" .DS. "models" . DS . $class .".class.php");
});
database::connect();
//print_r (test::insert("insert into `pickyug`.`authousers` (`user_id`, `user_name`, `password`) values (NULL, 'admin4', 'admin4')"));
test::insert("insert into `pickyug`.`authousers` (`user_id`, `user_name`, `password`) values (NULL, 'admin4', 'admin4')");
//database::select("select * from authousers");
// echo "<pre>";
// print_r(database::getResult());
//print_r($_SERVER);
?>