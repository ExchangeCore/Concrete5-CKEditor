<?php

namespace Concrete\Package\CommunityCkeditor\Src\Utility;

class BackwardsCompatibilityUtility
{

    /**
     * json_last_error_msg was not available until PHP 5.5, so we're using this until requirements are raised
     * @return string
     */
    public static function json_last_error_msg()
    {
        if (!function_exists('json_last_error_msg')) {
            $errors = array(
                JSON_ERROR_NONE => null,
                JSON_ERROR_DEPTH => t('Maximum stack depth exceeded'),
                JSON_ERROR_STATE_MISMATCH => t('Underflow or the modes mismatch'),
                JSON_ERROR_CTRL_CHAR => t('Unexpected control character found'),
                JSON_ERROR_SYNTAX => t('Syntax error, malformed JSON'),
                JSON_ERROR_UTF8 => t('Malformed UTF-8 characters, possibly incorrectly encoded')
            );
            $error = json_last_error();
            return array_key_exists($error, $errors) ? $errors[$error] : t("Unknown error: %s", $error);
        }
        return json_last_error_msg();
    }
}