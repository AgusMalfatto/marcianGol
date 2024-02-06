<?php
/* ------------------------ ERROR LOG FUNCTION ------------------------ */

/* 

    It needs an error message and it saves it on error.log file

*/

function set_error_log($message) {
    # Access to the last call
    $caller = debug_backtrace()[1];
    # Access to the file name and the line.
    $file = isset($caller['file']) ? $caller['file'] : 'unknown file';
    $line = isset($caller['line']) ? $caller['line'] : 'unknown line';

    $logFilePath = '../../logs/error.log';

    $timestamp = date('Y-m-d H:i:s');

    $logMessage = "[$timestamp] | [$file:$line] | $message\n";

    error_log($logMessage, 3, $logFilePath);
}

?>
