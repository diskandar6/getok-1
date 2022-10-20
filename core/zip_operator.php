<?php
function delete_and_backup($file){
    if(!file_exists($file))return false;
	$now=strtotime('now');
	if(!file_exists(D_BACKUP))mkdir(D_BACKUP,0755);
	if(is_dir($file)){
		$fn=D_BACKUP.'delete - '.date('Y-m-d-H-i-s',$now).'.zip';
		if(file_exists($fn))
		    zip_whole_folder($fn,array($file));
		delete_folder($file);
	}else{
		$fn=D_BACKUP.'delete - '.date('Y-m-d-H-i-s',$now).'.zip';
		zip_a_file($fn,array($file));
		unlink($file);
	}
}
function zip_a_file($filename,$file){
	$zip = new ZipArchive();
	if ($zip->open($filename,ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE){
		foreach($file as $k => $v)
			$zip->addFile($v,basename($v));
		if(file_exists($filename))
            $zip->close();
	}
}
function zip_whole_folder($filename,$folder){
	$zip = new ZipArchive();
	if($zip->open($filename, ZipArchive::CREATE | ZipArchive::OVERWRITE)===TRUE){
		for($i=0;$i<count($folder);$i++){
			$rootPath = realpath($folder[$i]);
			$bn=basename($folder[$i]);
			$files = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($rootPath),
				RecursiveIteratorIterator::LEAVES_ONLY
			);
			foreach ($files as $name => $file){
				if (!$file->isDir()){
					$filePath = $file->getRealPath();
					$relativePath = substr($filePath, strlen($rootPath) + 1);
					$zip->addFile($filePath, $bn.'/'.$relativePath);
				}
			}
		}
		if(file_exists($filename))$zip->close();
	}
}
function unzip($filename,$to){
	if(!is_dir($to))return false;
	$zip = new ZipArchive;
	if ($zip->open($filename) === TRUE) {
		$zip->extractTo($to);
		$zip->close();
		return true;
	}else{
		return false;
	}
}
function delete_folder($dirPath) {
	if (! is_dir($dirPath)) {
		throw new InvalidArgumentException("$dirPath must be a directory");
	}
	if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
		$dirPath .= '/';
	}
	$files = glob($dirPath . '*', GLOB_MARK);
	foreach ($files as $file) {
		if (is_dir($file)) {
			delete_folder($file);
		} else {
			unlink($file);
		}
	}
	rmdir($dirPath);
}
function force_download($filepath,$filename=''){
    if(file_exists($filepath)) {//echo 'ada';
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        if($filename!='')
            header('Content-Disposition: attachment; filename="'.$filename.'"');
        else
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filepath));
        flush(); // Flush system output buffer//*/
        readfile($filepath);
        exit;
    }
}

function saveto_zip($filename,$file_string,$content_string){
	$zip = new ZipArchive();
	if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE)
		exit("cannot open <$filename>\n");
	for($i=0;$i<count($file_string);$i++)
		$zip->addFromString($file_string[$i], $content_string[$i]);
	$zip->close();
}

function copy_folder($src,$dst,$newname='',$first=true){
    if($first){
        if($newname!='')
            $dst.=$newname.'/';
        //else
            //$dst.=basename($src).'/';
    }
    $src=str_replace('//','/',$src.'/');
    $dst=str_replace('//','/',$dst.'/');
    if(!file_exists($dst))mkdir($dst,0755);//else return false;
    $files=scandir($src);
    foreach($files as $k => $v)if($v!='.'&&$v!='..'){
        if(is_dir($src.$v)){
            copy_folder($src.$v.'/',$dst.$v.'/',$newname,false);
        }else{
            copy($src.$v,$dst.$v);
        }
    }
}
?>