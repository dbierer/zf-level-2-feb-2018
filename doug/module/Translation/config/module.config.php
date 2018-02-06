<?php
namespace Translation;
use Locale;
use Zend\I18n\Translator\TranslatorServiceFactory;
return [
    'translator' => [
        //*** need to configure the default locale and translation file patterns
        //'locale' => Locale::getDefault(),
        ],
    ],
    'service_manager' => [
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
        'factories' => [
            'MvcTranslator' => TranslatorServiceFactory::class,
        ],
    ],
    'listeners' => [
        //*** add the listener aggregate here
    ],
];
