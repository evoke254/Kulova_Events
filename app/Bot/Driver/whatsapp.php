<?php

namespace App\Bot\Driver;

use BotMan\BotMan\Drivers\HttpDriver;
use BotMan\BotMan\Interfaces\WebAccess;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Collection;
use BotMan\BotMan\Users\User;
use Illuminate\Support\Facades\Http;

class whatsapp extends HttpDriver
{

    const DRIVER_NAME = 'WABA';
    protected $facebookProfileEndpoint = 'https://graph.facebook.com/v16.0/';

    protected $replies = [];

    /** @var int */
    protected $replyStatusCode = 200;

    /** @var string */
    protected $messages = [];
    protected $interactive = false;
    protected $signature;

    protected $content;


    public function buildPayload(Request $request)
    {

        $this->payload = new ParameterBag((array) json_decode($request->getContent(), true));
        $this->event = Collection::make((array) $this->payload->get('entry', [null])[0]);
        $this->signature = $request->headers->get('X_HUB_SIGNATURE', '');
        $this->content = $request->getContent();
        $this->config = Collection::make($this->config->get('facebook', []));

    }

    public function matchesRequest()
    {

        $validSignature = empty($this->config->get('app_secret')) || $this->validateSignature();
        $messages = Collection::make($this->event->get('messaging'))->filter(function ($msg) {
            return (isset($msg['message']['text']) || isset($msg['postback']['payload'])) && !isset($msg['message']['is_echo']);
        });

        return !$messages->isEmpty() && $validSignature;
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
            'additionalParameters' => $additionalParameters,
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


    protected function buildReply($messages)
    {
        $replyData = Collection::make($messages)->transform(function ($replyData) {
            $reply = [];
            $message = $replyData['message'];
            $additionalParameters = $replyData['additionalParameters'];

            if ($message instanceof WebAccess) {
                $reply = $message->toWebDriver();
            } elseif ($message instanceof OutgoingMessage) {
                $attachmentData = (is_null($message->getAttachment())) ? null : $message->getAttachment()->toWebDriver();
                $reply = [
                    'type' => 'text',
                    'text' => $message->getText(),
                    'attachment' => $attachmentData,
                ];
            }
            $reply['additionalParameters'] = $additionalParameters;

            return $reply;
        })->toArray();

        return $replyData;
    }

    public function messagesHandled()
    {
        $messages = $this->buildReply($this->replies);

        // Reset replies
        $this->replies = [];
        dd($messages);
        echo json_encode($messages);

    }

    public function types(IncomingMessage $matchingMessage)
    {
        $this->replies[] = [
            'message' => 'TypingIndicator::create()',
            'additionalParameters' => [],
        ];
    }

    public function setIntercative(IncomingMessage $matchingMessage)
    {
        $this->interactive = true;
    }

    /**
     * Send a typing indicator and wait for the given amount of seconds.
     *
     * @param  IncomingMessage  $matchingMessage
     * @param  float  $seconds
     * @return mixed
     */
    public function typesAndWaits(IncomingMessage $matchingMessage, float $seconds)
    {

        $this->replies[] = [
            'message' => 'TypingIndicator::create($seconds)',
            'additionalParameters' => [],
        ];
    }


    /**
     * @inheritDoc
     */
    public function sendRequest($endpoint, array $parameters, IncomingMessage $matchingMessage)
    {
        // TODO: Implement sendRequest() method.
    }


    protected function validateSignature()
    {
        return hash_equals(
            $this->signature,
            'sha1=' . hash_hmac('sha1', $this->content, $this->config->get('app_secret'))
        );
    }

}
