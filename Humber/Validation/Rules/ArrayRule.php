<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 2017-10-13
 * Time: 1:12 AM
 */

namespace Humber\Validation\Rules;


use Humber\Validation\Rule;

class ArrayRule extends Rule
{
    const RULETYPE = "array";
    private static $ruleInstance;

    public function __construct()
    {
        $this->ruleType = self::RULETYPE;
    }

    /**
     * @return Rule
     */
    static function getInstance()
    {
        if (!isset(self::$ruleInstance)) {
            self::$ruleInstance = new ArrayRule();
        }
        return self::$ruleInstance;
    }

    /**
     * @param array $request
     * @param string $field
     * @param array|null $options
     * @return boolean
     */
    function evaluate(array $request, string $field, array $options = null, string $message = null)
    {
        return !is_array($request[$field]) ? (is_null($message) ? "'$field' is not an array" : $message) : null;
    }
}