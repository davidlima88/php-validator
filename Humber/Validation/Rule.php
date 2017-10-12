<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2017-10-11
 * Time: 2:14 PM
 */

namespace Humber\Validation;

abstract class Rule
{
    protected $ruleType;

    /**
     * @param array $request
     * @param string $field
     * @param array|null $options
     * @param array $errors
     * @param string|null $message
     * @return array
     * @throws \Exception
     */
    function validate(array $request, string $field, array $options = null, array $errors = [], string $message = null)
    {
        if (array_key_exists($field, $request)) {
            $result = $this->getInstance()->evaluate($request, $field, $options, $message);
            if (!is_null($result)) {
                $errors[$field][$this->ruleType] = $result;
            }
        } else {
            /** @var string $field */
            throw new \Exception("'$field' field not found in request");
        }
        return $errors;
    }

    /**
     * @param array $request
     * @param string $field
     * @param array|null $options
     * @return boolean
     */
    abstract function evaluate(array $request, string $field, array $options = null, string $message = null);

    /**
     * @return Rule
     */
    abstract static function getInstance();
}