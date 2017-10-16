# PHP form validator library
This library emulates the behavior of Lavarel's validation functionality.
## Using the library
The first step to use it is including the namespace
and the Validator class in the script:

```php
use Humber\Validation\Validator;
require_once "Humber/Validation/Validator.php";
```
Then, create an array with the field names as keys the name of the rules you want to validate in each field like this:
```php
$rules = [
    'fieldName1' => 'email|filled',
    'fieldName2' => 'url',
    'fieldName3' => 'size:5|alpha_num'
];
```
Then, create a validator object using the rules array:
```php
$validator = new Validator($rules);
```
And now you can call the validate function:
```php
$errors = $validator->validate($formRequest);
```
This will return an array with the errors found following this structure:
```php
array (
  'fieldName1' => 
  array (
    'email' => '\'fieldName1\' is not a valid email',
    'filled' => '\'fieldName1\' is not filled',
  ),
  'fieldName2' =>
  array (
    'url' => '\'fieldName2\' is not a valid url',
)
```
If **no errors** were found, an **empty array will be returned**.
## Customizing the error messages
You can also customize the error messages returned in the array, creating a messages array and sending it as a second 
parameter in the Validator constructor:
```php
$messages = [
    'formEmail.email' => 'Invalid email',
    'formEmail.filled' => 'Empty email',
    'formName.array' => 'Empty name'
];
$validator = new Validator($rules, $messages);
$errors = $validator->validate($formRequest);
```
## Exceptions
The following exceptions could be thrown
- **Rule 'rulexxxx' couldn't be found** When the rule specified in the rules array is not present in any RULETYPE 
constant of any of the Rule Classes inside the Rules folder.
- **'fieldnamexxx' field not found in request** When the request array does not contain the specified fieldname 
in the rules array.
- **Rule 'rulexxxx' needs xxx parameter for xxxxxxxxxxx, usage example (rulexxxx:xx)** When the specified rules requires
parameters which were not sent inside the rules array.
## Supported validation rules
- **alpha_num** The field under validation must be entirely alpha-numeric characters.
- **array** The field under validation must be a PHP *array*.
- **date** The field under validation must be a valid date according to the *strtotime* PHP function.
- **digits:value** The field under validation must be numeric and must have an exact length of *value*. 
- **email** The field under validation must be formatted as an e-mail address. 
- **filled** The field under validation must not be empty when it is present.
- **integer** The field under validation must be an integer.
- **json** The field under validation must be a valid JSON string.
- **regex:pattern** The field under validation must match the given regular expression.
*Note*: Regex pattern using pipe delimiters "|" are not supported at this moment.
- **required** The field under validation must be present in the input data and not empty. A field is considered "empty"
 if the value is null or an empty string.
- **size:value** The field under validation must have a size matching the given value. For string data, value 
corresponds to the number of characters. For numeric data, value corresponds to a given integer value. For an array, 
size corresponds to the count of the array. For files, size corresponds to the file size in kilobytes. 
- **url** The field under validation must be a valid URL.
## Adding more rules
To add a new Rule, simply add the new class under the Rules folder following this template:
```php
<?php
namespace Humber\Validation\Rules;
use Humber\Validation\Rule;

class NewRule extends Rule
{
    const RULETYPE = "new";
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
            self::$ruleInstance = new NewRule();
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
        $valid = true; //  Replace with the condition to be evaluated in the $request[field] variable
        //  If there are comma separated options after the rule (new:op1,op2), they will be available
        //  in the $options array
        return !$valid ? (is_null($message) ? "'$field' is not valid under the 'new' rule" : $message) : null;
    }
}
``` 