<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2017-10-11
 * Time: 2:17 PM
 */

namespace Humber\Validation\Rules;

use Humber\Validation\Rule;

class EmailRule extends Rule
{
    const RULETYPE = "email";
    private static $ruleInstance;

    /**
     * EmailRule constructor.
     */
    private function __construct()
    {
        $this->ruleType = self::RULETYPE;
    }

    /**
     * @return EmailRule
     */
    public static function getInstance()
    {
        if (!isset(self::$ruleInstance)) {
            self::$ruleInstance = new EmailRule();
        }
        return self::$ruleInstance;
    }

    /**
     * @param array $request
     * @param string $field
     * @param array|null $options
     * @param string|null $message
     * @return string|null
     */
    function evaluate(array $request, string $field, array $options = null, string $message = null)
    {
        return !filter_var($request[$field], FILTER_VALIDATE_EMAIL) ? (is_null($message) ? "'$field' is not a valid email" : $message) : null;
    }
}