<?php
/*
    Project: Jinx Framework (https://github.com/battleoverflow/jinx)
    License: BSD 2-Clause

    Author: battleoverflow (https://github.com/battleoverflow)
*/

namespace Jinx;

class Logger {
    public function consoleLog(string $message) {
        /*
            Log message to developer tools console
        */
        
        if (is_array($message)) {
            $message = implode(',', $message);
        }

        echo "<script>console.log('[".date('Y-m-d H:i:s')."]".$message."' );</script>";
    }

    public function terminalLog(string $message) {
        /*
            Log message to terminal
        */

        echo '['.date('Y-m-d H:i:s').'] '.$message.PHP_EOL;
    }
}

?>
