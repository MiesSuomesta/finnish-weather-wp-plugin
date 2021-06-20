<?php

include ("gdFunctions.php");

function mkImgTagFrom($imgsrc)
{
	echo '<image src="' . $imgsrc . '" /><br>';
	
}

function mkBackgroundFrom($imgsrc, $w, $h)
{

	$ssw = 'width: ' . $w .'; ';
	$ssh = 'height: ' . $h .'; ';
	
	echo "$ssw $ssh background-image:url('" . $imgsrc . "');";
	
}

function var_title_dump($t, $v)
{
/*
	echo "<br>$t = <pre>"; 
	var_dump ($v);
	echo "</pre>"; 
*/
}


$animationconfig = [
	"fg" => [
		"r" => 0,
		"g" => 100 + rand(0,70),
		"b" => 0,
		"a" => 0,
	],
	"bg" => [
		"r" => 5,
		"g" => 30,
		"b" => 5,
		"a" => 0,
	],
	"loopcount" => 1,
	"fade" => 1,
	"barwidth" => 10,
	"barheight" => 200,
	"barstaticheight" => 140,
	"timeperframe" => 100,
	"frames" => 40,
	"width" => 180,
	"height" => 220
];

$masterconfig = $animationconfig;

var_title_dump("animationconfig", $animationconfig);
var_title_dump("masterconfig", $masterconfig);

$config = $masterconfig;

var_title_dump("config", $config);


$fg['r'] = $config['fg']['r'];
$fg['g'] = $config['fg']['g'];
$fg['b'] = $config['fg']['b'];
$fg['a'] = $config['fg']['a'];


$bg['r'] = $config['bg']['r'];
$bg['g'] = $config['bg']['g'];
$bg['b'] = $config['bg']['b'];
$bg['a'] = $config['bg']['a'];

var_title_dump("FG", $fg);
var_title_dump("BG", $bg);

$loopcount = $config['loopcount'];
$width = $config['width'];
$height = $config['height'];
$barstaticheight = $config['barstaticheight'];
$barwidth = $config['barwidth'];
$barheight = $config['barheight'];
$timeperframe = $config['timeperframe'];
$fade = $config['fade'];
$frames = $config['frames'];

var_title_dump("loopcount", $loopcount);
var_title_dump("width", $width);
var_title_dump("height", $height);
var_title_dump("barstaticheight", $barstaticheight);
var_title_dump("barheight", $barheight);
var_title_dump("barwidth", $barwidth);
var_title_dump("timeperframe", $timeperframe);
var_title_dump("frames", $frames);
var_title_dump("fade", $fade);

$imsrc = generateBarsGrowCenterAnimation( $frames, $timeperframe,
											$width, $height,
											$barwidth, $barheight, $barstaticheight,
											$fg, $bg, 1, $loopcount, $fade);

header("Access-Control-Allow-Origin: *");
echo $imsrc;
?>
