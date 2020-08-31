<!DOCTYPE html>
<html>
<head>
  <title>IdCard Generator</title>
  <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/vendor/jquery-1.12.0.min.js"></script>
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="js/bootstrap.min.js"></script>

    <style>
  </style>
</head>

<?php

function cropAlign($image, $cropWidth, $cropHeight, $horizontalAlign = 'center', $verticalAlign = 'middle') {
    $width = imagesx($image);
    $height = imagesy($image);
    $horizontalAlignPixels = calculatePixelsForAlign($width, $cropWidth, $horizontalAlign);
    $verticalAlignPixels = calculatePixelsForAlign($height, $cropHeight, $verticalAlign);
    return imageCrop($image, [
        'x' => $horizontalAlignPixels[0],
        'y' => $verticalAlignPixels[0],
        'width' => $horizontalAlignPixels[1],
        'height' => $verticalAlignPixels[1]
    ]);
}

function calculatePixelsForAlign($imageSize, $cropSize, $align) {
    switch ($align) {
        case 'left':
        case 'top':
            return [0, min($cropSize, $imageSize)];
        case 'right':
        case 'bottom':
            return [max(0, $imageSize - $cropSize), min($cropSize, $imageSize)];
        case 'center':
        case 'middle':
            return [
                max(0, floor(($imageSize / 2) - ($cropSize / 2))),
                min($cropSize, $imageSize),
            ];
        default: return [0, $imageSize];
    }
} ?>

<?php


session_name("jwmf"); 
session_start(); 

$title = isset($_POST['title']) ? htmlentities($_POST['title']) : "INTERNET ID CARD";

$fname = $_POST['fname'] ;
$ename = $_POST['ename'] ;
$faname = $_POST['faname'];
$mname = $_POST['mname'];
$dname = $_POST['dname'];
$nid = $_POST['nid'];
$si=$_POST['si'];
$save = 'images/'.str_replace(" ","_",$ename).'.jpg';
$test = 'images/'.str_replace(" ","_",$ename).'aa.jpg';
$_SESSION['card']=$save; 
$bgpic = imagecreatefrompng("new.png");
$textcolor = imagecolorallocate($bgpic,255,255,255);
$infcolor = imagecolorallocate($bgpic,0,0,0);
$stscolor = imagecolorallocate($bgpic,0x00,0x55,0x00);
$ttscolor = imagecolorallocate($bgpic,255,0,0);
$font=__DIR__ ."/fonts/verdana.ttf";
$f2=__DIR__ ."/fonts/sm.ttf";
$f3=__DIR__ ."/fonts/sign.ttf";
$f4=__DIR__ ."/fonts/avro.ttf";
//imagestring($bgpic,7,30,5,$title,$textcolor);
//echo($f4);

// imagettftext($bgpic,20, 0,242,150,$infcolor,$f4,$fname);
 imagettftext($bgpic,38, 0,220,630,$textcolor,$font,$ename);
// imagettftext($bgpic,20, 0,242,215,$infcolor,$f4,$faname);
// imagettftext($bgpic,20, 0,242,245,$infcolor,$f4,$mname);
//imagettftext($bgpic,18, 0,291,278,$ttscolor,$font,$dname);
imagettftext($bgpic,28, 0,280,890,$textcolor,$font,$nid);
// imagettftext($bgpic,15, 0,35,300,$infcolor,$f3,$si);






$avl = $_FILES['file']['tmp_name'];

// $img = imagecreatefromgif($avl);
// $crop = new CircleCrop($img);
// $crop->crop()->display();

$img =  imagecreatefromjpeg($avl);
// $img = cropAlign($ii, 260, 260, 'center', 'middle');
$imgwidth = imagesx($img);
$imgheight = imagesy($img);
//this creates a pink rectangle of the same size
    $mask = imagecreatetruecolor($imgwidth, $imgheight);
    $pink = imagecolorallocate($mask, 255, 0, 255);
    imagefill($mask, 0, 0, $pink);
    //this cuts a hole in the middle of the pink mask
    $black = imagecolorallocate($mask, 0, 0, 0);
    imagecolortransparent($mask, $black);
    imagefilledellipse($mask, $imgwidth/2, $imgheight/2, $imgwidth, $imgheight, $black);
    //this merges the mask over the pic and makes the pink corners transparent
    imagecopymerge($img, $mask, 0, 0, 0, 0, $imgheight, $imgheight,100);
    imagecolortransparent($img, $pink);
    imagepng($img, $test);


if(trim($avl!=""))
{
  $imgi = getimagesize($avl);
  if($imgi[0]>0)
  {
      if($imgi[2]==1)
      {
        $av = imagecreatefrompng($test);
        imagecopyresized($bgpic, $av,230,245,0,0,260,260,$imgi[0], $imgi[1]);
      }else if($imgi[2]==2)
      {
        $av = imagecreatefrompng($test);
        imagecopyresized($bgpic, $av,230,245,0,0,260,260,$imgi[0], $imgi[1]);
      }else if($imgi[2]==3)
      {
        $av = imagecreatefrompng($test);
        imagecopyresized($bgpic, $av,230,245,0,0,260,260,$imgi[0], $imgi[1]);
      }

  }
}
imagepng($bgpic,$save);
imagedestroy($bgpic);
header("Location: ".$save); 

?>

<body>
   
   <center><img src="<?php  echo($save);  ?>"/></center>

</body>
