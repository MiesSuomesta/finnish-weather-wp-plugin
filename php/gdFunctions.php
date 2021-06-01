<?php

?>
		
	
<?php

	function createImgTag($from)
	{
		$tag = "<img src='data:image/png;base64," . btoa($from) . "' />";
		return $tag;
	}

	function createDirectionImage($width, $height, $deg)
	{
	
		$img = imagecreatetruecolor($width, $height);
		imagesavealpha($img, true);
		
		$color_transparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
		imageFill($img, 0,0, $color_transparent);
		
		$color_red_bg = imagecolorallocatealpha($img, 256/4, 0, 0, 127);

		$color_red_fg = imagecolorallocatealpha($img, 255, 0, 0, 127);

		imagefilledellipse($img, $width, $height, $width, $height, $color_red_bg);

		$wc = $width  /2;
		$hc = $height /2;

		$dw = $wc * cos($deg);
		$dh = $hc * sin($deg);
		
		imageline($img, $wc, $hc, $dw, $dh, $color_red_fg);


		ob_start();

		header("Content-Type: image/png");
		imagepng($img);
	
		$rawData = ob_get_clean();

		return createImgTag($rawData);
	}
?>