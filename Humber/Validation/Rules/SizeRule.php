<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2017-10-11
 * Time: 7:45 PM
 */

namespace Humber\Validation\Rules;

use Humber\Validation\Rule;

class SizeRule extends Rule
{
    const RULETYPE = "size";
    private static $ruleInstance;

    /**
     * SizeRule constructor.
     */
    private function __construct()
    {
        $this->ruleType = self::RULETYPE;
    }

    /**
     * @return SizeRule
     */
    public static function getInstance()
    {
        if (!isset(self::$ruleInstance)) {
            self::$ruleInstance = new SizeRule();
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
        if (is_array($options) && is_numeric($options[0])) {
            $valid = false;
            $valid = is_array($request[$field]) ? count($request[$field]) == $options[0] : $valid;
            $valid = is_numeric($request[$field]) ? $request[$field] == $options[0] : $valid;
            $valid = is_string($request[$field]) ? strlen($request[$field]) == $options[0] : $valid;
            $valid = is_string($request[$field]) && is_file($request[$field]) ? filesize($request[$field])/1024 == $options[0] : $valid;
            return !$valid ? (is_null($message) ? "'$field' size is different than $options[0] " : $message) : null;
        }
        else
            throw new \Exception('Rule \'size\' needs one parameter for the size, usage example (size:5)');
    }

}