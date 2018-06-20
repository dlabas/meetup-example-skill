<?php

namespace KlausKinski;

use KlausKinski\Config\RouterDelegatorFactory;
use KlausKinski\TextHelper\KlausKinskiTextHelper;
use Phlexa\Application\AlexaApplication;
use PhlexaExpressive\Intent\AbstractIntentFactory;
use PhlexaExpressive\TextHelper\TextHelperFactory;
use Zend\Expressive\Application;

/**
 * Class ConfigProvider
 *
 * @package KlausKinski
 */
class ConfigProvider
{
    /** Name of skill for configuration */
    const NAME = 'klaus-kinski-skill';

    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
            'skills'       => $this->getSkills(),
        ];
    }

    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [
                    RouterDelegatorFactory::class,
                ],
            ],
            'factories'  => [
                KlausKinskiTextHelper::class => TextHelperFactory::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'klaus-kinski' => [__DIR__ . '/../templates/klaus-kinski'],
            ],
        ];
    }

    /**
     * @return array
     */
    public function getSkills(): array
    {
        return [
            self::NAME => [
                'applicationId'        => 'amzn1.ask.skill.place-your-skill-id-here',
                'skillTitle'           => 'Klaus Kinski Alexa Skill',
                'applicationClass'     => AlexaApplication::class,
                'textHelperClass'      => KlausKinskiTextHelper::class,
                'sessionDefaults'      => [
                    'count' => 0,
                ],
                'smallImageUrl'        => APPLICATION_BASE_URL . '/images/klaus-kisnki_480x480.png',
                'largeImageUrl'        => APPLICATION_BASE_URL . '/images/klaus-kisnki_800x800.png',
                'backgroundImageUrl'   => APPLICATION_BASE_URL . '/images/klaus-kisnki_1024x600.png',
                'backgroundImageTitle' => 'Klaus Kinski Alexa Skill',
                'intents'              => [
                    'aliases' => [
                    ],

                    'factories' => [
                    ],
                ],
                'texts'                => [
                    'de-DE' => include __DIR__ . '/../data/texts/klaus-kinski.common.texts.de-DE.php',
                    'en-UK' => include __DIR__ . '/../data/texts/klaus-kinski.common.texts.en-UK.php',
                    'en-US' => include __DIR__ . '/../data/texts/klaus-kinski.common.texts.en-US.php',
                ],
            ]
        ];
    }
}
