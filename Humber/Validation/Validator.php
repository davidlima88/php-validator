<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 2017-10-11
 * Time: 12:22 PM
 */

namespace Humber\Validation;

spl_autoload_register(function ($class) {
    require_once($class . '.php');
});

class Validator
{
    private static $rulesObjects;
    private $rules;

    public function __construct(array $rules, array $messages = null)
    {
        foreach ($rules as $field => $rulesString) {
            foreach (explode("|", $rulesString) as $singleRule) {
                $singleRuleArray = explode(":", $singleRule);
                if (array_key_exists($singleRuleArray[0], $this->getRulesObjects())) {
                    $validation = array();
                    $validation['rule'] = $singleRuleArray[0];
                    $validation['field'] = $field;
                    $validation['options'] = count($singleRuleArray) > 1 ? $singleRuleArray[1] : null;
                    $validation['message'] = is_array($messages) && array_key_exists($field.'.'.$singleRuleArray[0], $messages) ? $messages[$field.'.'.$singleRuleArray[0]] : null;
                    $this->rules[] = $validation;
                } else {
                    throw new \Exception("Rule '$singleRuleArray[0]' couldn't be found");
                }
            }
        }
    }

    private function getRulesObjects()
    {
        if (!isset(self::$rulesObjects)) {
            $path = __DIR__ . "/Rules";
            self::$rulesObjects = array();

            $allFiles = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path));
            $phpFiles = new \RegexIterator($allFiles, '/\.php$/');
            foreach ($phpFiles as $phpFile) {
                $content = file_get_contents($phpFile->getRealPath());
                $tokens = token_get_all($content);
                $namespace = '';
                for ($index = 0; isset($tokens[$index]); $index++) {
                    if (!isset($tokens[$index][0])) {
                        continue;
                    }
                    if (T_NAMESPACE === $tokens[$index][0]) {
                        $index += 2; // Skip namespace keyword and whitespace
                        while (isset($tokens[$index]) && is_array($tokens[$index])) {
                            $namespace .= $tokens[$index++][1];
                        }
                    }
                    if (T_CLASS === $tokens[$index][0]) {
                        $index += 2; // Skip class keyword and whitespace
                        $fqcn = $namespace . '\\' . $tokens[$index][1];
                        self::$rulesObjects[constant($fqcn . '::RULETYPE')] = call_user_func($fqcn . '::getInstance');
                    }
                }
            }
        }
        return self::$rulesObjects;
    }

    public function validate(array $request)
    {
        $errors = array();
        foreach ($this->rules as $ruleArray) {
            $errors = $this->getRulesObjects()[$ruleArray['rule']]->validate($request, $ruleArray['field'], $ruleArray['options'], $errors, $ruleArray['message']);
        }
        return $errors;
    }

}