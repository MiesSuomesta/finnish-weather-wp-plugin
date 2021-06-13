<?php

include ("gdFunctions.php");

function mkImgTagFrom($imgsrc)
{
	echo '<image src="' . $imgsrc . '" /><br>';
	
}

$imgsrc1 = createDirectionImage(100, 100, 30,  4);
//$imgsrc1 = createDirectionImage(100, 100, -45,  3);
$imgsrc2 = createDirectionImage(100, 100, 145, 3);
$imgsrc3 = createDirectionImage(300, 250, 80, 10);

?>


<?php

	mkImgTagFrom($imgsrc1);
	mkImgTagFrom($imgsrc2);
	mkImgTagFrom($imgsrc3);

?>