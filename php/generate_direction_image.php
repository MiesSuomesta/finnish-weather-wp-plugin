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
											$fg, $bg, 1, 0, 0);

$imgsrc2 = generateBarsGrowCenterAnimation( $frameMax, 100,
											900, 200,
											10, 150, 100,
											$fg, $bg, 1, 1, 1);

?>


<?php

	mkImgTagFrom($imgsrc1);
	mkImgTagFrom($imgsrc2);
	mkImgTagFrom($imgsrc3);

?>

<table>
	<tr>
		<td style="<?php mkBackgroundFrom($imgsrc3, 900, 200); ?>">
			<center>jeppajees</center>
		</td>
	</tr>
	<tr>
		<td style="<?php mkBackgroundFrom($imgsrc2, 900, 200); ?>">
			<center>
				<div style="color: red;"><H1>Tervetuloa!</H1></div>
			</center>
		</td>
	</tr>
</table>