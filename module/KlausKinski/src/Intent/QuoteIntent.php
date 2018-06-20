<?php

namespace KlausKinski\Intent;

use Phlexa\Response\AlexaResponse;
use Phlexa\Response\OutputSpeech\SSML;

class QuoteIntent extends AbstractIntent
{
    const NAME = 'QuoteIntent';

    protected function onHandle(): AlexaResponse
    {
        $quote = $this->getRandomQuote('quotes');

        $alexaResponse = $this->getAlexaResponse();

        $alexaResponse->setOutputSpeech(new SSML($quote));

        return $alexaResponse;
    }
}