<?php
header("Content-Type:text/html; charset=utf-8");
$up_url = '/upload/editor'; // 기본 업로드 URL
$up_dir = $_SERVER['DOCUMENT_ROOT'].$up_url; // 기본 업로드 폴더
 
// 업로드 DIALOG 에서 전송된 값
$funcNum = $_GET['CKEditorFuncNum'] ;
$CKEditor = $_GET['CKEditor'] ;
$langCode = $_GET['langCode'] ;
 
if(isset($_FILES['upload']['tmp_name']))
{
    $file_name = $_FILES['upload']['name'];
    $ext = strtolower(substr($file_name, (strrpos($file_name, '.') + 1)));
 	
    //이미지가 아닌경우
    if(!preg_match("/[gif|jpe?g|png]/", strtolower($ext)))
    {
    	echo '이미지만 가능';
    	return false;
    }
    
    //파일경로설정
    $up_dir .= '/'.date('Ymd');
    if(!is_dir($up_dir))
    {
    	mkdir($up_dir, 0755);
    }
    
    $up_url .= '/'.date('Ymd');
        
    //파일명 변경
    do{
    	$filename = rand(1000000000,9999999999).".$ext";
    	$dest_file = "{$up_dir}/{$filename}";
    }while(file_exists($dest_file));
 
    //$save_dir = sprintf('%s/%s', $up_dir, $filename);
    $save_url = sprintf('%s/%s', $up_url, $filename);
 
    if (move_uploaded_file($_FILES["upload"]["tmp_name"],$dest_file))
        echo "<script>window.parent.CKEDITOR.tools.callFunction($funcNum, '$save_url', '');</script>";
}
?>