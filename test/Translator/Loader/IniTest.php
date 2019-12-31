<?php

/**
 * @see       https://github.com/laminas/laminas-i18n for the canonical source repository
 * @copyright https://github.com/laminas/laminas-i18n/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-i18n/blob/master/LICENSE.md New BSD License
 */

namespace LaminasTest\I18n\Translator\Loader;

use Laminas\I18n\Translator\Loader\Ini as IniLoader;
use Locale;
use PHPUnit_Framework_TestCase as TestCase;

class IniTest extends TestCase
{
    protected $testFilesDir;
    protected $originalLocale;

    public function setUp()
    {
        $this->testFilesDir = realpath(__DIR__ . '/../_files');
    }

    public function testLoaderFailsToLoadMissingFile()
    {
        $loader = new IniLoader();
        $this->setExpectedException('Laminas\I18n\Exception\InvalidArgumentException', 'Could not open file');
        $loader->load('en_EN', 'missing');
    }

    public function testLoaderLoadsEmptyFile()
    {
        $loader = new IniLoader();
        $textDomain = $loader->load('en_EN', $this->testFilesDir . '/translation_empty.ini');
        $this->assertInstanceOf('Laminas\I18n\Translator\TextDomain', $textDomain);
    }

    public function testLoaderFailsToLoadNonArray()
    {
        $loader = new IniLoader();
        $this->setExpectedException('Laminas\I18n\Exception\InvalidArgumentException',
                                    'Each INI row must be an array with message and translation');
        $loader->load('en_EN', $this->testFilesDir . '/failed.ini');
    }

    public function testLoaderFailsToLoadBadSyntax()
    {
        $loader = new IniLoader();
        $this->setExpectedException('Laminas\I18n\Exception\InvalidArgumentException',
                                    'Each INI row must be an array with message and translation');
        $loader->load('en_EN', $this->testFilesDir . '/failed_syntax.ini');
    }

    public function testLoaderReturnsValidTextDomain()
    {
        $loader = new IniLoader();
        $textDomain = $loader->load('en_EN', $this->testFilesDir . '/translation_en.ini');

        $this->assertEquals('Message 1 (en)', $textDomain['Message 1']);
        $this->assertEquals('Message 4 (en)', $textDomain['Message 4']);
    }

    public function testLoaderReturnsValidTextDomainWithFileWithoutPlural()
    {
        $loader = new IniLoader();
        $textDomain = $loader->load('en_EN', $this->testFilesDir . '/translation_en_without_plural.ini');

        $this->assertEquals('Message 1 (en)', $textDomain['Message 1']);
        $this->assertEquals('Message 4 (en)', $textDomain['Message 4']);
    }

    public function testLoaderReturnsValidTextDomainWithSimpleSyntax()
    {
        $loader = new IniLoader();
        $textDomain = $loader->load('en_EN', $this->testFilesDir . '/translation_en_simple_syntax.ini');

        $this->assertEquals('Message 1 (en)', $textDomain['Message 1']);
        $this->assertEquals('Message 4 (en)', $textDomain['Message 4']);
    }

    public function testLoaderLoadsPluralRules()
    {
        $loader     = new IniLoader();
        $textDomain = $loader->load('en_EN', $this->testFilesDir . '/translation_en.ini');

        $this->assertEquals(2, $textDomain->getPluralRule()->evaluate(0));
        $this->assertEquals(0, $textDomain->getPluralRule()->evaluate(1));
        $this->assertEquals(1, $textDomain->getPluralRule()->evaluate(2));
        $this->assertEquals(2, $textDomain->getPluralRule()->evaluate(10));
    }
}
