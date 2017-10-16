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
     * @return Rule
     */
    static function getInstance()
    {
        if (!isset(self::$ruleInstance)) {
            self::$ruleInstance = new DigitsRule();
        }
        return self::$ruleInstance;
    }

    /**
     * @param array $request
     * @param string $field
     * @param array|null $options
     * @param string|null $message
     * @return string|null
     * @throws \Exception
     */
    function evaluate(array $request, string $field, array $options = null, string $message = null)
    {
        if (is_array($options) && ctype_digit($options[0]))
            return !(ctype_digit($request[$field]) && strlen($request[$field]) == $options[0]) ? (is_null($message) ? "'$field' is not a valid number or its length is different than $options[0] " : $message) : null;
        else
            throw new \Exception('Rule \'digits\' needs one parameter for the number of digits, usage example (digits:5)');
    }
}