<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 2017-10-13
 * Time: 1:07 AM
 */

namespace Humber\Validation\Rules;


use Humber\Validation\Rule;

class UrlRule extends Rule
{

    const RULETYPE = "url";
    private static $ruleInstance;

    /**
     * UrlRule constructor.
     */
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
            self::$ruleInstance = new UrlRule();
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
        return !filter_var($request[$field], FILTER_VALIDATE_URL) ? (is_null($message) ? "'$field' is not a valid url" : $message) : null;
    }
}