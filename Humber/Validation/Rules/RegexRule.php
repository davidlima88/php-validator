<?php
/**
 * Created by PhpStorm.
 * User: vijay
 * Date: 2017-10-13
 * Time: 1:26 AM
 */

namespace Humber\Validation\Rules;


use Humber\Validation\Rule;

class RegexRule extends Rule
{
    const RULETYPE = "regex";
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
            self::$ruleInstance = new RegexRule();
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
        if (is_array($options) && preg_match("/^((?:(?:[^?+*{}()[\]\\|]+|\\.|\[(?:\^?\\.|\^[^\\]|[^\\^])(?:[^\]\\]+|\\.)*\]|\((?:\?[:=!]|\?<[=!]|\?>)?(?1)??\)|\(\?(?:R|[+-]?\d+)\))(?:(?:[?+*]|\{\d+(?:,\d*)?\})[?+]?)?|\|)*)$/", $options[0]))
            return !preg_match($options[0], $request[$field]) ? (is_null($message) ? "'$field' doesn't match the regular expression given" : $message) : null;
        else
            throw new \Exception('Rule \'regex\' needs one parameter with a valid regular expression to evaluate, usage example (regex:/^\/[\s\S]+\/$/)');
    }
}