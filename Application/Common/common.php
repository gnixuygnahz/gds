<?php
function charsetToUTF8($mixed)
{
	if (is_array($mixed)) {
		foreach ($mixed as $k => $v) {
			if (is_array($v)) {
				$mixed[$k] = charsetToUTF8($v);
			} else {
				$encode = mb_detect_encoding($v, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
				if ($encode == 'EUC-CN') {
					$mixed[$k] = iconv('GBK', 'UTF-8', $v);
				}
			}
		}
	} else {
		$encode = mb_detect_encoding($mixed, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
		if ($encode == 'EUC-CN') {
			$mixed = iconv('GBK', 'UTF-8', $mixed);
		}
	}
	return $mixed;
}


function charsetToGBK($mixed)
{
	$encode = mb_detect_encoding($mixed, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
	//var_dump($encode);
	if ($encode == 'UTF-8') {
		$mixed = iconv('UTF-8', 'GBK', $mixed);
	}
	return $mixed;
}
?>