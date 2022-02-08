<?php 

namespace app\ext;

class ErrorsHandler
{
    public static function fatal_handler()
    {
        $errors = error_get_last();
        !is_null( $errors ) && self::return_error( $errors );
    }

    /**
     * Вернуть шаблон с ошибкой
     */
    protected static function return_error( array $errors )
    {
        file_put_contents( substr(__DIR__, 0, -4)."\\logs\\".date("Y-m-d").".txt", "\n".date("Y-m-d H:i:s") . " - NEW ERROR [".$errors['type']."] \n FILE - ".$errors['file']." \n MESSAGE - ".$errors['message'] . " \n LINE - ".$errors['line'], FILE_APPEND | LOCK_EX );
        die("Exception script, check web server logs");
    }

    public static function error_handler( $error_level, $error_message, $error_file, $error_line )
    {
        $error = [
            "lvl" => $error_level,
            "message" => $error_message,
            "file" => $error_file,
            "line" => $error_line
        ];

        /**
         * Отлавливаем проблемы с парсингом и фатальной ошибкой
         */
        switch ($error_level) 
        {
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_PARSE:
                self::return_error( $error );
                break;
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
                self::return_error( $error );
                break;
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
            case E_NOTICE:
            case E_USER_NOTICE:
            case E_STRICT:
            default:
        }
    }

    public function setErrors()
    {
        set_error_handler([$this, "error_handler"]);
        register_shutdown_function([$this, 'fatal_handler']);
    }
}