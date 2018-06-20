<?php

namespace KlausKinski\Intent;

use Phlexa\Response\AlexaResponse;
use Phlexa\Response\Card\Standard;
use Phlexa\Response\OutputSpeech\SSML;

class QuoteIntent extends AbstractIntent
{
    const NAME = 'QuoteIntent';

    protected function onHandle(): AlexaResponse
    {
        $quote = $this->getRandomQuote('quotes');

        $alexaResponse = $this->getAlexaResponse();

        $alexaResponse->setOutputSpeech(new SSML($quote));

        $smallImageUrl = $this->getSkillConfiguration()->getSmallImageUrl();
        $largeImageUrl = $this->getSkillConfiguration()->getLargeImageUrl();

        $alexaResponse->setCard(
            new Standard('Klaus Kinski Quote Intent', $quote, $smallImageUrl, $largeImageUrl)
        );

        return $alexaResponse;
    }
}