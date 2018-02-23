<?php
namespace Translation;

use Locale;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\I18n\Translator\TranslatorServiceFactory;
use Zend\I18n\View\Helper as I18nHelper;

return [
    'translator' => [
        //*** need to configure the default locale and translation file patterns
        'locale' => 'en',
        'translation_file_patterns' => [
            [
                'type'     => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
            ],
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
        'factories' => [
            'MvcTranslator' => TranslatorServiceFactory::class,
        ],
        'services' => [
            'translation-supported' => [
                'de' => 'Deutsch',
                'en' => 'English',
                'es' => 'Español',
                'fr' => 'Français',
            ],
        ],
    ],
    'listeners' => [
        //*** add the listener aggregate here
        Listener\TranslationListenerAggregate::class,
    ],
    'view_helpers' => [
        'factories' => [
            I18nHelper\Translate::class => InvokableFactory::class,
            I18nHelper\CurrencyFormat::class => InvokableFactory::class,
            I18nHelper\DateFormat::class => InvokableFactory::class,
        ],
        'aliases' => [
            'translate' => I18nHelper\Translate::class,
            'currencyFormat' => I18nHelper\CurrencyFormat::class,
            'dateFormat' => I18nHelper\DateFormat::class,
        ],
    ],
];
