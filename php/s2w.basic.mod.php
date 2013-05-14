<?
namespace s2w\log;

Class Options{
	static $sep0 = "|";
	static $sep1 = "#";
	static $file = "default.log";
	static $eol = "<br>";
	static $echo = true;
	static $debug = true;
}
function readSettings(){
	if(function_exists('\s2w\basic\config_get')){
		if($section = \s2w\basic\config_get('Log')){
			Options::$sep0 = $section['sep0'];
			Options::$sep1 = $section['sep1'];
			Options::$file = $section['file'];
			Options::$eol = $section['eol'];
			Options::$echo = (bool)$section['echo'];
			Options::$debug = (bool)$section['debug'];
		}
	}
}
/**
 * @param string $m mensaje
 */
function info($m){
	echo _output(_getOutPut($m, 'info'));
	return true;
}	
function debug($m){
	if(Options::$debug) echo _output(_getOutPut($m, 'debug'));
	return true;
}
function error($m){
	echo _output(_getOutPut($m, 'error'));
	return true;
}
function _getOutPut($m, $tag){
	$S = explode("\.",basename($_SERVER['PHP_SELF']));
	$s=time().Options::$sep0.$tag.Options::$sep0.$S[0];
	$s.=Options::$sep1.$m;
	return $s;
}
function _getDate(){ return date("c"); }
function _output($s){
	_echo($s);
		
	$fid = fopen(Options::$file, "a");
	if($fid){
		fwrite($fid, $s."\n");
		fclose($fid);
	}else {
		_echo('could not open file '.getcwd().'/'.Options::$file);
	}
	
	
}
function _echo($m){
	if(Options::$echo) echo $m.Options::$eol;
}

namespace s2w\error;

function ErrorHandler($errno, $errstr, $errfile, $errline){
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }

    switch ($errno) {
    case E_USER_ERROR:
        \s2w\log\error("error fatal [$errno] $errstr");
        exit(1);
        break;

    case E_USER_WARNING:
        \s2w\log\info("warning [$errno] $errstr");
        break;

    case E_USER_NOTICE:
        \s2w\log\info("notice [$errno] $errstr");
        break;

    default:
        \s2w\log\info("notice [$errno] $errstr");
        break;
    }
    /* Don't execute PHP internal error handler */
    return true;
}
set_error_handler('\s2w\error\ErrorHandler');

namespace s2w\basic;

Class Settings{
	static $_settings = array();
}
function config_load($file = null){
	if($file == null) $file = 'config.ini';
	
	if(file_exists($file)){
		Settings::$_settings = parse_ini_file($file,1);
		return true;
	}else 
		trigger_error('config.ini not found');	
	return false;
}
function config_get($section, $key = null){
	if($key === null){
		if(array_key_exists($section, Settings::$_settings))
			return Settings::$_settings[$section];
	}else if(array_key_exists($key, Settings::$_settings[$section]))
		return Settings::$_settings[$section][$key];
	
	return false;
}
function config_set($section, $key, $value){
	Settings::$_settings[$section][$key] = $value;
}

/**
 * @param {array} modules array of strings with names of modules
 */
function load_modules(){
	foreach (config_get('Modules') as $mod => $file){
		require_once $file;
	}
}

if(config_load()){
	load_modules();
	\s2w\log\readSettings();
}
?>