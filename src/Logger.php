<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    License: BSD 2-Clause

    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
*/

namespace Jinx;

class Logger
{
    public function consoleLog(string $message)
    {
        /*
            Log message to developer tools console
        */
        
        if (is_array($message)) {
            $message = implode(',', $message);
        }

        echo "<script>console.log('[".date('Y-m-d H:i:s')."]".$message."' );</script>";
    }

    public function terminalLog(string $message)
    {
        /*
            Log message to terminal
        */

        echo '['.date('Y-m-d H:i:s').'] '.$message.PHP_EOL;
    }
}

?>
