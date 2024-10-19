<?php

function genHeader($title){
	echo <<<HEADER
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>$title</title>
	<link rel="stylesheet" href="assets/icons/font/bootstrap-icons.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<script src="assets/js/jquery-3.7.0.min.js"></script>
</head>
<body>
HEADER;
}
function genFooter()
	{
		$year = date("Y");
		echo <<<FOOTER
	</main>
	<footer>
		<div class="container d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
			<div class="col-md-4 d-flex align-items-center">
				<div class="text-center mb-3 mb-md-0">
					<span class="text-muted">© $year Site Name</span>
				</div>
			</div>
			<div class="col-md-4 justify-content-end d-flex gap-3">
				<div>
					<a href="#"><i class="bi bi-facebook me-3 social-icon"></i></a>
				</div>
				<div>
					<a href="#"><i class="bi bi-google me-3 social-icon"></i></a>
				</div>
				<div>
					<a href="#"><i class="bi bi-twitter-x me-3 social-icon"></i></a>
				</div>	
			</div>
		</div>
	</footer>
	    <script src="assets/js/bootstrap.min.js"></script>
	</body>
</html>
FOOTER;
}

function clean($input)
{
		$data = trim($input);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
}

function formatDate($timestamp)
{
	return date("F d, Y", $timestamp);
}

function timeElapsed($datetime, $full = false)
{
	$now = new DateTime();
	$ago = new DateTime($datetime);
	$diff = $now->diff($ago);

	$diff->w = floor($diff->d / 7);
	$diff->d -= $diff->w * 7;

	$string = [
		'y' => 'year',
		'm' => 'month',
		'w' => 'week',
		'd' => 'day',
		'h' => 'hour',
		'i' => 'minute',
		's' => 'second',
	];
	foreach ($string as $k => &$v) {
		if ($diff->$k) {
			$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
		} else {
			unset($string[$k]);
		}
	}

	if (!$full) $string = array_slice($string, 0, 1);
	return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function formatFileSize($bytes, $decimals = 2)
{
	$size = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
	$factor = floor((strlen($bytes) - 1) / 3);
	return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . $size[$factor];
}