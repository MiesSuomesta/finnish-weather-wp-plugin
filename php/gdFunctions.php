<?php

	require_once("animatedwebp.php");


	function comment($txt)
	{
		echo "<!---- $txt ---->\n";
	}

	function createImgTag($type, $from)
	{
		$tag = "data:image/". $type .";base64," . base64_encode($from) . "";
		return $tag;
	}

	function getPi($deg)
	{
		return ($deg/360.0) * 2 * pi();
	}
	
	function draw_vector_line($img, $x1, $y1, $x2, $y2, $length, $dx, $dy, $s, $c)
	{
		$x = $x1;
		$y = $y1;
		
		$mdx = $dx / $length;
		$mdy = $dy / $length;
		
		while( $length > 0 )
		{
			$x += $mdx;
			$y += $mdy;
			imageellipse($img, $x, $y, $s, $s, $c);
			$length--;
		}
	}

	function draw_vector($img, $x, $y, $deg, $len, $color, $thickness = 1, $mirror = 1)
	{
		//   va   vi   va
		//  s    c    t
		//   hy   hy   vi
		
		//$deg = $deg ;

		if ($mirror) {
			$len *= 2;
		}
		
		$dx = $len * cos(getPi($deg));
		$dy = $len * sin(getPi($deg));

		if ($mirror) {
			$destX1 = $x - ($dx / 2);
			$destY1 = $y - ($dy / 2);
			$destX2 = $x + ($dx / 2);
			$destY2 = $y + ($dy / 2);
		} else {
			$destX1 = $x;
			$destY1 = $y;
			$destX2 = $x + $dx;
			$destY2 = $y + $dy;
		}

		draw_vector_line($img, $destX1, $destY1, $destX2, $destY2, $len, $dx, $dy, $thickness, $color);

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
		imagealphablending($img, true);
		imagesavealpha($img, true);
		
		$color_transparent = imagecolorallocatealpha($img, 0, 0, 0, 127);
		imageFill($img, 0,0, $color_transparent);
		
		$color_red_bg = imagecolorallocatealpha($img, 100, 0, 0, 0);

		$color_red_fg = imagecolorallocatealpha($img, 255, 0, 0, 0);

		imagefilledellipse($img, $wc, $hc, $width, $height, $color_red_bg);

		$wc = $width  /2;
		$hc = $height /2;


		$img = draw_arrow($img, $width, $height, $deg, 35 , $color_red_fg, $thickness);

		return generate_png($img, 1);
	}

	function minmaxrgba($val)
	{
		if ($val < 0  ) $val = 0;
		if ($val > 255) $val = 255;
		return $val;
	}
	
	function imageAllocColor($img, $r, $g, $b, $a)
	{
		return imagecolorallocatealpha($img,
								minmaxrgba($r),
								minmaxrgba($g),
								minmaxrgba($b),
								minmaxrgba($a));
		
	}

	function imageAllocColorStr($img, $clr)
	{
		return imageAllocColor($img,
								$clr['r'],
								$clr['g'],
								$clr['b'],
								$clr['a']);
	}

	function calc_color_delta($loops, $start, $stop)
	{
		
		$dr = ($stop['r'] -  $start['r']) / $loops;
		$dg = ($stop['g'] -  $start['g']) / $loops;
		$db = ($stop['b'] -  $start['b']) / $loops;
		$da = ($stop['a'] -  $start['a']) / $loops;
		
		$delta['r'] = $dr;
		$delta['g'] = $dg;
		$delta['b'] = $db;
		$delta['a'] = $dr;
		var_dump_with_title("Calc Delta", $delta);
		
		return $delta;
	}

	function calc_color_with_delta($loop, $start, $delta)
	{
		
		$dr = $start['r'] + ($delta['r'] * $loop);
		$dg = $start['g'] + ($delta['g'] * $loop);
		$db = $start['b'] + ($delta['b'] * $loop);
		$da = $start['a'] + ($delta['a'] * $loop);
		
		$now['r'] = $dr;
		$now['g'] = $dg;
		$now['b'] = $db;
		$now['a'] = $dr;
		
		return $now;
	}

	function var_dump_with_title($t, $v)
	{
		
		ob_start();

		var_dump($v);
		
		$dumpData = ob_get_clean();
		
		comment("$t");
		comment($dumpData);

	}
	
	function calc_random_color_with_delta($loop, $start, $delta)
	{
		
		$dr = $start['r'] +  rand(0, $delta['r'] * $loop);
		$dg = $start['g'] +  rand(0, $delta['g'] * $loop);
		$db = $start['b'] +  rand(0, $delta['b'] * $loop);
		$da = $start['a'] +  rand(0, $delta['a'] * $loop);
		
		$now['r'] = minmaxrgba($dr);
		$now['g'] = minmaxrgba($dg);
		$now['b'] = minmaxrgba($db);
		$now['a'] = minmaxrgba($dr);
		
		var_dump_with_title("Start", $start);
		var_dump_with_title("Delta", $delta);
		var_dump_with_title("Now", $now);
		return $now;
	}


	function makeBarGrowFromCenter(	$barWidth, $barHeight, $barHeightMaxRand, $fg)
	{
		$randBarHeight = ($barHeight - $barHeightMaxRand) + rand(0, $barHeightMaxRand);

		$randBarHeightHalf = $randBarHeight / 2;
		$hcenter = $barHeight / 2;

		$img = imagecreatetruecolor($barWidth, $randBarHeight);
		$fgcolor = imageAllocColorStr($img, $fg);
		imageFill($img, 0, 0, $fgcolor);

		return $img;
	}

	function generateBarsGrowCenter(	$frameNro, $frameNroMax,
										$width, $height,
										$barWidth, $barHeight, $barHeightMaxRand,
										$fgColor, $bgColor)
	{
		$wc = $width  /2;
		$hc = $height /2;

		$img = imagecreatetruecolor($width, $height);
		imagealphablending($img, true);
		imagesavealpha($img, true);

		$bgcolor = imageAllocColorStr($img, $bgColor);
		$fgcolor = imageAllocColorStr($img, $fgColor);

		imageFill($img, 0,0, $bgcolor);

		$loops = $width / $barWidth;
		$startColor = $bgColor;
		$stopColor  = $fgColor;
		
		$colorDelta = calc_color_delta($frameNroMax, $startColor, $stopColor);

		$maxloops = $loops;
		$now = $fgColor;

		$loop = 0;
	//	$loop = $loops - 1;

		while ( $loop < $loops )
		{
			$xtop = ($loop * $barWidth);

			$now = calc_random_color_with_delta($frameNro, $startColor, $colorDelta);
		
			$barImg = makeBarGrowFromCenter($barWidth, $height, $barHeightMaxRand, $now);
			
			$fgImgHeight = imagesy($barImg);
			$ytop = ($height - $fgImgHeight) / 2;

			imagecopy($img, $barImg, $xtop, $ytop, 0, 0, $barWidth, $fgImgHeight);
			imagedestroy($barImg);
			$loop+=1;
		}

		return $img;
	
	}

	function generateBarsGrowCenterAnimation($framecnt, $duration = 100,
										$width, $height,
										$barWidth, $barHeight, $barHeightMaxRand,
										$fgColor, $bgColor, $tag)
	{
		$anim = new animatedwebp();
		$frame = $frameMax = $framecnt;

		while($frame--) {
			
			$imgframe = generateBarsGrowCenter(	$frame, $frameMax,
												$width, $height,
												$barWidth, $barHeight, $barHeightMaxRand,
												$fgColor, $bgColor);

			$anim->insert_image_frame($imgframe, $duration);
		}
		
		/* Animate --------------------------------- */
		$anim->outputWidth = $width;
		$anim->outputHeight = $height;
		$img = $anim->generate_webp_image_rawdata();
		$rv = generate_webp($img, 3);
		return $rv;
		
	}

	function generate_gif($img, $tag)
	{
		ob_start();

		imagegif($img);
	
		$rawData = ob_get_clean();
		$rv = $rawData;
		
		if ($tag)
			$rv = createImgTag("gif", $rawData);
		
		return $rv;
	}

	function generate_png($img, $tag)
	{
		ob_start();

		imagepng($img);
	
		$rawData = ob_get_clean();
		$rv = $rawData;
		
		if ($tag)
			$rv = createImgTag("png", $rawData);
		
		return $rv;
	}

	function generate_webp($img, $tag)
	{

		ob_start();

		if ($tag & 2)
			echo $img;
		else
			imagewebp($img);
	
		$rawData = ob_get_clean();
		$rv = $rawData;
		
		if ($tag & 1)
			$rv = createImgTag("webp", $rawData);
		
		return $rv;
	}

?>