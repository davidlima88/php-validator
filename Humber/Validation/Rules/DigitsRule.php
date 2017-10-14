<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 2017-10-13
 * Time: 1:01 AM
 */

namespace Humber\Validation\Rules;


use Humber\Validation\Rule;

class DigitsRule extends Rule
{

    const RULETYPE = "digits";
    private static $ruleInstance;

    /**
     * FilledRule constructor.
     */
    private function __construct()
    {
        $this->ruleType = self::RULETYPE;
    }

    /**
     * @param array $request
     * @param string $field
     * @param array|null $options
     * @return boolean
     */
    function evaluate(array $request, string $field, array $options = null, string $message = null)
    {
        return !filter_var($request[$field], FILTER_VALIDATE_DIGITS) ? (is_null($message) ? "'$field' is not a valid number" : $message) : null;
    }

    /**
     * @return Rule
     */
    static function getInstance()
    {
        if (!isset(self::$ruleInstance)) {
            self::$ruleInstance = new DigitsRule();
        }
        return self::$ruleInstance;
    }
}