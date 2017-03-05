<?php
/**
 * The file for the evaluate-number service
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2016 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\EvaluateNumber;

/**
 * The evaluate-number service
 *
 * @since  0.1.0
 */
class EvaluateNumber
{
    /* !Constants */
	
	/**
	 * @var    int[]  an array of cardinal numbers (e.g., "one", "two", etc)
	 * @since  0.1.0
	 */
	const CARDINALS = [
		'one'       => 1, 
		'two'       => 2,
		'three'     => 3,
		'four'      => 4,
		'five'      => 5,
		'six'       => 6,
		'seven'     => 7,
		'eight'     => 8,
		'nine'      => 9,
		'ten'       => 10,
		'eleven'    => 11,
		'twelve'    => 12,
		'thirteen'  => 13,
		'fourteen'  => 14,
		'fifteen'   => 15,
		'sixteen'   => 16,
		'seventeen' => 17,
		'eighteen'  => 18,
		'nineteen'  => 19,
		'twenty'    => 20,
		'thirty'    => 30,
		'forty'     => 40,
		'fifty'     => 50,
		'sixty'     => 60,
		'seventy'   => 70,
		'eighty'    => 80,
		'ninety'    => 90
	];
	
	/**
	 * @var    int[]  an array of ordinal numbers (e.g., "first", "second", etc)
	 * @since  0.1.0
	 */
	const ORDINALS = [
		'first'       => 1,
		'second'      => 2,
		'third'       => 3,
		'fourth'      => 4,
		'fifth'       => 5,
		'sixth'       => 6,
		'seventh'     => 7,
		'eighth'      => 8,
		'nineth'      => 9,
		'tenth'       => 10,
		'eleventh'    => 11,
		'twelveth'    => 12,
		'thirteenth'  => 13,
		'fourteenth'  => 14,
		'fifteenth'   => 15,
		'sixteenth'   => 16,
		'seventeenth' => 17,
		'eighteenth'  => 18,
		'nineteenth'  => 19,
		'twentieth'   => 20,
		'thirtieth'   => 30,
		'fourtieth'   => 40,
		'fiftieth'    => 50,
		'sixtieth'    => 60,
		'seventieth'  => 70,
		'eightieth'   => 80,
		'ninetieth'   => 90
	];
	
	/**
	 * @var    int[]  an array of powers
	 * @since  0.1.0
	 */
	const POWERS = [
		'hundred'  => 100,
		'thousand' => 1000,
		'million'  => 1000000,
		'billion'  => 1000000000
	];
	
	/**
	 * @var    string[]  an array of number suffixes
	 * @since  0.1.0
	 */
	const SUFFIXES = ['th', 'st', 'nd', 'rd', 'rst'];
    
    
    /* !Magic methods */
    
    /**
     * Called when the service is treated like a function
     *
     * @param   mixed  $value  the number to evaluate
     * @return  int|float|false
     * @since   0.1.0
     */
    public function __invoke($value)
    {
        if (is_numeric($value)) {
            $number = $this->evaluateNumber($value);
        } elseif (is_string($value)) {
            $number = $this->evaluateString($value);
        } elseif (is_array($value)) {
            $number = $this->evaluateArray($value);
        } elseif (is_object($value)) {
            $number = $this->evaluateObject($value);
        } elseif (is_bool($value)) {
            $number = $this->evaluateBool($value);
        }
        
        return $number;
    }
    
    
    /* !Private methods */
    
    /**
     * Evaluates an array
     *
     * I'll return 0 for an empty array, and 1 for a non-empty array.
     *
     * @param   array  $value  the value to evaluate
     * @return  int
     * @since   0.1.0
     */
    private function evaluateArray(array $value): int
    {
        return min(count($value), 1);
    }
    
    /**
     * Evaluates a boolean
     *
     * I'll cast the boolean to an integer.
     *
     * @param   bool  $value  the value to evaluate
     * @return  int
     * @since   0.1.0
     */
    private function evaluateBool(bool $value): int
    {
        return (int) $value;
    }
    
    /**
	 * Evaluates a currency string (e.g., "$100")
	 * 
	 * @param   string  $value  the value to evaluate
	 * @return  int|float|false
	 * @since   0.1.0
	 */
    private function evaluateCurrency(string $value)
    {
		// if the string doesn't start with dollar-sign, short-circuit
		if (substr($value, 0, 1) !== '$') {
			return false;
		}
		
		// otherwise, re-evaluate the number less the dollar sign
		return $this(substr($value, 1));
    }
    
    /**
     * Evaluates a mixed number (e.g., "1 1/2")
     *
     * @param   string  $value
     * @return  float|false
     * @see  http://stackoverflow.com/a/5264255  Pascal MARTIN's answer to "Convert
	 *    mixed fraction string to float in PHP" on StackOverflow (edited to allow 
	 *    back- or forward-slashes in fractions) (accessed 2/12/17)
     * @since   0.1.0
     */
    private function evaluateMixedNumber(string $value)
    {
        // if the value is not a mixed-number, short-circuit
        if ( ! preg_match('#^((\d+)\s+)?(\d+)[/\\\](\d+)$#', $value, $matches)) {
            return false;
        }
        
        // otherwise, evaluate the parts of the mixed number
        $number = $matches[2] + $matches[3] / $matches[4];
        
        return $number;
    }
    
    /**
     * Evaluates an int, float, or numeric string (e.g., 1, 1.0, "1")
     *
     * @param   mixed  $value  the value to evaluate
     * @return  int|float
     * @since   0.1.0
     */
    private function evaluateNumber($value)
    {
        return +$value;
    }
    
    /**
     * Evaluates a named number (e.g., "one hundred")
     *
     * @param   mixed  $value  the value to evaluate
     * @return  int|float|false
     * @see  http://stackoverflow.com/a/11219737  El Yobo's answer to "Converting
	 *    words to numbers in PHP" on StackOverflow (edited to use constant arrays of
	 *    cardinals, ordinals, and powers and to use intval() instead of floatval())
     * @since   0.1.0
     */
    private function evaluateNamedNumber(string $value)
    {
        // lower-case the value
        $value = strtolower($value);
        
        // remove commas
        $value = str_replace(',', '', $value);
        
        // replace "-" and " and " with spaces
        $value = str_replace(['-', ' and '], ' ', $value);
        
        // explode on the space character
        $words = explode(' ', $value);
        
        // trim the words
        $words = array_map('trim', $words);
        
        // filter the words
        $words = array_filter($words);
        
        // get the possible number names
        $names = array_merge(
            array_keys(self::CARDINALS), 
            array_keys(self::ORDINALS), 
            array_keys(self::POWERS)
        );
        
        // if the value is composed of non-number names, short-circuit
        if (count(array_diff($words, $names))) {
            return false;
        }
        
        // otherwise, return to the (clean) value and replace the words with their 
        //     numeric values
        //
        $value = strtr(
            $value,
			array_merge(
				self::CARDINALS, 
				self::ORDINALS,
				self::POWERS
			)
		);
		
		// split the string on one or more spaces
		$numbers = preg_split('/[\s-]+/', $value);
		
    	// convert the numeric values to integers
        $numbers = array_map('intval', $numbers);
        
        // define our loop variables        
	    $stack = new \SplStack();  // the current work stack
	    $sum   = 0;                // the running total
	    $last  = null;             // the last part
					
		// loop through the numbers
	    foreach ($numbers as $number) {
	    	// if the stack isn't empty
	        if ( ! $stack->isEmpty()) {
	            // we're part way through a phrase
	            if ($stack->top() > $number) {
	                // decreasing step, e.g. from hundreds to ones
	                if ($last >= 1000) {
	                    // if we drop from more than 1000, we've finished the phrase
	                    $sum += $stack->pop();
	                    // this is the first element of a new phrase
	                    $stack->push($number);
	                } else {
	                    // drop down from less than 1000, just addition
	                    // e.g. "seventy one" -> "70 1" -> "70 + 1"
	                    //
	                    $stack->push($stack->pop() + $number);
	                }
	            } else {
	                // increasing step, e.g ones to hundreds
	                $stack->push($stack->pop() * $number);
	            }
	        } else {
	            // this is the first element of a new phrase
	            $stack->push($number);
	        }
	
	        // store the last number
	        $last = $number;
	    }
	
	    return $sum + $stack->pop();
	}
    
    /**
     * Evaluates an object
     *
     * Honestly, this method SHOULD NOT be used on objects. However, unlike PHP's 
     * native intval() or floatval() methods, I will not raise an error. I will 
	 * always evaluate objects to 1.
	 *
	 * @param   object  $value  the value to evaluate
	 * @return  int
	 * @since   0.1.0
	 */
    private function evaluateObject($value): int
    {
        return 1;    
    }
    
    /**
	 * Evaluates a percent string
	 *
	 * @param   string  $value  the value to evaluate
	 * @return  int|float|false
	 * @since   0.1.0
	 */
    private function evaluatePercent(string $value)
    {
        // if the string doesn't end with percent sign, short-circuit
		if (substr($value, -1) !== '%') {
			return false;
		} 
		
		// re-evaluate the value without the dollar sign
        return $this(substr($value, 0, -1)) / 100;
    }
    
    /**
     * Evaluates a string value
     *
     * I can handle a few scenarios:
     *
     *     1. The string is a thousands-separated number (e.g., "1,000").
     *     2. The string is a fraction or mixed number (e.g., "1/2").
     *     3. The string is a named number (e.g., "one hundred").
     *     4. The string is a suffixed number (e.g., "1st")
     *     5. The string is a percent (e.g., "1%")
     *     6. The string is a dollar amount (e.g., "$1")
     *
     * All other strings return 0 (like PHP's native intval() functions).
     *
     * Hmm, I (Jack) can't figure out a better way to do this than to try each 
     * scenario one-at-a-time. For performance's sake, put the most likely scenarios
     * at the top!
     *
     * @param   string  $value  the value to evaluate
     * @return  int|float|false
     * @since   0.1.0
     */
    private function evaluateString(string $value)
    {
        // trim the value
        $value = trim($value);	
        
        // if the value is an empty string, short-circuit
        if ( ! strlen($value)) {
            return false;
		}
		
		// otherwise, attempt to evaluate the string
		if (false !== ($number = $this->evaluateThousandsSeparatedNumber($value))) {
            return $number;
        } elseif (false !== ($number = $this->evaluateMixedNumber($value))) {
            return $number;   
        } elseif (false !== ($number = $this->evaluateNamedNumber($value))) {
            return $number;
        } elseif (false !== ($number = $this->evaluateSuffixedNumber($value))) {
            return $number;
        } elseif (false !== ($number = $this->evaluatePercent($value))) {
	        return $number;
        } elseif (false !== ($number = $this->evaluateCurrency($value))) {
	        return $number;
        }
        
        return 0;
    }
    
    /**
     * Evaluates a suffixed number (e.g., "1st")
     *
     * @param   string  $value
     * @return  int|false
     * @since   0.1.0
     */
    private function evaluateSuffixedNumber(string $value)
    {
        // if the first character is not a number, short-circuit
        if ( ! is_numeric(substr($value, 0, 1))) {
            return false;
        }
        
        // otherwse, get the unique suffix lengths
        $lengths = array_map(function ($suffix) {
            return strlen($suffix);
        }, self::SUFFIXES);
        
        // get the *unique* suffix lengths
        $lengths = array_unique($lengths);
        
        // sort the suffix lengths from longest-to-shortest...
        // otherwise, a shorter suffix (e.g., "st") may take precedence over a
        //     longer, better-matched suffix (e.g., "rst")
        //
        rsort($lengths);
        
        // loop through the suffix lengths
        foreach ($lengths as $length) {
            // get the number's suffix for the length
            $suffix = substr($value, -$length);
            // if *actual* suffix is a *possible* suffix
            if (in_array($suffix, self::SUFFIXES)) {
                
                // evaluate the number without the suffix
                return +substr($value, 0, $length);
            }   
        }
        
        return false;
    }
    
    /**
     * Evaluates a thousands-separated number (e.g., "1,000")
     *
     * @param   string  $value  the value to evaluate
     * @return  int|float|false
     * @see  http://stackoverflow.com/a/5917250  Justin Morgain's answer to "Regular
	 *    expression to match numbers with or without commas and decimals in text" on
	 *    StackOverflow (edited to allow leading and trailing zeros in comma-separated
	 *    numbers) (accessed 2/12/17)
     * @since   0.1.0
     */
    private function evaluateThousandsSeparatedNumber(string $value)
    {
        // if the value is not a thousands-separated value, short-circuit
        if ( ! preg_match('#^([1-9](?:\d*|(?:\d{0,2})(?:,\d{3})*)(?:\.\d*[0-9])?|0?\.\d*[0-9]|0)$#', $value)) {
            return false;
        }
        
        // otherwise, strip the commas and evaluate it
        $number = +str_replace(',', '', $value);
        
        return $number;
    }
}
