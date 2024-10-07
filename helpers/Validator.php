<?php
namespace Helpers;

class Validator {
    public static function sanitize($data) {
        return htmlspecialchars(strip_tags($data));
    }

    public static function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function isEmpty($fields) {
        foreach ($fields as $field) {
            if (empty(trim($field))) {
                return true;
            }
        }
        return false;
    }
}
?>
