<?
$text = $sample_text;
$f = explode('|',$font_ttf);
$ttf = FCPATH.'upload/product/'.$f[0];
//$text=str_replace('\n', PHP_EOL, $font_size." ".$sample_text);



/*$size = imagettfbbox($font_size, 0, $ttf, $text);
$xsize = abs($size[0]) + abs($size[2]);
$ysize = abs($size[5]) + abs($size[4]);
$image = imagecreate($xsize, $ysize);
$bcolor = imagecolorallocate ($image, 255, 255, 255);
$fcolor = imagecolorallocate ($image, rand(0, 255), rand(0, 255), rand(0, 255));
$black = imagecolorallocate($image, 0, 0, 0); // ������
imagefilledrectangle($image, 0, 0, $xsize, $ysize, $bcolor);
imagettftext($image, $font_size, 0, 0, $font_size+5, $black, $ttf, $text);
imagepng($image);
imagedestroy($image);
*/


/*x$size = imagettfbbox($font_size, 0, $ttf, $text);
/*$padding= 1;
$boxwidth= $size[4];
$boxheight= abs($size[3]) + abs($size[5]);
$w= $boxwidth + ($padding*2) + 1;
$h= $boxheight + ($padding) + 0;
*/
$w = abs($size[0]) + abs($size[2]);
$h = abs($size[5]) + abs($size[1]);


$im = imagecreate($w, $h);
//$im = imagecreatetruecolor($w, $h); // �̹��� ������ 400*30
$white = imagecolorallocate($im, 255, 255, 255); // ���
$gray = imagecolorallocate($im, 128, 128, 128); // ȸ��
$black = imagecolorallocate($im, 0, 0, 0); // ������

//imagefilledrectangle($im, 0, 0, $w, $h,  $white); // ������ ������� ä���

//imagettftext($im, 25, 0, 11, 21, $gray, $font, $text); // �۾����� ��Ʈ����Ʈ 20, ���� 0, X��ġ 11, Y��ġ 21
//imagettftext($im, $font_size, 0, 0, $font_size+5, $black, $ttf, $text); // �۾����� ��Ʈ����Ʈ 20, ���� 0, X��ġ 11, Y��ġ 21
imagettftext($im, $font_size, 0, abs($size[0]), abs($size[5]), $black, $ttf, $text);


header('Content-Type: image/png');
//imagesavealpha($im, true); 
imagepng($im);
imagedestroy($im);
?>

