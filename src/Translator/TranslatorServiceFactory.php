<?php

/**
 * @see       https://github.com/laminas/laminas-i18n for the canonical source repository
 * @copyright https://github.com/laminas/laminas-i18n/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-i18n/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\I18n\Translator;

use Laminas\ServiceManager\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;

/**
 * Translator.
 *
 * @category   Laminas
 * @package    Laminas_I18n
 * @subpackage Translator
 */
class TranslatorServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        // Configure the translator
        $config = $serviceLocator->get('Configuration');
        $trConfig = isset($config['translator']) ? $config['translator'] : array();
        $translator = Translator::factory($trConfig);
        return $translator;
    }
}
