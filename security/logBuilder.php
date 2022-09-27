<?php

@$fileSize = (filesize('security/reports/log.txt') / 1024 / 1024); //Obtener peso del archivo en MB

if ($fileSize > 0.02) {
    $counter = +1;
    $current_Date = date('d-m-Y', time());
    copy("security/reports/log.txt", "security/reports/Completados/$current_Date $counter.txt");
    $clear_file = fopen("security/reports/log.txt", "w+");
    fwrite($clear_file, "");
    fclose($clear_file);
} else {
    class Log
    {
        private $fileLog;
        function __construct($path)
        {
            $this->fileLog = fopen($path, "a");
        }
        function writeLine($type, $message)
        {
            date_default_timezone_set("America/Argentina/Buenos_Aires");
            $date = date('d-m-Y H:i:s', time());
            fputs($this->fileLog, "[" . $type . "][" . $date . "]: " . $message . "\n");
        }
        function close()
        {
            fclose($this->fileLog);
        }
    }
}
