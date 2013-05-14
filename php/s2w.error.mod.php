<?
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
?>