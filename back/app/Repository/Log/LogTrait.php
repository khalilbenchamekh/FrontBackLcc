<?php
namespace App\Repository\Log;
use function base_path;
trait LogTrait
{
    public function Log(\Exception $exception) {

        $this->_Log($exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getCode());
    }
    private function _Log($message, $file, $line, $code) {
        try {
            $logDir = base_path() . "/logs/";
            $logFile = "log_" . date('d_m_Y') . ".txt";
            if (!file_exists($logDir)) {
                mkdir($logDir);
            }
            $fs = fopen($logDir . $logFile, "a+");
            fwrite($fs, date('d/m/Y H:i:s') . ' => ' . $message . ' on "' . $file . ' on line ' . $line . '" with code ' . $code . PHP_EOL);
            fclose($fs);
        } catch (\Exception $ex) {
            throw new \Exception($ex->getMessage(), $ex->getCode(), $ex->getPrevious());
        }
    }
}
