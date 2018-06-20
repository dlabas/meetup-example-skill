<?php

namespace KlausKinski\Config;

use KlausKinski\ConfigProvider;
use Interop\Container\ContainerInterface;
use PhlexaExpressive\Handler\HtmlPageHandler;
use PhlexaExpressive\Handler\SkillHandler;
use Zend\Expressive\Application;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * Class RouterDelegatorFactory
 *
 * @package KlausKinski\Config
 */
class RouterDelegatorFactory implements DelegatorFactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string             $name
     * @param callable           $callback
     * @param array|null|null    $options
     *
     * @return mixed
     */
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        /** @var Application $application */
        $application = $callback();

        $application->post('/klaus-kinski', SkillHandler::class, 'klaus-kinski')
                    ->setOptions(['defaults' => ['skillName' => ConfigProvider::NAME]]);

        $application->get('/klaus-kinski/privacy', HtmlPageHandler::class, 'klaus-kinski-privacy')
                    ->setOptions(['defaults' => ['template' => 'klaus-kinski::privacy']]);

        $application->get('/klaus-kinski/terms', HtmlPageHandler::class, 'klaus-kinski-terms')
                    ->setOptions(['defaults' => ['template' => 'klaus-kinski::terms']]);

        return $application;
    }
}
