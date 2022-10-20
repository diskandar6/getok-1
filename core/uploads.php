<?php
if(isset($_POST['uclassic'])){
    if(isset($_SESSION['uploads']))
    	$uploadfile = $_SESSION['uploads'];
    else
    	$uploadfile = D_MAIN_PATH.'/uploads/';
    $uploadfile.=basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
    if(file_exists($uploadfile)){
        $ext=explode('.',$uploadfile);
        $ext=end($ext);
        $ff=dirname($uploadfile).'/'.$_SESSION['filename-uploaded'].'.'.$ext;
        $_SESSION['filename']=$_SESSION['filename-uploaded'].'.'.$ext;
        $_SESSION['dirname']=dirname($uploadfile).'/';
        if(isset($_SESSION['overwite']))
        if(file_exists($ff))
            unlink($ff);
        rename($uploadfile, $ff);
        if(isset($_POST['nextstep'])){
            if(function_exists($_POST['nextstep']))
                call_user_func($_POST['nextstep']);
        }else{
            header("location: ".$_SERVER['HTTP_REFERER']);
        }
    }else echo 'no';
}else{
/**
 * upload.php
 *
 * Copyright 2013, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */

#!! IMPORTANT: 
#!! this file is just an example, it doesn't incorporate any security checks and 
#!! is not recommended to be used in production environment as it is. Be sure to 
#!! revise it and customize to your needs.


// Make sure file is not cached (as it happens for example on iOS devices)
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

/* 
// Support CORS
header("Access-Control-Allow-Origin: *");
// other CORS headers if any...
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	exit; // finish preflight CORS requests here
}
*/

// 5 minutes execution time
@set_time_limit(5 * 60);

// Uncomment this one to fake upload time
// usleep(5000);

// Settings
if(isset($_SESSION['uploads']))
	$targetDir = $_SESSION['uploads'];
else
	$targetDir = D_MAIN_PATH.'/uploads';//ini_get("upload_tmp_dir") . DIRECTORY_SEPARATOR . "plupload";

//$targetDir = 'uploads';
$cleanupTargetDir = true; // Remove old files
$maxFileAge = 5 * 3600; // Temp file age in seconds


// Create target dir
if (!file_exists($targetDir)) {
	@mkdir($targetDir);
}
//chmod($targetDir, 0755);

// Get a file name
if (isset($_REQUEST["name"])) {
	$fileName = $_REQUEST["name"];
} elseif (!empty($_FILES)) {
	$fileName = $_FILES["file"]["name"];
} else {
	$fileName = uniqid("file_");
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

if(!isset($_SESSION['fileoris']))$_SESSION['fileoris']=array();
if(!in_array($fileName,$_SESSION['fileoris']))
array_push($_SESSION['fileoris'],$fileName);

function get_ext($fn){return end(explode('.',$fn));}
$_SESSION['fileori']=$fileName;

// Chunking might be enabled
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;


// Remove old temp files	
if ($cleanupTargetDir) {
	if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
	}

	while (($file = readdir($dir)) !== false) {
		$tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;

		// If temp file is current file proceed to the next
		if ($tmpfilePath == "{$filePath}.part") {
			continue;
		}

		// Remove temp file if it is older than the max age and is not the current file
		if (preg_match('/\.part$/', $file) && (filemtime($tmpfilePath) < time() - $maxFileAge)) {
			@unlink($tmpfilePath);
		}
	}
	closedir($dir);
}	


// Open temp file
if (!$out = @fopen("{$filePath}.part", $chunks ? "ab" : "wb")) {
	die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

if (!empty($_FILES)) {
	if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
	}

	// Read binary input stream and append it to temp file
	if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
} else {	
	if (!$in = @fopen("php://input", "rb")) {
		die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
	}
}

while ($buff = fread($in, 4096)) {
	fwrite($out, $buff);
}

@fclose($out);
@fclose($in);

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1){
    // Strip the temp .part suffix off 
    if(!isset($_SESSION['filename-uploaded'])){
        if($_SESSION['overwite'])
        if(file_exists($filePath))
                unlink($filePath);
        $ff=$filePath;
        //$ff=str_replace(' ','-',$ff);
        $_SESSION['filename']=basename($ff);
        rename("{$filePath}.part", $ff);
    }else{
        $ext=explode('.',$filePath);
        $ext=end($ext);
        $ff=dirname($filePath).'/'.$_SESSION['filename-uploaded'].'.'.$ext;
        $_SESSION['filename']=$_SESSION['filename-uploaded'].'.'.$ext;
        if($_SESSION['overwite'])
        if(file_exists($ff))
                unlink($ff);
        //$ff=str_replace(' ','-',$ff);
        rename("{$filePath}.part", $ff);
        unset($ff);
	}
}

// Return Success JSON-RPC response
die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
}
//chmod($filePath, 0777);