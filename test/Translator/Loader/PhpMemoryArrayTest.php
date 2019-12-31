<?php

/**
 * @see       https://github.com/laminas/laminas-i18n for the canonical source repository
 * @copyright https://github.com/laminas/laminas-i18n/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-i18n/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\I18n\Translator\Loader;

use Laminas\I18n\Translator\Loader\PhpMemoryArray as PhpMemoryArrayLoader;
use Locale;
use PHPUnit_Framework_TestCase as TestCase;

class PhpMemoryArrayTest extends TestCase
{
    protected $testFilesDir;
    protected $originalLocale;
    protected $originalIncludePath;

    public function setUp()
    {
        if (!extension_loaded('intl')) {
            $this->markTestSkipped('ext/intl not enabled');
        }

        $this->originalLocale = Locale::getDefault();
        Locale::setDefault('en_US');

        $this->testFilesDir = realpath(__DIR__ . '/../_files/phpmemoryarray');
    }

    public function tearDown()
    {
        if (extension_loaded('intl')) {
            Locale::setDefault($this->originalLocale);
        }
    }
    public function testLoaderFailsToLoadNonArray()
    {
        $loader = new PhpMemoryArrayLoader('foo');
        $this->setExpectedException('Laminas\I18n\Exception\InvalidArgumentException',
                                    'Expected an array, but received');
        $loader->load('en_US', 'default');
    }

    public function testLoaderFailsToLoadMissingTextDomain()
    {
        $loader = new PhpMemoryArrayLoader(array());
        $this->setExpectedException('Laminas\I18n\Exception\InvalidArgumentException',
                                    'Expected textdomain "default" to be an array, but it is not set');
        $loader->load('en_US', 'default');
    }

    public function testLoaderFailsToLoadNonArrayLocale()
    {
        $loader = new PhpMemoryArrayLoader(array('default' => array()));
        $this->setExpectedException('Laminas\I18n\Exception\InvalidArgumentException',
                                    'Expected locale "en_US" to be an array, but it is not set');
        $loader->load('en_US', 'default');
    }

    public function testLoaderLoadsEmptyArray()
    {
        $loader = new PhpMemoryArrayLoader(include $this->testFilesDir . '/translation_empty.php');
        $textDomain = $loader->load('en_US', 'default');
        $this->assertInstanceOf('Laminas\I18n\Translator\TextDomain', $textDomain);
    }

    public function testLoaderReturnsValidTextDomain()
    {
        $loader = new PhpMemoryArrayLoader(include $this->testFilesDir . '/translation_en.php');
        $textDomain = $loader->load('en_US', 'default');

        $this->assertEquals('Message 1 (en)', $textDomain['Message 1']);
        $this->assertEquals('Message 4 (en)', $textDomain['Message 4']);
    }

    public function testLoaderLoadsPluralRules()
    {
        $loader     = new PhpMemoryArrayLoader(include $this->testFilesDir . '/translation_en.php');
        $textDomain = $loader->load('en_US', 'default');

        $this->assertEquals(2, $textDomain->getPluralRule()->evaluate(0));
        $this->assertEquals(0, $textDomain->getPluralRule()->evaluate(1));
        $this->assertEquals(1, $textDomain->getPluralRule()->evaluate(2));
        $this->assertEquals(2, $textDomain->getPluralRule()->evaluate(10));
    }
}