<?php

namespace App\Bot\Driver;

use BotMan\BotMan\Drivers\HttpDriver;
use BotMan\BotMan\Interfaces\WebAccess;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Collection;
use BotMan\BotMan\Users\User;

class ussd extends HttpDriver
{

    const DRIVER_NAME = 'USSD';
    /**
     * @inheritDoc
     */
    public function matchesRequest()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getMessages()
    {
        if (empty($this->messages)) {
            $message = $this->event->get('message');
            $userId = $this->event->get('userId');
            $sender = $this->event->get('sender', $userId);

            $incomingMessage = new IncomingMessage($message, $sender, $userId, $this->payload);

            $this->messages = [$incomingMessage];
        }

        return $this->messages;
    }

    /**
     * @inheritDoc
     */
    public function isConfigured()
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function getUser(IncomingMessage $matchingMessage)
    {
        return new User($matchingMessage->getSender());
    }

    /**
     * @inheritDoc
     */
    public function getConversationAnswer(IncomingMessage $message)
    {
        return Answer::create($message->getText())->setMessage($message);
    }

    /**
     * @inheritDoc
     */
    public function buildServicePayload($message, $matchingMessage, $additionalParameters = [])
    {
        if (! $message instanceof WebAccess && ! $message instanceof OutgoingMessage) {
            $this->errorMessage = 'Unsupported message type.';
            $this->replyStatusCode = 500;
        }
        return $message;
    }

    /**
     * @inheritDoc
     */
    public function sendPayload($payload)
    {
        return$payload;
    }

    /**
     * @inheritDoc
     */
    public function buildPayload(Request $request)
    {
        $this->payload = $request->request->all();
        $this->event = Collection::make($this->payload);
    }

    /**
     * @inheritDoc
     */
    public function sendRequest($endpoint, array $parameters, IncomingMessage $matchingMessage)
    {
        // TODO: Implement sendRequest() method.
    }
}
