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
     * @return string
     */
    function evaluate(array $request, string $field, array $options = null, string $message = null)
    {
        // TODO: Implement evaluate() method.
    }

}