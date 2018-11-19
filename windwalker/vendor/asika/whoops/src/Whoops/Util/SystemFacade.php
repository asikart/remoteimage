<?php
/**
 * Whoops - php errors for cool kids
 * @author Filipe Dobreira <http://github.com/filp>
 */

namespace Whoops\Util;

class SystemFacade
{
    /**
     * Turns on output buffering.
     *
     * @return bool
     */
    public function startOutputBuffering()
    {
        return ob_start();
    }

    /**
     * @param callable $handler
     * @param int      $types
     *
     * @return callable|null
     */
    public function setErrorHandler($handler, $types = 'use-php-defaults')
    {
        if (!is_callable($handler)) {
            throw new \InvalidArgumentException('$handler must be a callable.');
        }

        // Workaround for PHP 5.5
        if ($types === 'use-php-defaults') {
            $types = E_ALL | E_STRICT;
        }
        return set_error_handler($handler, $types);
    }

    /**
     * @param callable $handler
     *
     * @return callable|null
     */
    public function setExceptionHandler($handler)
    {
        if (!is_callable($handler)) {
            throw new \InvalidArgumentException('$handler must be a callable.');
        }

        return set_exception_handler($handler);
    }

    /**
     * @return void
     */
    public function restoreExceptionHandler()
    {
        restore_exception_handler();
    }

    /**
     * @return void
     */
    public function restoreErrorHandler()
    {
        restore_error_handler();
    }

    /**
     * @param callable $function
     *
     * @return void
     */
    public function registerShutdownFunction($function)
    {
        if (!is_callable($function)) {
            throw new \InvalidArgumentException('$function must be a callable.');
        }

        register_shutdown_function($function);
    }

    /**
     * @return string|false
     */
    public function cleanOutputBuffer()
    {
        return ob_get_clean();
    }

    /**
     * @return int
     */
    public function getOutputBufferLevel()
    {
        return ob_get_level();
    }

    /**
     * @return bool
     */
    public function endOutputBuffering()
    {
        return ob_end_clean();
    }

    /**
     * @return void
     */
    public function flushOutputBuffer()
    {
        flush();
    }

    /**
     * @return int
     */
    public function getErrorReportingLevel()
    {
        return error_reporting();
    }

    /**
     * @return array|null
     */
    public function getLastError()
    {
        return error_get_last();
    }

    /**
     * For php5.3 version, @see https://stackoverflow.com/a/12112589
     *
     * @param int $httpCode
     *
     * @return int
     */
    public function setHttpResponseCode($httpCode)
    {
        static $theHeader = null;

        if($theHeader) {
            return $theHeader;
        }

        $theHeader = $httpCode;

        header('HTTP/1.1 '.$httpCode);

        return $httpCode;
    }

    /**
     * @param int $exitStatus
     */
    public function stopExecution($exitStatus)
    {
        exit($exitStatus);
    }
}
