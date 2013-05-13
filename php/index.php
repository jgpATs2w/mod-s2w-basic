<?
namespace s2w\basic;
/** REQUIRED IN ANY MODULE **/
require 's2w.basic.mod.php';
/** END REQUIRED **/?>
<h1>Basic module</h1>
This module should be required in any module or final script.<br>
To use it:
<ol>
	<li>require to s2w.basic.mod.php</li>
	<li>copy config.ini to the same directory of the script and use the [Modules] section to require more modules other than log and error</li>
	
</ol>

<h2>Settings</h2>
The example shows the configuration in [Log] section<br>
<?
print_r(config_get('Log'));
?>
<h2>log</h2>
<?
//optionally these options can change
\s2w\log\info('hola info');

echo 'el mensaje anterior se ha almacenado en '.__DIR__.'/'.\s2w\log\Options::$file;
?>
<h2>error</h2>
<?
trigger_error('aqui mando un warning voluntariamente');
?>