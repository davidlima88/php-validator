<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 2017-10-13
 * Time: 1:20 AM
 */

namespace Humber\Validation\Rules;


use Humber\Validation\Rule;

class JsonRule extends Rule
{
    const RULETYPE = "json";
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
        if(!isset(self::$ruleInstance)){
            self::$ruleInstance = new JsonRule();
        }

        return self::$ruleInstance;
    }

    /**
     * @param array $request
     * @param string $field
     * @param array|null $options
     * @return string|null
     */
    function evaluate(array $request, string $field, array $options = null, string $message = null)
    {
        json_decode($request[$field]);
        return json_last_error() != JSON_ERROR_NONE ? (is_null($message) ? "'$field' is not a valid json" : $message) : null;
    }
}