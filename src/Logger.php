<?php
/*
    Project: Jinx Framework (https://github.com/azazelm3dj3d/jinx)
    Author: azazelm3dj3d (https://github.com/azazelm3dj3d)
    License: BSD 2-Clause
*/

namespace Jinx;

class Logger {
    public function jinxLog(string $message, string $dest) {
        /*
            Log message to specific destination
        */

        switch ($dest) {
            case "terminal":
                echo '['.date('Y-m-d H:i:s').'] '.$message.PHP_EOL;
                break;
            case "console":
                if (is_array($message)) {
                    $message = implode(',', $message);
                }

                echo "<script>console.log('[".date('Y-m-d H:i:s')."] ".$message."');</script>";
                break;
            case "all":
                echo "[".date('Y-m-d H:i:s')."] ".$message.PHP_EOL;
                echo "<script>console.log('[".date('Y-m-d H:i:s')."] ".$message."');</script>";
                break;
        }
    }
}

?>
