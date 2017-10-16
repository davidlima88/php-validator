<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 2017-10-13
 * Time: 1:09 AM
 */

namespace Humber\Validation\Rules;


use Humber\Validation\Rule;

class AlphaNumRule extends Rule
{
    const RULETYPE = "alpha_num";
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
            self::$ruleInstance = new AlphaNumRule();
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
        return !ctype_alnum($request[$field]) ? (is_null($message) ? "'$field' is not a valid alphanumeric string" : $message) : null;
    }
}