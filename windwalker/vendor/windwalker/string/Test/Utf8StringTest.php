<?php
/**
 * Part of Windwalker project Test files.
 *
 * @copyright  Copyright (C) 2014 - 2015 LYRASOFT Taiwan, Inc. All rights reserved.
 * @license    GNU Lesser General Public License version 3 or later.
 */

namespace Windwalker\Utilities\Test;

use Windwalker\String\Utf8String;

/**
 * Test class of String
 *
 * @since 2.0
 */
class Utf8StringTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var    String
	 * @since  2.0
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @return void
	 */
	protected function setUp()
	{
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @return void
	 */
	protected function tearDown()
	{
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestIs_ascii()
	{
		return array(
			array('ascii', true),
			array('1024', true),
			array('#$#@$%', true),
			array('áÑ', false),
			array('ÿ©', false),
			array('¡¾', false),
			array('÷™', false),
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStrpos()
	{
		return array(
			array(3, 'missing', 'sing', 0),
			array(false, 'missing', 'sting', 0),
			array(4, 'missing', 'ing', 0),
			array(10, ' объектов на карте с', 'на карте', 0),
			array(0, 'на карте с', 'на карте', 0, 0),
			array(false, 'на карте с', 'на каррте', 0),
			array(false, 'на карте с', 'на карте', 2),
			array(3, 'missing', 'sing', false)
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestGetStrrpos()
	{
		return array(
			array(3, 'missing', 'sing', 0),
			array(false, 'missing', 'sting', 0),
			array(4, 'missing', 'ing', 0),
			array(10, ' объектов на карте с', 'на карте', 0),
			array(0, 'на карте с', 'на карте', 0),
			array(false, 'на карте с', 'на каррте', 0),
			array(3, 'на карте с', 'карт', 2)
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestSubstr()
	{
		return array(
			array('issauga', 'Mississauga', 4, false),
			array('на карте с', ' объектов на карте с', 10, false),
			array('на ка', ' объектов на карте с', 10, 5),
			array('те с', ' объектов на карте с', -4, false),
			array(false, ' объектов на карте с', 99, false)
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStrtolower()
	{
		return array(
			array('Windwalker! Rocks', 'windwalker! rocks')
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStrtoupper()
	{
		return array(
			array('Windwalker! Rocks', 'WINDWALKER! ROCKS')
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStrlen()
	{
		return array(
			array('Windwalker! Rocks', 17)
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStr_ireplace()
	{
		return array(
			array('Pig', 'cow', 'the pig jumped', false, 'the cow jumped'),
			array('Pig', 'cow', 'the pig jumped', true, 'the cow jumped'),
			array('Pig', 'cow', 'the pig jumped over the cow', true, 'the cow jumped over the cow'),
			array(array('PIG', 'JUMPED'), array('cow', 'hopped'), 'the pig jumped over the pig', true, 'the cow hopped over the cow'),
			array('шил', 'биш', 'Би шил идэй чадна', true, 'Би биш идэй чадна'),
			array('/', ':', '/test/slashes/', true, ':test:slashes:'),
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStr_split()
	{
		return array(
			array('string', 1, array('s', 't', 'r', 'i', 'n', 'g')),
			array('string', 2, array('st', 'ri', 'ng')),
			array('волн', 3, array('вол', 'н')),
			array('волн', 1, array('в', 'о', 'л', 'н'))
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStrcasecmp()
	{
		return array(
			array('THIS IS STRING1', 'this is string1', false, 0),
			array('this is string1', 'this is string2', false, -1),
			array('this is string2', 'this is string1', false, 1),
			array('бгдпт', 'бгдпт', false, 0),
			array('àbc', 'abc', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), 1),
			array('àbc', 'bcd', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), -1),
			array('é', 'è', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), -1),
			array('É', 'é', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), 0),
			array('œ', 'p', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), -1),
			array('œ', 'n', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), 1),
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStrcmp()
	{
		return array(
			array('THIS IS STRING1', 'this is string1', false, -1),
			array('this is string1', 'this is string2', false, -1),
			array('this is string2', 'this is string1', false, 1),
			array('a', 'B', false, 1),
			array('A', 'b', false, -1),
			array('Àbc', 'abc', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), 1),
			array('Àbc', 'bcd', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), -1),
			array('É', 'è', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), -1),
			array('é', 'È', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), -1),
			array('Œ', 'p', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), -1),
			array('Œ', 'n', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), 1),
			array('œ', 'N', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), 1),
			array('œ', 'P', array('fr_FR.utf8', 'fr_FR.UTF-8', 'fr_FR.UTF-8@euro', 'French_Standard', 'french', 'fr_FR', 'fre_FR'), -1),
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStrcspn()
	{
		return array(
			array('subject <a> string <a>', '<>', false, false, 8),
			array('Би шил {123} идэй {456} чадна', '}{', null, false, 7),
			array('Би шил {123} идэй {456} чадна', '}{', 13, 10, 5)
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStristr()
	{
		return array(
			array('haystack', 'needle', false),
			array('before match, after match', 'match', 'match, after match'),
			array('Би шил идэй чадна', 'шил', 'шил идэй чадна')
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStrrev()
	{
		return array(
			array('abc def', 'fed cba'),
			array('Би шил', 'лиш иБ')
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestStrspn()
	{
		return array(
			array('A321 Main Street', '0123456789', 1, 2, 2),
			array('321 Main Street', '0123456789', null, 2, 2),
			array('A321 Main Street', '0123456789', null, 10, 0),
			array('321 Main Street', '0123456789', null, null, 3),
			array('Main Street 321', '0123456789', null, -3, 0),
			array('321 Main Street', '0123456789', null, -13, 2),
			array('321 Main Street', '0123456789', null, -12, 3),
			array('A321 Main Street', '0123456789', 0, null, 0),
			array('A321 Main Street', '0123456789', 1, 10, 3),
			array('A321 Main Street', '0123456789', 1, null, 3),
			array('Би шил идэй чадна', 'Би', null, null, 2),
			array('чадна Би шил идэй чадна', 'Би', null, null, 0)
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestSubstr_replace()
	{
		return array(
			array('321 Broadway Avenue', '321 Main Street', 'Broadway Avenue', 4, null),
			array('321 Broadway Street', '321 Main Street', 'Broadway', 4, 4),
			array('чадна 我能吞', 'чадна Би шил идэй чадна', '我能吞', 6, null),
			array('чадна 我能吞 шил идэй чадна', 'чадна Би шил идэй чадна', '我能吞', 6, 2)
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestLtrim()
	{
		return array(
			array('   abc def', null, 'abc def'),
			array('   abc def', '', '   abc def'),
			array(' Би шил', null, 'Би шил'),
			array("\t\n\r\x0BБи шил", null, 'Би шил'),
			array("\x0B\t\n\rБи шил", "\t\n\x0B", "\rБи шил"),
			array("\x09Би шил\x0A", "\x09\x0A", "Би шил\x0A"),
			array('1234abc', '0123456789', 'abc')
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestRtrim()
	{
		return array(
			array('abc def   ', null, 'abc def'),
			array('abc def   ', '', 'abc def   '),
			array('Би шил ', null, 'Би шил'),
			array("Би шил\t\n\r\x0B", null, 'Би шил'),
			array("Би шил\r\x0B\t\n", "\t\n\x0B", "Би шил\r"),
			array("\x09Би шил\x0A", "\x09\x0A", "\x09Би шил"),
			array('1234abc', 'abc', '01234')
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestTrim()
	{
		return array(
			array('  abc def   ', null, 'abc def'),
			array('  abc def   ', '', '  abc def   '),
			array('   Би шил ', null, 'Би шил'),
			array("\t\n\r\x0BБи шил\t\n\r\x0B", null, 'Би шил'),
			array("\x0B\t\n\rБи шил\r\x0B\t\n", "\t\n\x0B", "\rБи шил\r"),
			array("\x09Би шил\x0A", "\x09\x0A", "Би шил"),
			array('1234abc56789', '0123456789', 'abc')
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestUcfirst()
	{
		return array(
			array('george', null, null, 'George'),
			array('мога', null, null, 'Мога'),
			array('ψυχοφθόρα', null, null, 'Ψυχοφθόρα'),
			array('dr jekill and mister hyde', ' ', null, 'Dr Jekill And Mister Hyde'),
			array('dr jekill and mister hyde', ' ', '_', 'Dr_Jekill_And_Mister_Hyde'),
			array('dr jekill and mister hyde', ' ', '', 'DrJekillAndMisterHyde'),
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestUcwords()
	{
		return array(
			array('george washington', 'George Washington'),
			array("george\r\nwashington", "George\r\nWashington"),
			array('мога', 'Мога'),
			array('αβγ δεζ', 'Αβγ Δεζ'),
			array('åbc öde', 'Åbc Öde')
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestTranscode()
	{
		return array(
			array('Åbc Öde €2.0', 'UTF-8', 'ISO-8859-1', "\xc5bc \xd6de EUR2.0"),
			array(array('Åbc Öde €2.0'), 'UTF-8', 'ISO-8859-1', null),
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestValid()
	{
		return array(
			array("\xCF\xB0", true),
			array("\xFBa", false),
			array("\xFDa", false),
			array("foo\xF7bar", false),
			array('george Мога Ž Ψυχοφθόρα ฉันกินกระจกได้ 我能吞下玻璃而不伤身体 ', true),
			array("\xFF ABC", false),
			array("0xfffd ABC", true),
			array('', true)
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestUnicodeToUtf8()
	{
		return array(
			array("\u0422\u0435\u0441\u0442 \u0441\u0438\u0441\u0442\u0435\u043c\u044b", "Тест системы"),
			array("\u00dcberpr\u00fcfung der Systemumstellung", "Überprüfung der Systemumstellung")
		);
	}

	/**
	 * Test...
	 *
	 * @return  array
	 *
	 * @since   2.0
	 */
	public function seedTestUnicodeToUtf16()
	{
		return array(
			array("\u0422\u0435\u0441\u0442 \u0441\u0438\u0441\u0442\u0435\u043c\u044b", "Тест системы"),
			array("\u00dcberpr\u00fcfung der Systemumstellung", "Überprüfung der Systemumstellung")
		);
	}

	/**
	 * Test...
	 *
	 * @param   string   $string    @todo
	 * @param   boolean  $expected  @todo
	 *
	 * @return  void
	 *
	 * @covers        Windwalker\String\Utf8String::is_ascii
	 * @dataProvider  seedTestIs_ascii
	 * @since         2.0
	 */
	public function testIs_ascii($string, $expected)
	{
		$this->assertEquals(
			$expected,
			Utf8String::is_ascii($string)
		);
	}

	/**
	 * Test...
	 *
	 * @param   string   $expect    @todo
	 * @param   string   $haystack  @todo
	 * @param   string   $needle    @todo
	 * @param   integer  $offset    @todo
	 *
	 * @return  void
	 *
	 * @covers        Windwalker\String\Utf8String::strpos
	 * @dataProvider  seedTestStrpos
	 * @since         2.0
	 */
	public function testStrpos($expect, $haystack, $needle, $offset = 0)
	{
		$actual = Utf8String::strpos($haystack, $needle, $offset);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string   $expect    @todo
	 * @param   string   $haystack  @todo
	 * @param   string   $needle    @todo
	 * @param   integer  $offset    @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::strrpos
	 * @dataProvider  seedTestGetStrrpos
	 * @since         2.0
	 */
	public function testStrrpos($expect, $haystack, $needle, $offset = 0)
	{
		$actual = Utf8String::strrpos($haystack, $needle, $offset);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string    $expect  @todo
	 * @param   string    $string  @todo
	 * @param   string    $start   @todo
	 * @param   bool|int  $length  @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::substr
	 * @dataProvider  seedTestSubstr
	 * @since         2.0
	 */
	public function testSubstr($expect, $string, $start, $length = false)
	{
		$actual = Utf8String::substr($string, $start, $length);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string  @todo
	 * @param   string  $expect  @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::strtolower
	 * @dataProvider  seedTestStrtolower
	 * @since         2.0
	 */
	public function testStrtolower($string, $expect)
	{
		$actual = Utf8String::strtolower($string);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string  @todo
	 * @param   string  $expect  @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::strtoupper
	 * @dataProvider  seedTestStrtoupper
	 * @since         2.0
	 */
	public function testStrtoupper($string, $expect)
	{
		$actual = Utf8String::strtoupper($string);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string  @todo
	 * @param   string  $expect  @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::strlen
	 * @dataProvider  seedTestStrlen
	 * @since         2.0
	 */
	public function testStrlen($string, $expect)
	{
		$actual = Utf8String::strlen($string);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string   $search   @todo
	 * @param   string   $replace  @todo
	 * @param   string   $subject  @todo
	 * @param   integer  $count    @todo
	 * @param   string   $expect   @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::str_ireplace
	 * @dataProvider  seedTestStr_ireplace
	 * @since         2.0
	 */
	public function testStr_ireplace($search, $replace, $subject, $count, $expect)
	{
		$actual = Utf8String::str_ireplace($search, $replace, $subject, $count);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string        @todo
	 * @param   string  $split_length  @todo
	 * @param   string  $expect        @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::str_split
	 * @dataProvider  seedTestStr_split
	 * @since         2.0
	 */
	public function testStr_split($string, $split_length, $expect)
	{
		$actual = Utf8String::str_split($string, $split_length);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string1  @todo
	 * @param   string  $string2  @todo
	 * @param   string  $locale   @todo
	 * @param   string  $expect   @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::strcasecmp
	 * @dataProvider  seedTestStrcasecmp
	 * @since         2.0
	 */
	public function testStrcasecmp($string1, $string2, $locale, $expect)
	{
		// Convert the $locale param to a string if it is an array
		if (is_array($locale))
		{
			$locale = "'" . implode("', '", $locale) . "'";
		}

		if (substr(php_uname(), 0, 6) == 'Darwin' && $locale != false)
		{
			$this->markTestSkipped('Darwin bug prevents foreign conversion from working properly');
		}
		elseif ($locale != false && !setlocale(LC_COLLATE, $locale))
		{
			$this->markTestSkipped("Locale {$locale} is not available.");
		}
		else
		{
			$actual = Utf8String::strcasecmp($string1, $string2, $locale);

			if ($actual != 0)
			{
				$actual = $actual / abs($actual);
			}

			$this->assertEquals($expect, $actual);
		}
	}

	/**
	 * Test...
	 *
	 * @param   string  $string1  @todo
	 * @param   string  $string2  @todo
	 * @param   string  $locale   @todo
	 * @param   string  $expect   @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::strcmp
	 * @dataProvider  seedTestStrcmp
	 * @since         2.0
	 */
	public function testStrcmp($string1, $string2, $locale, $expect)
	{
		// Convert the $locale param to a string if it is an array
		if (is_array($locale))
		{
			$locale = "'" . implode("', '", $locale) . "'";
		}

		if (substr(php_uname(), 0, 6) == 'Darwin' && $locale != false)
		{
			$this->markTestSkipped('Darwin bug prevents foreign conversion from working properly');
		}
		elseif ($locale != false && !setlocale(LC_COLLATE, $locale))
		{
			// If the locale is not available, we can't have to transcode the string and can't reliably compare it.
			$this->markTestSkipped("Locale {$locale} is not available.");
		}
		else
		{
			$actual = Utf8String::strcmp($string1, $string2, $locale);

			if ($actual != 0)
			{
				$actual = $actual / abs($actual);
			}

			$this->assertEquals($expect, $actual);
		}
	}

	/**
	 * Test...
	 *
	 * @param   string   $haystack  @todo
	 * @param   string   $needles   @todo
	 * @param   integer  $start     @todo
	 * @param   integer  $len       @todo
	 * @param   string   $expect    @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::strcspn
	 * @dataProvider  seedTestStrcspn
	 * @since         2.0
	 */
	public function testStrcspn($haystack, $needles, $start, $len, $expect)
	{
		$actual = Utf8String::strcspn($haystack, $needles, $start, $len);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $haystack  @todo
	 * @param   string  $needle    @todo
	 * @param   string  $expect    @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::stristr
	 * @dataProvider  seedTestStristr
	 * @since         2.0
	 */
	public function testStristr($haystack, $needle, $expect)
	{
		$actual = Utf8String::stristr($haystack, $needle);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string  @todo
	 * @param   string  $expect  @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::strrev
	 * @dataProvider  seedTestStrrev
	 * @since         2.0
	 */
	public function testStrrev($string, $expect)
	{
		$actual = Utf8String::strrev($string);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string   $subject  @todo
	 * @param   string   $mask     @todo
	 * @param   integer  $start    @todo
	 * @param   integer  $length   @todo
	 * @param   string   $expect   @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::strspn
	 * @dataProvider  seedTestStrspn
	 * @since         2.0
	 */
	public function testStrspn($subject, $mask, $start, $length, $expect)
	{
		$actual = Utf8String::strspn($subject, $mask, $start, $length);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string   $expect       @todo
	 * @param   string   $string       @todo
	 * @param   string   $replacement  @todo
	 * @param   integer  $start        @todo
	 * @param   integer  $length       @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::substr_replace
	 * @dataProvider  seedTestSubstr_replace
	 * @since         2.0
	 */
	public function testSubstr_replace($expect, $string, $replacement, $start, $length)
	{
		$actual = Utf8String::substr_replace($string, $replacement, $start, $length);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string    @todo
	 * @param   string  $charlist  @todo
	 * @param   string  $expect    @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::ltrim
	 * @dataProvider  seedTestLtrim
	 * @since         2.0
	 */
	public function testLtrim($string, $charlist, $expect)
	{
		if ($charlist === null)
		{
			$actual = Utf8String::ltrim($string);
		}
		else
		{
			$actual = Utf8String::ltrim($string, $charlist);
		}

		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string    @todo
	 * @param   string  $charlist  @todo
	 * @param   string  $expect    @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::rtrim
	 * @dataProvider  seedTestRtrim
	 * @since         2.0
	 */
	public function testRtrim($string, $charlist, $expect)
	{
		if ($charlist === null)
		{
			$actual = Utf8String::rtrim($string);
		}
		else
		{
			$actual = Utf8String::rtrim($string, $charlist);
		}

		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string    @todo
	 * @param   string  $charlist  @todo
	 * @param   string  $expect    @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::trim
	 * @dataProvider  seedTestTrim
	 * @since         2.0
	 */
	public function testTrim($string, $charlist, $expect)
	{
		if ($charlist === null)
		{
			$actual = Utf8String::trim($string);
		}
		else
		{
			$actual = Utf8String::trim($string, $charlist);
		}

		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string        @todo
	 * @param   string  $delimiter     @todo
	 * @param   string  $newDelimiter  @todo
	 * @param   string  $expect        @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::ucfirst
	 * @dataProvider  seedTestUcfirst
	 * @since         2.0
	 */
	public function testUcfirst($string, $delimiter, $newDelimiter, $expect)
	{
		$actual = Utf8String::ucfirst($string, $delimiter, $newDelimiter);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string  @todo
	 * @param   string  $expect  @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::ucwords
	 * @dataProvider  seedTestUcwords
	 * @since         2.0
	 */
	public function testUcwords($string, $expect)
	{
		$actual = Utf8String::ucwords($string);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $source         @todo
	 * @param   string  $from_encoding  @todo
	 * @param   string  $to_encoding    @todo
	 * @param   string  $expect         @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::transcode
	 * @dataProvider  seedTestTranscode
	 * @since         2.0
	 */
	public function testTranscode($source, $from_encoding, $to_encoding, $expect)
	{
		$actual = Utf8String::transcode($source, $from_encoding, $to_encoding);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string  @todo
	 * @param   string  $expect  @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::valid
	 * @dataProvider  seedTestValid
	 * @since         2.0
	 */
	public function testValid($string, $expect)
	{
		$actual = Utf8String::valid($string);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string  @todo
	 * @param   string  $expect  @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::unicode_to_utf8
	 * @dataProvider  seedTestUnicodeToUtf8
	 * @since         2.0
	 */
	public function testUnicodeToUtf8($string, $expect)
	{
		$actual = Utf8String::unicode_to_utf8($string);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string  @todo
	 * @param   string  $expect  @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::unicode_to_utf16
	 * @dataProvider  seedTestUnicodeToUtf16
	 * @since         2.0
	 */
	public function testUnicodeToUtf16($string, $expect)
	{
		$actual = Utf8String::unicode_to_utf16($string);
		$this->assertEquals($expect, $actual);
	}

	/**
	 * Test...
	 *
	 * @param   string  $string  @todo
	 * @param   string  $expect  @todo
	 *
	 * @return  array
	 *
	 * @covers        Windwalker\String\Utf8String::compliant
	 * @dataProvider  seedTestValid
	 * @since         2.0
	 */
	public function testCompliant($string, $expect)
	{
		$actual = Utf8String::compliant($string);
		$this->assertEquals($expect, $actual);
	}
}
