<?php
// declare(strict_types = 1);
use Swift\Diagnosis;
use Swift\Core;
use Swift\App;

/**
 */
defined('swift_path') ?: define('swift_path', './swift');
defined('swift_diagnosis') ?: define('swift_diagnosis', true);
defined('app_path') ?: define('app_path', './program');
defined('app_debug') ?: define('app_debug', false);

/**
 * string function error(string $data)
 */
function error(string $data): string {
	$patterns = array('/__message__/', '/NO/', '/\[(.*?)\]/s');
	$datas = array($data, '<span class="red">NO</span>', '[<span class="doc">$1</span>]');
	$html = <<<'code'
<!doctype html>
<html>
	<head>
		<title>Swift-Framework Message</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta charset="utf-8" />
		<style type="text/css">
			*{maring:0; padding:0; font-family:'open sans','microsoft yahei'; font-size:16px;}
			body {padding:50px; background-color:#000000; color:#ffffff;}
			div {margin-bottom:2px;}
			.red {color:#ff0000;}
			.doc {color:#888888;}
		</style>
	</head>
	<body>
		__message__
	</body>
</html>		
code;
	//return str_replace($searchs, $datas, $html);
	return preg_replace($patterns, $datas, $html);
}

/**
 */
$file = 'diagnosis.class.php';
$diagnosis = implode('/', array(swift_path, $file));
@include_once $diagnosis;
try{
	$diagnosis = new Diagnosis();
}catch(Throwable $err){
	die(error('System diagnosis program NO found. #_#'));
}
$messages = $diagnosis->fire();
if($messages){
	foreach($messages as &$message){
		$message = '<div>' . $message . '</div>';
	}
	die(error(implode('', $messages)));
}

/**
 */
$bootstrap = implode('/', array('.', swift_path, 'loader'));

/**
 */
$sysHere = implode('/', array($bootstrap, 'core.class.php'));
@include_once $sysHere;
$system = new Core();
$system->fire();

/**
 */
$appHere = implode('/', array($bootstrap, 'app.class.php'));
@include_once $appHere;
$app = new App();
$app->fire();

/**
 * 
 */
//





















	