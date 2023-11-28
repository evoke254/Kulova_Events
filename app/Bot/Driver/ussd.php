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
use Symfony\Component\HttpFoundation\Response;

class ussd extends HttpDriver
{

    const DRIVER_NAME = 'USSD';

    protected $replies = [];

    /** @var int */
    protected $replyStatusCode = 200;

    /** @var string */
    protected $messages = [];
    /**
     * @inheritDoc
     */
    public function matchesRequest()
    {return  true;
        return ($this->config['sessionId'])  == $this->event->get('sessionId') ;
    }

    /**
     * @inheritDoc
     */
    public function getMessages()
    {
        if (empty($this->messages)) {
            $message = $this->event->get('text');
            $phoneNumber = $this->event->get('phoneNumber');
            $sender = $this->event->get('sender', $phoneNumber);

            $incomingMessage = new IncomingMessage($message, $sender, $phoneNumber, $this->payload);

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
    public function getConversationAnswer(IncomingMessage $message): Answer
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
        return [
            'message' => $message,
        ];
    }

    /**
     * @inheritDoc
     */
    public function sendPayload($payload)
    {
        $this->replies[] = $payload;
    }

    /**
     * @inheritDoc
     */
    public function buildPayload(Request $request)
    {
        $this->payload = $request->request->all();
        $this->event = Collection::make($this->payload);
    }

    protected function buildReply($messages)
    {
        $replyData = Collection::make($messages)->transform(function ($replyData) {
            $reply = [];
            $message = $replyData['message'];

            if ($message instanceof OutgoingMessage) {
                $reply = $message->getText();
            }

            return $reply;
        })->toArray();

        return $replyData[0];
    }

    public function messagesHandled()
    {
        $messages = $this->buildReply($this->replies);

        // Reset replies
        $this->replies = [];
        header('Content-type: text/plain');
        echo $messages;
    }

    /**
     * @inheritDoc
     */
    public function sendRequest($endpoint, array $parameters, IncomingMessage $matchingMessage)
    {
        // TODO: Implement sendRequest() method.
    }

}
