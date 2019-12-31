<?php

/**
 * @see       https://github.com/laminas/laminas-i18n for the canonical source repository
 * @copyright https://github.com/laminas/laminas-i18n/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-i18n/blob/master/LICENSE.md New BSD License
 */

return array(
    'code' => '853',
    'patterns' => array(
        'national' => array(
            'general' => '/^[268]\\d{7}$/',
            'fixed' => '/^(?:28[2-57-9]|8[2-57-9]\\d)\\d{5}$/',
            'mobile' => '/^6[236]\\d{6}$/',
            'emergency' => '/^999$/',
        ),
        'possible' => array(
            'general' => '/^\\d{8}$/',
            'emergency' => '/^\\d{3}$/',
        ),
    ),
);
