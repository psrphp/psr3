<?php

declare(strict_types=1);

namespace PsrPHP\Psr3;

use Composer\InstalledVersions;
use Exception;
use Psr\Log\AbstractLogger;
use ReflectionClass;

class LocalLogger extends AbstractLogger
{

    private $log_path;

    public function __construct(string $log_path = null)
    {
        if (is_null($log_path)) {
            if (class_exists(InstalledVersions::class)) {
                $log_path = dirname(dirname(dirname((new ReflectionClass(InstalledVersions::class))->getFileName()))) . '/runtime/log/';
            } else {
                $log_path = __DIR__ . '/runtime/log/';
            }
        }
        if (!is_dir($log_path)) {
            if (false === mkdir($log_path, 0755, true)) {
                throw new Exception('mkdir [' . $log_path . '] failure!');
            }
        }
        $this->log_path = $log_path;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     *
     * @throws \Psr\Log\InvalidArgumentException
     */
    public function log($level, $message, array $context = array())
    {
        error_log('[' . date(DATE_ATOM) . '] ' . str_pad(strtoupper($level), 9, ' ', STR_PAD_LEFT) . ':' . $message . ' ' . json_encode($context, JSON_UNESCAPED_UNICODE) . PHP_EOL, 3, $this->log_path . '/' . date('Y-m-d') . '.log');
    }
}
