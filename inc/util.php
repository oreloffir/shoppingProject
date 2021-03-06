<?php
/**
 * Created by PhpStorm.
 * User: Orel
 * Date: 6/21/2017
 * Time: 3:57 PM
 */
function adjImg($imgloc,$ext,$dir,$quality=0.8){
    $new_width="670";
    list($img_width, $img_height, $image_type) = @getimagesize($imgloc);
    if(!$img_width){
        return 1;
    }
    switch($image_type)
    {
        case 1: $src_im = @imagecreatefromgif($imgloc);    break;
        case 2: $src_im = @imagecreatefromjpeg($imgloc);   break;
        case 3: $src_im = @imagecreatefrompng($imgloc);    break;
    }
    if(!$src_im){
        return 2;
    }
    $new_height=$img_height*($new_width/$img_width);
    $dst_img = @imagecreatetruecolor($new_width, $new_height);
    if(!$dst_img){
        return 3;
    }
    //////////////////////////////////// ORIGINAL WIDTH TO 670PX ///////////////////////////////////
    $success = @imagecopyresampled($dst_img,$src_im,0,0,0,0,$new_width,$new_height,$img_width,$img_height);
    if(!$success){
        return 4;
    }
    $imgname = "image_".time();
    $th_filename = "$dir/$imgname.$ext";
    switch ($image_type)
    {
        case 1: $success = imagegif($dst_img,$th_filename); 						break;
        case 2: $success = imagejpeg($dst_img,$th_filename,intval($quality*100));  break;
        case 3: $success = imagepng($dst_img,$th_filename,intval($quality*9)); 	break;
    }
    if(!$success){
        return 5;
    }
    imagedestroy($dst_img);
    return $imgname;
}
function createThumb($imgloc,$imgname,$ext,$quality=0.8){
    $new_width=300;
    $new_height=150;
    list($img_width, $img_height, $image_type) = @getimagesize($imgloc);
    if(!$img_width){
        return 1;
    }
    switch($image_type)
    {
        case 1: $src_im = @imagecreatefromgif($imgloc);    break;
        case 2: $src_im = @imagecreatefromjpeg($imgloc);   break;
        case 3: $src_im = @imagecreatefrompng($imgloc);    break;
    }
    if(!$src_im){
        return 2;
    }
    $dst_img = @imagecreatetruecolor($new_width, $new_height);
    if(!$dst_img){
        return 3;
    }

    $cropPercent = .6;
    if($img_width > $img_height){
        $biggestSide = $img_width;
    }else{
        $biggestSide = $img_height;
    }
    $cropWidth   = $biggestSide*$cropPercent;
    $cropHeight  = $biggestSide*$cropPercent;

    $c = array("x"=>($img_width-$cropWidth)/2, "y"=>($img_height-$cropHeight)/2);

    $success = @imagecopyresampled($dst_img,$src_im,0,0,$c['x'],$c['y'],$new_width,$new_height,$cropWidth,$cropHeight);
    if(!$success){
        return 4;
    }
    $th_filename = "uploads/tmb_".$imgname.".".$ext;
    switch ($image_type)
    {
        case 1: $success = @imagegif($dst_img,$th_filename); 						break;
        case 2: $success = @imagejpeg($dst_img,$th_filename,intval($quality*100));  break;
        case 3: $success = @imagepng($dst_img,$th_filename,intval($quality*9)); 	break;
    }
    if(!$success){
        return 5;
    }
    imagedestroy($dst_img);
    return "tmb_".$imgname;
}

function timeAgo($timestamp,$output = null) {
    if($output == null)
        $output = lang('LESS_THEN_MIN');
    $timegot=$timestamp;
    $timestamp = time() - $timestamp;
    $units = array(604800=>lang('WEEK'),86400=>lang('DAY'),3600=>lang('HOUR'),60=>lang('MINUTE'));
    foreach($units as $seconds => $unit) {
        if ($seconds<=$timestamp) {
            $value = floor($timestamp/$seconds);
            if($value > 1){
                switch ($unit){
                    case lang('WEEK'):
                        $unit=lang('WEEKS');
                        break;
                    case lang('DAY'):
                        $unit=lang('DAYS');
                        break;
                    case lang('HOUR'):
                        $unit=lang('HOURS');
                        break;
                    case lang('MINUTES'):
                        $unit=lang('MINUTES');
                        break;
                }
            }
            if($value == '1'){
                $value=null;
                if($unit == lang('DAY')){
                    $output = lang('YESTERDAY_AT').' '.date("H:i" ,$timegot);
                    break;
                }
            }
            $output = $value.' '.$unit.' '.lang('AGO');
            break;
        }
    }
    return $output;
}

function addUrlParam($key, $value){
    $base = basename($_SERVER['REQUEST_URI']);
    if(strrpos ($base,"?"))
        $base = $base."&";
    else
        $base = $base."?";
    return $base.$key."=".$value;
}

function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}