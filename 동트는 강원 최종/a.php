<?
function make_thumbnail($source_file, $_width, $_height, $object_file){
	
	//////////////////////////////////////////////////////////////////////
	//   make_thumbnail("1457669115557.jpg", 400,400,"test.jpg");   //
	//////////////////////////////////////////////////////////////////////

	//정확한 사이즈로 비율을 계산해서 폭 높이를 계산..
	$imgsize = img_resize_only("",$source_file,$_width,$_height);
	$_width = $imgsize[0];
	$_height = $imgsize[1];

    list($img_width,$img_height, $type) = getimagesize($source_file);
    if ($type==1) $img_sour = imagecreatefromgif($source_file);
    else if ($type==2 ) $img_sour = imagecreatefromjpeg($source_file);
    else if ($type==3 ) $img_sour = imagecreatefrompng($source_file);
    else if ($type==15) $img_sour = imagecreatefromwbmp($source_file);
    else return false;
    if ($img_width > $img_height) {
        $width = round($_height*$img_width/$img_height);
        $height = $_height;
    } else {
        $width = $_width;
        $height = round($_width*$img_height/$img_width);
    }
    if ($width < $_width) {
        $width = round(($height + $_width - $width)*$img_width/$img_height);
        $height = round(($width + $_width - $width)*$img_height/$img_width);
    } else if ($height < $_height) {
        $height = round(($width + $_height - $height)*$img_height/$img_width);
        $width = round(($height + $_height - $height)*$img_width/$img_height);
    }
    $x_last = round(($width-$_width)/2);
    $y_last = round(($height-$_height)/2);
    if ($img_width < $_width || $img_height < $_height) {
        $img_last = imagecreatetruecolor($_width, $_height); 
        $x_last = round(($_width - $img_width)/2);
        $y_last = round(($_height - $img_height)/2);

        imagecopy($img_last,$img_sour,$x_last,$y_last,0,0,$width,$height);
        imagedestroy($img_sour);
        $white = imagecolorallocate($img_last,255,255,255);
        imagefill($img_last, 0, 0, $white);
    } else {
        $img_dest = imagecreatetruecolor($width,$height); 
        imagecopyresampled($img_dest, $img_sour,0,0,0,0,$width,$height,$img_width,$img_height); 
        $img_last = imagecreatetruecolor($_width,$_height); 
        imagecopy($img_last,$img_dest,0,0,$x_last,$y_last,$width,$height);
        imagedestroy($img_dest);
    }
    if ($object_file) {
        if ($type==1) imagegif($img_last, $object_file, 100);
        else if ($type==2 ) imagejpeg($img_last, $object_file, 100);
        else if ($type==3 ) imagepng($img_last, $object_file, 100);
        else if ($type==15) imagebmp($img_last, $object_file, 100);
    } else {
        if ($type==1) imagegif($img_last);
        else if ($type==2 ) imagejpeg($img_last);
        else if ($type==3 ) imagepng($img_last);
        else if ($type==15) imagebmp($img_last);
    }
    imagedestroy($img_last);
    return true;
}

function img_resize_only($path, $img, $maxwidth, $maxheight) {
	if($img) {
		// $img는 이미지의 경로(예:./images/phplove.gif) 
		$imgsize = getimagesize($path.$img); 
		if($imgsize[0]>$maxwidth || $imgsize[1]>$maxheight) { 
			// 가로길이가 가로limit값보다 크거나 세로길이가 세로limit보다 클경우 
			$sumw = (100*$maxheight)/$imgsize[1]; 
			$sumh = (100*$maxwidth)/$imgsize[0]; 
			if($sumw < $sumh) { 
			// 가로가 세로보다 클경우 
			$img_width = ceil(($imgsize[0]*$sumw)/100); 
			$img_height = $maxheight; 
			} else { 
			// 세로가 가로보다 클경우 
			$img_height = ceil(($imgsize[1]*$sumh)/100); 
			$img_width = $maxwidth; 
			} 
		} else { 
			// limit보다 크지 않는 경우는 원본 사이즈 그대로..... 
			$img_width = $imgsize[0]; 
			$img_height = $imgsize[1]; 
		} 
		
		$imgsize[0] = $img_width;
		$imgsize[1] = $img_height;
	} else {
		$imgsize[0] = $maxwidth;
		$imgsize[1] = $maxheight;
	}
	return $imgsize;
}



?>