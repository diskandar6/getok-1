<?php
//	MOHON JANGAN DIHAPUS BARIS INI
session_start();

//	SETUP DATABASE CONFIGURATION
//	phpmyadmin
define('D_DBHOST','localhost');
define('D_DBUSER','root');
define('D_DBPASSWORD','');
define('D_DBDATA','getok1');

define('D_DEBUG',true);

//	blok ip address
define('D_NOTALLOWEDIP','[]');

//  lokasi folder penyimpanan database
define('D_DATAFILE',dirname(__DIR__).'/');
if(!file_exists(D_DATAFILE))mkdir(D_DATAFILE,0755);

//  lokasi folder penyimpanan database
define('D_DATABASES_PATH',D_DATAFILE.'database/');
if(!file_exists(D_DATABASES_PATH))mkdir(D_DATABASES_PATH,0755);

//	path untuk backup
define('D_BACKUP', D_DATAFILE."trash/");
if(!file_exists(D_BACKUP))mkdir(D_BACKUP,0755);

//  notepad
define('D_NOTEPAD',D_DATAFILE.'notepad/');
if(!file_exists(D_NOTEPAD))mkdir(D_NOTEPAD,0755);

//  favicon
define('D_FAVICON','/assets/logo/36.png');
define('D_MAIN_LOGO','/assets/logo/96.png');

// user login level
define('D_USER_LEVEL','admin,author');

// cross user
define('D_CROSS_USER','["profile","bukupetunjuk"]');

// always redirect to https
define('REDIRECT_HTTPS',false);

define('REDIRECT_DOMAIN',false);

//define('D_GOOGLE_SIGN_CODE','550737244682-cp111v33aapbt8aiqhc4u87v4oe0euko.apps.googleusercontent.com');

$fn=D_MAIN_PATH.'modules/'.$_SERVER['HTTP_HOST'].'/uncategory/login/set_cookie.php';
if(file_exists($fn))require $fn;
?>
