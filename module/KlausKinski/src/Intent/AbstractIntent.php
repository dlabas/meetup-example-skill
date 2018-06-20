<?php

namespace KlausKinski\Intent;

use Phlexa\Intent\AbstractIntent as AbstractPhlexaIntent;
use Phlexa\Response\AlexaResponse;

abstract class AbstractIntent extends AbstractPhlexaIntent
{
    /**
     * @var array
     */
    protected $quotesList = [];

    /**
     * @return array
     */
    public function getQuotesList(): array
    {
        return $this->quotesList;
    }

    /**
     * @param array $quotesList
     * @return AbstractIntent
     */
    public function setQuotesList(array $quotesList): AbstractIntent
    {
        $this->quotesList = $quotesList;

        return $this;
    }

    /**
     * @return AlexaResponse
     */
    public function handle(): AlexaResponse
    {
        $alexaResponse = $this->onHandle();

        return $alexaResponse;
    }

    /**
     * @return AlexaResponse
     */
    abstract protected function onHandle(): AlexaResponse;

    /**
     * @param string|null $typeSlot
     *
     * @return string
     */
    protected function getRandomQuote(string $typeSlot = null)
    {
        $locale = $this->getAlexaRequest()->getRequest()->getLocale();

        $randomQuoteKey = array_rand($this->getQuotesList()[$locale][$typeSlot]);

        return $this->getQuotesList()[$locale][$typeSlot][$randomQuoteKey];
    }
}