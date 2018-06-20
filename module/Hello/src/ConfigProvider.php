<?php
/**
 * Skeleton application to build voice applications for Amazon Alexa with phlexa, PHP and Zend\Expressive
 *
 * @author     Ralf Eggert <ralf@travello.audio>
 * @license    http://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       https://github.com/phoice/phlexa-expressive-skeleton
 * @link       https://www.phoice.tech/
 * @link       https://www.travello.audio/
 */

namespace Hello;

use Hello\Config\RouterDelegatorFactory;
use Hello\Intent\HelloIntent;
use Hello\TextHelper\HelloTextHelper;
use Phlexa\Application\AlexaApplication;
use PhlexaExpressive\Intent\AbstractIntentFactory;
use PhlexaExpressive\TextHelper\TextHelperFactory;
use Zend\Expressive\Application;

/**
 * Class ConfigProvider
 *
 * @package Hello
 */
class ConfigProvider
{
    /** Name of skill for configuration */
    const NAME = 'hello-skill';

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
                HelloTextHelper::class => TextHelperFactory::class,
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
                'hello' => [__DIR__ . '/../templates/hello'],
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
                'skillTitle'           => 'Hello World Alexa Skill',
                'applicationClass'     => AlexaApplication::class,
                'textHelperClass'      => HelloTextHelper::class,
                'sessionDefaults'      => [
                    'count' => 0,
                ],
                'smallImageUrl'        => APPLICATION_BASE_URL . '/cards/hello-480x480.png',
                'largeImageUrl'        => APPLICATION_BASE_URL . '/cards/hello-800x800.png',
                'backgroundImageUrl'   => APPLICATION_BASE_URL . '/cards/hello-1024x600.png',
                'backgroundImageTitle' => 'Hello World Alexa Skill',
                'intents'              => [
                    'aliases' => [
                        HelloIntent::NAME => HelloIntent::class,
                    ],

                    'factories' => [
                        HelloIntent::class => AbstractIntentFactory::class,
                    ],
                ],
                'texts'                => [
                    'de-DE' => include PROJECT_ROOT . '/data/texts/hello.common.texts.de-DE.php',
                    'en-UK' => include PROJECT_ROOT . '/data/texts/hello.common.texts.en-UK.php',
                    'en-US' => include PROJECT_ROOT . '/data/texts/hello.common.texts.en-US.php',
                ],
            ]
        ];
    }
}
