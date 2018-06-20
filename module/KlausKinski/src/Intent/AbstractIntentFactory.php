<?php

namespace KlausKinski\Intent;

use Interop\Container\ContainerInterface;
use PhlexaExpressive\Intent\AbstractIntentFactory as AbstractPhlexaIntentFactory;

class AbstractIntentFactory extends AbstractPhlexaIntentFactory
{
    /**
     * @inheritdoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $intent = parent::__invoke($container, $requestedName, $options);

        if ($intent instanceof AbstractIntent) {
            $quotesList = include PROJECT_ROOT . '/module/KlausKinski/data/texts/klaus-kinski.quotes-list.texts.php';

            $intent->setQuotesList($quotesList);
        }

        return $intent;
    }
}