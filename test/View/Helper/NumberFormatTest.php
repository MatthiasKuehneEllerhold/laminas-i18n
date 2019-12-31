<?php

/**
 * @see       https://github.com/laminas/laminas-i18n for the canonical source repository
 * @copyright https://github.com/laminas/laminas-i18n/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-i18n/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\I18n\View\Helper;

use Laminas\I18n\View\Helper\NumberFormat as NumberFormatHelper;
use Locale;
use NumberFormatter;

/**
 * Test class for Laminas_View_Helper_Currency
 *
 * @category   Laminas
 * @package    Laminas_View
 * @subpackage UnitTests
 * @group      Laminas_View
 * @group      Laminas_View_Helper
 */
class NumberFormatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NumberFormatHelper
     */
    public $helper;

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    public function setUp()
    {
        $this->helper = new NumberFormatHelper();
    }

    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->helper);
    }

    public function currencyTestsDataProvider()
    {
        return array(
            array(
                'de_DE',
                NumberFormatter::DECIMAL,
                NumberFormatter::TYPE_DOUBLE,
                1234567.891234567890000,
                '1.234.567,891'
            ),
            array(
                'de_DE',
                NumberFormatter::PERCENT,
                NumberFormatter::TYPE_DOUBLE,
                1234567.891234567890000,
                '123.456.789 %'
            ),
            array(
                'de_DE',
                NumberFormatter::SCIENTIFIC,
                NumberFormatter::TYPE_DOUBLE,
                1234567.891234567890000,
                '1,23456789123457E6'
            ),
            array(
                'ru_RU',
                NumberFormatter::DECIMAL,
                NumberFormatter::TYPE_DOUBLE,
                1234567.891234567890000,
                '1 234 567,891'
            ),
            array(
                'ru_RU',
                NumberFormatter::PERCENT,
                NumberFormatter::TYPE_DOUBLE,
                1234567.891234567890000,
                '123 456 789 %'
            ),
            array(
                'ru_RU',
                NumberFormatter::SCIENTIFIC,
                NumberFormatter::TYPE_DOUBLE,
                1234567.891234567890000,
                '1,23456789123457E6'
            ),
            array(
                'en_US',
                NumberFormatter::DECIMAL,
                NumberFormatter::TYPE_DOUBLE,
                1234567.891234567890000,
                '1,234,567.891'
            ),
            array(
                'en_US',
                NumberFormatter::PERCENT,
                NumberFormatter::TYPE_DOUBLE,
                1234567.891234567890000,
                '123,456,789%'
            ),
            array(
                'en_US',
                NumberFormatter::SCIENTIFIC,
                NumberFormatter::TYPE_DOUBLE,
                1234567.891234567890000,
                '1.23456789123457E6'
            ),
        );
    }

    /**
     * @dataProvider currencyTestsDataProvider
     */
    public function testBasic($locale, $formatStyle, $formatType, $number, $expected)
    {
        $this->assertMbStringEquals($expected, $this->helper->__invoke(
            $number, $formatStyle, $formatType, $locale
        ));
    }

    /**
     * @dataProvider currencyTestsDataProvider
     */
    public function testSettersProvideDefaults($locale, $formatStyle, $formatType, $number, $expected)
    {
        $this->helper
             ->setLocale($locale)
             ->setFormatStyle($formatStyle)
             ->setFormatType($formatType);

        $this->assertMbStringEquals($expected, $this->helper->__invoke($number));
    }

    public function testDefaultLocale()
    {
        $this->assertEquals(Locale::getDefault(), $this->helper->getLocale());
    }

    public function assertMbStringEquals($expected, $test, $message = '')
    {
        $expected = str_replace(array("\xC2\xA0", ' '), '', $expected);
        $test     = str_replace(array("\xC2\xA0", ' '), '', $test);
        $this->assertEquals($expected, $test, $message);
    }
}
