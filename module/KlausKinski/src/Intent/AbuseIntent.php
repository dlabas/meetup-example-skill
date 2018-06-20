<?php

namespace KlausKinski\Intent;

use Phlexa\Response\AlexaResponse;
use Phlexa\Response\Card\Standard;
use Phlexa\Response\OutputSpeech\SSML;

class AbuseIntent extends AbstractIntent
{
    const NAME = 'AbuseIntent';

    protected function onHandle(): AlexaResponse
    {
        $abuseMsg = sprintf($this->getRandomQuote('abuses'), $this->getNameSlot());

        $alexaResponse = $this->getAlexaResponse();

        $alexaResponse->setOutputSpeech(new SSML($abuseMsg));

        $smallImageUrl = $this->getSkillConfiguration()->getSmallImageUrl();
        $largeImageUrl = $this->getSkillConfiguration()->getLargeImageUrl();

        $alexaResponse->setCard(
            new Standard('Klaus Kinski Abuse Intent', $abuseMsg, $smallImageUrl, $largeImageUrl)
        );

        return $alexaResponse;
    }

    protected function getNameSlot()
    {
        // Fallback name of no name is given
        $nameOfPerson = 'John Doe';

        /** @var array $slots */
        $slots = $this->getAlexaRequest()->getRequest()->getIntent()->getSlots();

        if (isset($slots['name']) && isset($slots['name']['value'])) {
            $nameOfPerson = $slots['name']['value'];
        } /*else {
            // @TODO check the dialogState (@link https://developer.amazon.com/de/docs/custom-skills/dialog-interface-reference.html#details)
            // $dialogState = $this->getAlexaRequest()->getRequest()->getDialogState();

            throw new \Exception('Missing "name" slot');
        }*/

        return $nameOfPerson;
    }
}