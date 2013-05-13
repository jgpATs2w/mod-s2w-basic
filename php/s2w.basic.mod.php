<?
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