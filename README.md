# evaluate-number

Evaluate a variety of US number formats to their integer or float equivalent including: 

* fractions (e.g., `'1/2'`), 
* mixed numbers (e.g., `'1 1/2'`), 
* comma-separated values (e.g., `'1,000'`), 
* ordinal numbers (e.g., `'first'`), 
* cardinal numbers (e.g., `'one hundred'`),
* dollars (e.g., `$1,000`), and
* percents (e.g., `10%`).

```php
namespace Jstewmc\EvaluateNumber;

// instantiate the service
$service = new EvaluateNumber();

// evaluate some stuff!
$service(true);            // returns (int) 1
$service(1);               // returns (int) 1
$service('1');             // returns (int) 1
$service(1.5);             // returns (float) 1.5
$service('1.5');           // returns (float) 1.5
$service('1 1/2');         // returns (float) 1.5
$service('3/2');           // returns (float) 1.5
$service('3\2');           // returns (float) 1.5
$service('1000');          // returns (int) 1000
$service('1,000');         // returns (int) 1000
$service('1,000.5');       // returns (float) 1000.5
$service('1st');           // returns (int) 1
$service('second');        // returns (int) 2
$service('one hundred');   // returns (int) 100
$service('10%');           // returns (float) 0.1
$service('$1000')          // returns (int) 1000
$service('1,0,0');         // returns 0
$service('abc');           // returns 0
$service(array());         // returns 0
$service(array('foo'));    // returns 1
$service(new stdClass());  // returns 1
```

## Rules

Wherever possible, this library follows the conventions of PHP's native [intval()](http://php.net/manual/en/function.intval.php) and [floatval()](http://php.net/manual/en/function.floatval.php) functions.

### Integers

Integers are returned as-is:

```php
namespace Jstewmc\EvaluateNumber;

$service = new EvaluateNumber();

$service(-1);  // returns (int) -1
$service(0);   // returns (int) 0
$service(1);   // returns (int) 1
```

### Floats

Floats are returned as-is:

```php
namespace Jstewmc\EvaluateNumber;

$service = new EvaluateNumber();

$service(-1.0);  // returns (float) -1.0
$service(0.0);   // returns (float) 0.0
$service(1.0);   // returns (float) 1.0
```

### Booleans

Booleans are returned as their integer equivalent:

```php
namespace Jstewmc\EvaluateNumber;

$service = new EvaluateNumber();

$service(true);   // returns (int) 1
$service(false);  // returns (int) 0
```

### Strings

Strings in the following formats are returned as their integer or float equivalents:

* Numeric strings (e.g., `'1'`);
* Thousands-separated numbers (e.g., `'1,000'`);
* Fractions (e.g., '`'1/2'`);
* Mixed numbers (e.g., `'1 1/2'`);
* Ordinal numbers (e.g., `'one hundred'`);
* Cardinal numbers (e.g., `'first'`);
* Suffixed numbers (e.g., `'1st'`);
* Pecents (e.g., `'1%'`); and, 
* Dollars (e.g., `'$1,000'`).

All other strings return 0.

```php
namespace Jstewmc\EvaluateNumber;

$service = new EvaluateNumber();

$service('1');            // returns (int) 1
$service('1,000');        // returns (int) 1000
$service('1/2');          // returns (float) 0.5
$service('1 1/2');        // returns (float) 1.5
$service('one hundred');  // returns (int) 100
$service('first');        // returns (int) 1
$service('1st');          // returns (int) 1
$service('1%');           // returns (float) 0.01
$service('$1,000');       // returns (int) 1000
$service('foo');          // returns (int) 0
```

### Arrays

Empty arrays return 0, and non-empty arrays return 1:

```php
namespace Jstewmc\EvaluateNumber;

$service = new EvaluateNumber();

$service([]);              // returns 0
$service(['foo']);         // returns 1
$service(['foo', 'bar']);  // returns 1
```

### Objects

This method SHOULD NOT be used on objects. However, unlike the native PHP intval() or floatval() methods, this library will not raise an error. Instead, objects are always returned as 1.

```php
namespace Jstewmc\EvaluateNumber;

$service = new EvaluateNumber();

$service(new SplObject());  // returns 1
```

That's about it!

## Author

[Jack Clayton](mailto:clayjs0@gmail.com)

## License

[MIT](https://github.com/jstewmc/evaluate-number/blob/master/LICENSE)

## Version

### 0.1.0, March 5, 2017

* Initial release
