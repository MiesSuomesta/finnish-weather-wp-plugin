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
$fg['g'] = 0;
$fg['b'] = 0;
$fg['a'] = 0;

$bg['r'] = 0;
$bg['g'] = 0;
$bg['b'] = 255;
$bg['a'] = 0;


$frameMax = 50;
	
$imgsrc3 = generateBarsGrowCenterAnimation( $frameMax, 100,
											900, 200,
											30, 200, 100,
											$fg, $bg, 1, 0, 1);

?>


<?php

	mkImgTagFrom($imgsrc1);
	mkImgTagFrom($imgsrc2);
	mkImgTagFrom($imgsrc3);

?>