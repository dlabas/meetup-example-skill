<?php

namespace KlausKinski\Intent;

use Phlexa\Intent\AbstractIntent as AbstractPhlexaIntent;
use Phlexa\Response\AlexaResponse;

abstract class AbstractIntent extends AbstractPhlexaIntent
{
    const MAX_NUMBER_OF_LAST_QUOTES = 5;

    /**
     * @var array
     */
    protected $quotesList = [];

    /**
     * @var array
     */
    protected $sessionLastQuotes = [];

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
        $sessionContainer = $this->getAlexaResponse()->getSessionContainer();

        $this->sessionLastQuotes = $sessionContainer->getAttribute('lastQuotes');

        $alexaResponse = $this->onHandle();

        $alexaResponse->getSessionContainer()->setAttribute('lastQuotes', $this->sessionLastQuotes);

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

        if (count($this->sessionLastQuotes) >= static::MAX_NUMBER_OF_LAST_QUOTES) {
            array_shift($this->sessionLastQuotes);
        }

        do {
            $randomType      = is_null($typeSlot) ? array_rand($this->getQuotesList()[$locale]) : $typeSlot;
            $randomQuoteKey  = array_rand($this->getQuotesList()[$locale][$randomType]);
            $randomQuote     = $this->getQuotesList()[$locale][$randomType][$randomQuoteKey];
        } while (in_array($randomQuote, $this->sessionLastQuotes));

        $this->sessionLastQuotes[] = $randomQuote;

        return $randomQuote;
    }
}