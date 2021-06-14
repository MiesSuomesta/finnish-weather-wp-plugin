<?php

include ("gdFunctions.php");

function mkImgTagFrom($imgsrc)
{
	echo '<image src="' . $imgsrc . '" /><br>';
	
}

function mkBackgroundFrom($imgsrc)
{
	echo "background-image:url('" . $imgsrc . "');";
	
}

$imgsrc1 = createDirectionImage(100, 100, 30,  4);
//$imgsrc1 = createDirectionImage(100, 100, -45,  3);
$imgsrc2 = createDirectionImage(100, 100, 145, 3);

$fg['r'] = 0;
$fg['g'] = 127;
$fg['b'] = 0;
$fg['a'] = 0;

$bg['r'] = 0;
$bg['g'] = 0;
$bg['b'] = 0;
$bg['a'] = 255;


$frameMax = 50;
	
$imgsrc3 = generateBarsGrowCenterAnimation( $frameMax, 100,
											900, 200,
											10, 150, 100,
											$fg, $bg, 1, 1, 1);

$imgsrc2 = generateBarsGrowCenterAnimation( $frameMax, 100,
											900, 200,
											10, 150, 100,
											$fg, $bg, 1, 0, 0);

?>


<?php

	mkImgTagFrom($imgsrc1);
	mkImgTagFrom($imgsrc2);
	mkImgTagFrom($imgsrc3);

?>

<table>
	<tr>
		<td style="<?php mkBackgroundFrom($imgsrc3); ?>"  width="900">jeppajees</td>
	</tr>
	<tr>
		<td style="<?php mkBackgroundFrom($imgsrc2); ?>"><H1 style="fgcolor='#FFFFFF';">jeppajees2</H1></td>
	</tr>
</table>