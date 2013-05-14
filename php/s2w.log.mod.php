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



?>