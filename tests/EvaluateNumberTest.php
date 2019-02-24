<?php
/**
 * The file for the evaluate-number service tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2017 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\EvaluateNumber;

use Jstewmc\TestCase\TestCase;

/**
 * Tests for the evaluate-number service
 */
class EvaluateNumberTest extends TestCase
{
	/* !bool */

	/**
	 * invoke() should return integer if value is a bool
	 */
	public function testInvokeReturnsIntegerIfValueIsBool()
	{
		$this->assertEquals(1, (new EvaluateNumber())(true));

		return;
	}


	/* !float */

	/**
	 * invoke() should return float if value is a float
	 */
	public function testInvokeReturnsFloatIfValueIsFloat()
	{
		$this->assertEquals(1.1, (new EvaluateNumber())(1.1));

		return;
	}


	/* !int */

	/**
	 * invoke() should return integer if value is an integer
	 */
	public function testInvokeReturnsIntegerIfValueIsInteger()
	{
		$this->assertEquals(1, (new EvaluateNumber())(1));

		return;
	}


	/* !string */

	/**
	 * invoke() should return float if value is a string float
	 */
	public function testInvokeReturnsFloatIfValueIsStringFloat()
	{
		$this->assertEquals(1.0, (new EvaluateNumber())('1.0'));

		return;
	}

	/**
	 * invoke() should return integer if value is a string integer
	 */
	public function testInvokeReturnsIntegerIfValueIsStringInteger()
	{
		$this->assertEquals(1, (new EvaluateNumber())('1'));

		return;
	}

	/**
	 * invoke() should return float if value is a fraction
	 */
	public function testInvokeReturnsFloatIfValueIsFraction()
	{
		$this->assertEquals(0.5, (new EvaluateNumber())('1/2'));

		return;
	}

	/**
	 * invoke() should return float if value is a mixed number
	 */
	public function testInvokeReturnsFloatIfValueIsMixedNumber()
	{
		$this->assertEquals(1.5, (new EvaluateNumber())('1 1/2'));

		return;
	}

	/**
	 * invoke() should return integer if value is a comma-separated integer
	 */
	public function testInvokeReturnsIntegerIfValueIsCommaSeparatedInteger()
	{
		$this->assertEquals(1000, (new EvaluateNumber())('1,000'));

		return;
	}

	/**
	 * invoke() should return an integer if value is a comma-separated float
	 */
	public function testInvokeReturnsFloatIfValueIsCommaSeparatedFloat()
	{
		$this->assertEquals(1000.5, (new EvaluateNumber())('1,000.5'));

		return;
	}

	/**
	 * invoke() should return int if value has suffix
	 */
	public function testInvokeReturnsIntIfValueHasSuffix()
	{
		$this->assertEquals(1, (new EvaluateNumber())('1st'));

		return;
	}

	/**
	 * invoke() should return int if value is a cardinal string (e.g., "one")
	 */
	public function testInvokeReturnsIntIfValueIsCardinalString()
	{
		$this->assertEquals(1, (new EvaluateNumber())('one'));

		return;
	}

	/**
	 * invoke() should return int if value is an ordinal string (e.g., "first")
	 */
	public function testInvokeReturnsIntIfValueIsAnOrdinalString()
	{
		$this->assertEquals(1, (new EvaluateNumber())('first'));

		return;
	}

	/**
	 * invoke() should return int if value is an short integer name
	 */
	public function testInvokeReturnsIntIfValueIsShortName()
	{
		$this->assertEquals(
			111,
			(new EvaluateNumber())('one hundred and eleven')
		);

		return;
	}

	/**
	 * invoke() should return int if value is a medium integer name
	 */
	public function testInvokeReturnsIntIfValueIsMediumName()
	{
		$this->assertEquals(
			111111,
			(new EvaluateNumber())(
				'one hundred eleven thousand, one hundred and eleven'
			)
		);

		return;
	}

	/**
	 * invoke() should return int if value is a long-length integer name
	 */
	public function testInvokeReturnsIntIfValueIsLongName()
	{
		$this->assertEquals(
			1111111,
	 		(new EvaluateNumber())(
	 			'one million one hundred eleven thousand one hundred and eleven'
	 		)
	 	);

	 	return;
	}

	/**
	 * invoke() should return float if value is integer percent
	 *
	 * @group  jack
	 */
	public function testInvokeReturnsFloatIfValueIsIntegerPercent()
	{
		$this->assertEquals(0.01, (new EvaluateNumber())('1%'));

		return;
	}

	/**
	 * invoke() should return float if value is float percent
	 */
	public function testInvokeReturnsFloatIfValueIsFloatPercent()
	{
		$this->assertEquals(0.015, (new EvaluateNumber())('1.5%'));

		return;
	}

	/**
	 * invoke() should return int if value is integer dollars
	 */
	public function testInvokeReturnsIntIfValueIsIntegerDollars()
	{
		$this->assertEquals(1, (new EvaluateNumber())('$1'));

		return;
	}

	/**
	 * invoke() should return float if value is float dollars
	 */
	public function testInvokeReturnsFloatIfValueIsFloatDollars()
	{
		$this->assertEquals(1000.5, (new EvaluateNumber())('$1,000.50'));

		return;
	}

	/**
	 * invoke() should return zero if value is non-numeric string
	 */
	public function testInvokeReturnsZeroIfValueIsNonNumericString()
	{
		$this->assertEquals(0, (new EvaluateNumber())('foo'));

		return;
	}


	/* !array */

	/**
	 * invoke() should return zero if value is an empty array
	 */
	public function testInvokeReturnsZeroIfValueIsEmptyArray()
	{
		$this->assertEquals(0, (new EvaluateNumber())([]));

		return;
	}

	/**
	* invoke() should return one if value is a non-empty array
	*/
	public function testInvokeReturnsOneIfValueIsNonEmptyArray()
	{
		$this->assertEquals(1, (new EvaluateNumber())(['foo']));

		return;
	}


	/* !object */

	/**
	 * invoke() should return one if value is an object
	 */
	public function testInvokeReturnsOneIfValueIsObject()
	{
		$this->assertEquals(1, (new EvaluateNumber())(new \StdClass()));

		return;
	}
}
