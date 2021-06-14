<?php

include ("gdFunctions.php");

function mkImgTagFrom($imgsrc)
{
	echo '<image src="' . $imgsrc . '" /><br>';
	
}

$imgsrc1 = createDirectionImage(100, 100, 30,  4);
//$imgsrc1 = createDirectionImage(100, 100, -45,  3);
$imgsrc2 = createDirectionImage(100, 100, 145, 3);

$fg['r'] = 0;
$fg['g'] = 255;
$fg['b'] = 0;
$fg['a'] = 0;

$bg['r'] = 0;
$bg['g'] = 0;
$bg['b'] = 0;
$bg['a'] = 127;


$frameMax = 50;
	
$imgsrc3 = generateBarsGrowCenterAnimation( $frameMax, 100,
											900, 300,
											30, 300, 100,
											$fg, $bg, 1, 1);

?>


<?php

	mkImgTagFrom($imgsrc1);
	mkImgTagFrom($imgsrc2);
	mkImgTagFrom($imgsrc3);

?>