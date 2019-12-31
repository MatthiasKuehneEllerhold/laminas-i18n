<?php

/**
 * @see       https://github.com/laminas/laminas-i18n for the canonical source repository
 * @copyright https://github.com/laminas/laminas-i18n/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-i18n/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\I18n\Validator;

use Laminas\I18n\Validator\Int as IntValidator;
use Locale;

/**
 * @group      Laminas_Validator
 */
class IntTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Int
     */
    protected $validator;

    /**
     * @var string
     */
    protected $locale;

    public function setUp()
    {
        if (version_compare(PHP_VERSION, '7.0', '>=')) {
            $this->markTestSkipped('Cannot test Int validator under PHP 7; reserved keyword');
        }

        if (!extension_loaded('intl')) {
            $this->markTestSkipped('ext/intl not enabled');
        }

        $this->locale = Locale::getDefault();
    }

    public function tearDown()
    {
        if (extension_loaded('intl')) {
            Locale::setDefault($this->locale);
        }
    }

    public function testConstructorRaisesDeprecationNotice()
    {
        $this->setExpectedException('PHPUnit_Framework_Error_Deprecated');
        new IntValidator();
    }
}
