<?php    

// exit ("index");
define('DS', DIRECTORY_SEPARATOR);
define('ROOT', dirname(__FILE__));
define('current', dirname(__FILE__));
define('ITEMPATH', dirname(__FILE__)."/iteams/");

require_once (ROOT . DS . 'config' . DS . 'config.php');
//require_once (ROOT . DS . 'config' . DS . 'database.php');
 
/** Check if environment is development and display errors **/
 
function setReporting() 
{
    if (DEVELOPMENT_ENVIRONMENT == true)
    {
        error_reporting(E_ALL);
        ini_set('display_errors','On');
    }
    else
    {
        error_reporting(E_ALL);
        ini_set('display_errors','Off');
        ini_set('log_errors', 'On');
        ini_set('error_log', ROOT.DS.'tmp'.DS.'logs'.DS.'error.log');
    }
}
 
/** Check for Magic Quotes and remove them **/
 
function stripSlashesDeep($value)
{
    $value = is_array($value) ? array_map('stripSlashesDeep', $value) : stripslashes($value);
    return $value;
}
 
function removeMagicQuotes()
{
    if ( get_magic_quotes_gpc() )
    {
        $_GET    = stripSlashesDeep($_GET   );
        $_POST   = stripSlashesDeep($_POST  );
        $_COOKIE = stripSlashesDeep($_COOKIE);
    }
}
 
/** Check register globals and remove them **/
 
function unregisterGlobals()
{
    if (ini_get('register_globals'))
    {
        $array = array('_SESSION', '_POST', '_GET', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        foreach ($array as $value)
        {
            foreach ($GLOBALS[$value] as $key => $var) 
            {
                if ($var === $GLOBALS[$key])
                {
                    unset($GLOBALS[$key]);
                }
            }
        }
    }
}

function callHook()
{
    $urlArray = array();
    $urlWithParam = URL;
    $urlArray1 = explode("?",URL);
    $urlWithoutParam = $urlArray1[0];
    if(array_key_exists(1, $urlArray1))
    {
        $urlParam = $urlArray1[1];
    }
    $urlArray = explode("/",$urlArray1[0]);

    $level_1 = $urlArray[1];
    $level_2 = $urlArray[2];

// echo "@@@@@@@@@@@@@@@@@";
// echo "$level_2";    
// echo "++++++++++++++++++++++";
// echo simple_decrypt($level_2);
findMatchFolder($level_2);
}

// echo simple_encrypt("how.its.made");
// echo "--------------------------------";
// echo simple_decrypt(simple_encrypt("1111"));

function simple_encrypt($text, $salt = "chaman")
{
    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
}
// This function will be used to decrypt data.
 function simple_decrypt($text, $salt = "chaman")
 {
    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}

setReporting();
removeMagicQuotes();
unregisterGlobals();
callHook();


function findMatchFolder($name)
{
    $name = simple_decrypt($name);
    $dir = ITEMPATH;

    
    if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file == $name)
            {
                echo  "1 ".$file ."<br>";
                echo  "2 ". ITEMPATH . $name ."<br>";

            }
        }
        closedir($dh);
        }
    }


}


