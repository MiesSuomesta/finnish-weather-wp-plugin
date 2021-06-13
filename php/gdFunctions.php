<?php

	function createImgTag($from)
	{
		$tag = "data:image/png;base64," . base64_encode($from) . "";
		return $tag;
	}

	function getPi($deg)
	{
		return ($deg/360.0) * 2 * pi();
	}

	function draw_vector($img, $x, $y, $deg, $len, $color, $thickness = 1, $mirror = 1)
	{
		//   va   vi   va
		//  s    c    t
		//   hy   hy   vi
		
		//$deg = $deg ;
		
		$dx = $len * cos(getPi($deg));
		$dy = $len * sin(getPi($deg));

		if ($mirror) {
			$destX1 = $x - $dx;
			$destY1 = $y - $dy;
		} else {
			$destX1 = $x;
			$destY1 = $y;
		}
		
		$destX2 = $x + $dx;
		$destY2 = $y + $dy;
		$thick = ($thickness / 2) - 0.5;
		
		imagesetthickness($img, $thickness);
		imageline($img, $destX1, $destY1, $destX2, $destY2, $color);

		$rv["x1"] = $destX1;
		$rv["y1"] = $destY1;
		$rv["x2"] = $destX2;
		$rv["y2"] = $destY2;
		$rv["dx"] = $dx;
		$rv["dy"] = $dy;
		
		return $rv;
	}

	function draw_arrow($img, $width, $height, $deg, $sakaraAngle, $color, $thick)
	{
		$wcenter = $width  / 2;
		$hcenter = $height / 2;

		$len = $width  / 3;

		$s1deg = $deg + 180 + $sakaraAngle;
		$s2deg = $deg + 180 - $sakaraAngle;

		/* Pääviiva */
		$mainvec = draw_vector($img, $wcenter, $hcenter, $deg, $len, $color, $thick, 1);
		
		$startx = $mainvec['x2'];
		$starty = $mainvec['y2'];
		
		$arr1vec = draw_vector($img, $startx, $starty, $s1deg, $len, $color, $thick, 0);
		$arr2vec = draw_vector($img, $startx, $starty, $s2deg, $len, $color, $thick, 0);

		return $img;
	}

	function createDirectionImage($width, $height, $deg, $thickness)
	{
	
		$wc = $width  /2;
		$hc = $height /2;

		$img = imagecreatetruecolor($width, $height);
		imagesavealpha($img, true);
		
		$color_transparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
		imageFill($img, 0,0, $color_transparent);
		
		$color_red_bg = imagecolorallocatealpha($img, 256/4, 0, 0, 0);

		$color_red_fg = imagecolorallocatealpha($img, 255, 0, 0, 0);

		imagefilledellipse($img, $wc, $hc, $width, $height, $color_red_bg);

		$wc = $width  /2;
		$hc = $height /2;


		$img = draw_arrow($img, $width, $height, $deg, 35 , $color_red_fg, $thickness);

		ob_start();

		imagepng($img);
	
		$rawData = ob_get_clean();

		return createImgTag($rawData);
	}

?>