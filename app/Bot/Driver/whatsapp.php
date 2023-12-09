<?php

namespace App\Bot\Driver;

use App\Models\BotLogs;
use BotMan\BotMan\Drivers\HttpDriver;
use BotMan\BotMan\Interfaces\WebAccess;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Collection;
use BotMan\BotMan\Users\User;
use Illuminate\Support\Facades\Http;
use BotMan\BotMan\Drivers\Events\GenericEvent;
use BotMan\BotMan\Interfaces\DriverEventInterface;
use BotMan\BotMan\Interfaces\VerifiesService;
use BotMan\BotMan\Messages\Attachments\Audio;
use BotMan\BotMan\Messages\Attachments\File;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Attachments\Video;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Facebook\Events\MessagingDeliveries;
use BotMan\Drivers\Facebook\Events\MessagingOptins;
use BotMan\Drivers\Facebook\Events\MessagingReads;
use BotMan\Drivers\Facebook\Events\MessagingReferrals;
use BotMan\Drivers\Facebook\Exceptions\FacebookException;
use Symfony\Component\HttpFoundation\Response;
use BotMan\Drivers\Facebook\Extensions\Airline\AirlineBoardingPass;
use BotMan\Drivers\Facebook\Extensions\AirlineCheckInTemplate;
use BotMan\Drivers\Facebook\Extensions\AirlineItineraryTemplate;
use BotMan\Drivers\Facebook\Extensions\AirlineUpdateTemplate;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;
use BotMan\Drivers\Facebook\Extensions\ListTemplate;
use BotMan\Drivers\Facebook\Extensions\MediaTemplate;
use BotMan\Drivers\Facebook\Extensions\OpenGraphTemplate;
use BotMan\Drivers\Facebook\Extensions\ReceiptTemplate;
class whatsapp extends HttpDriver implements VerifiesService
{

    const HANDOVER_INBOX_PAGE_ID = '263902037430900';

    const TYPE_RESPONSE = 'RESPONSE';
    const TYPE_UPDATE = 'UPDATE';
    const TYPE_MESSAGE_TAG = 'MESSAGE_TAG';

    /** @var string */
    protected $signature;

    /** @var string */
    protected $content;

    /** @var array */
    protected $messages = [];
    protected $replies = [];
    /** @var array */
    protected $templates = [
        AirlineBoardingPass::class,
        AirlineCheckInTemplate::class,
        AirlineItineraryTemplate::class,
        AirlineUpdateTemplate::class,
        ButtonTemplate::class,
        GenericTemplate::class,
        ListTemplate::class,
        ReceiptTemplate::class,
        MediaTemplate::class,
        OpenGraphTemplate::class,
    ];

    private $supportedAttachments = [
        Video::class,
        Audio::class,
        Image::class,
        File::class,
    ];

    /** @var DriverEventInterface */
    protected $driverEvent;
    const DRIVER_NAME = 'WABA';
    protected $facebookProfileEndpoint = 'https://graph.facebook.com/v18.0/';

    protected $interactive = false;
    protected $isPostback = false;
    protected $waba_id;



    public function buildPayload(Request $request)
    {

        $this->payload = new ParameterBag((array) json_decode($request->getContent(), true));
        $event = Collection::make((array) $this->payload->get('entry', [null])[0]);
        $this->waba_id = $event->get('id');
        $value = Collection::make($event->get('changes'));
        $this->event = Collection::make($value[0]["value"]);
        $this->signature = $request->headers->get('X_HUB_SIGNATURE', '');
        $this->content = $request->getContent();
        $this->config = Collection::make($this->config->get('facebook', []));

    }
    /**
     * Determine if the request is for this driver.
     *
     * @return bool
     */
    public function matchesRequest()
    {
        if (isset($this->event['messages'][0]['id'])){
            $db_log = BotLogs::where('message_id', $this->event['messages'][0]['id'])->first();
            if ($db_log){
                return false;
            }
        }


        return (isset($this->event['messages'][0]) && isset($this->event['messages'][0]['from']));
    }

    /**
     * @param  Request  $request
     * @return null|Response
     */
    public function verifyRequest(Request $request)
    {
        if ($request->get('hub_mode') === 'subscribe' && $request->get('hub_verify_token') === $this->config->get('verification')) {
            return (new Response($request->get('hub_challenge')))->send();
        }
    }

    /**
     * @return bool|DriverEventInterface
     */
    public function hasMatchingEvent()
    {
        $event = Collection::make($this->event->get('messaging'))->filter(function ($msg) {
            return Collection::make($msg)->except([
                    'sender',
                    'recipient',
                    'timestamp',
                    'message',
                    'postback',
                    'thread_id',
                ])->isEmpty() === false;
        })->transform(function ($msg) {
            return Collection::make($msg)->toArray();
        })->first();

        if (!is_null($event)) {
            $this->driverEvent = $this->getEventFromEventData($event);

            return $this->driverEvent;
        }

        return false;
    }

    /**
     * @param  array  $eventData
     * @return DriverEventInterface
     */
    protected function getEventFromEventData(array $eventData)
    {
        $name = Collection::make($eventData)->except([
            'sender',
            'recipient',
            'timestamp',
            'message',
            'postback',
            'thread_id',
        ])->keys()->first();
        switch ($name) {
            case 'referral':
                return new MessagingReferrals($eventData);
                break;
            case 'optin':
                return new MessagingOptins($eventData);
                break;
            case 'delivery':
                return new MessagingDeliveries($eventData);
                break;
            case 'read':
                return new MessagingReads($eventData);
                break;
            case 'account_linking':
                return new Events\MessagingAccountLinking($eventData);
                break;
            case 'checkout_update':
                return new Events\MessagingCheckoutUpdates($eventData);
                break;
            default:
                $event = new GenericEvent($eventData);
                $event->setName($name);

                return $event;
                break;
        }
    }

    /**
     * @return bool
     */
    protected function validateSignature()
    {
        return hash_equals(
            $this->signature,
            'sha1=' . hash_hmac('sha1', $this->content, $this->config->get('app_secret'))
        );
    }

    /**
     * @param  IncomingMessage  $matchingMessage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function markSeen(IncomingMessage $matchingMessage)
    {
        $parameters = [
            'recipient' => [
                'id' => $matchingMessage->getSender(),
            ],
            'access_token' => $this->config->get('token'),
            'sender_action' => 'mark_seen',
        ];

        return $this->http->post($this->facebookProfileEndpoint . 'me/messages', [], $parameters);
    }

    /**
     * @param  IncomingMessage  $matchingMessage
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function types(IncomingMessage $matchingMessage)
    {
        $parameters = [
            'recipient' => [
                'id' => $matchingMessage->getSender(),
            ],
            'access_token' => $this->config->get('token'),
            'sender_action' => 'typing_on',
        ];

        return $this->http->post($this->facebookProfileEndpoint . 'me/messages', [], $parameters);
    }

    /**
     * @param  IncomingMessage  $message
     * @return Answer
     */
    public function getConversationAnswer(IncomingMessage $message)
    {
        return Answer::create($message->getText())->setMessage($message);
    }

    /**
     * Retrieve the chat message.
     *
     * @return array
     */
    public function getMessages()
    {
        if (empty($this->messages)) {
            $message =  $this->event['messages'][0]['text']['body'];
            $userId = $this->event['messages'][0]['from'];
            $this->messages = [new IncomingMessage($message, $userId, $userId, $this->payload)];
        }

        return $this->messages;
    }

    /**
     * @return bool
     */
    public function isBot()
    {
        // Facebook bot replies don't get returned
        return false;
    }

    /**
     * Tells if the current request is a callback.
     *
     * @return bool
     */
    public function isPostback()
    {
        return $this->isPostback;
    }

    /**
     * Convert a Question object into a valid Facebook
     * quick reply response object.
     *
     * @param  Question  $question
     * @return array
     */
    private function convertQuestion(Question $question)
    {
        $questionData = $question->toArray();

        $replies = Collection::make($question->getButtons())
            ->map(function ($button) {
                if (isset($button['content_type']) && $button['content_type'] !== 'text') {
                    return ['content_type' => $button['content_type']];
                }

                return array_merge([
                    'content_type' => 'text',
                    'title' => $button['text'] ?? $button['title'],
                    'payload' => $button['value'] ?? $button['payload'],
                    'image_url' => $button['image_url'] ?? $button['image_url'],
                ], $button['additional'] ?? []);
            });

        return [
            'text' => $questionData['text'],
            'quick_replies' => $replies->toArray(),
        ];
    }

    /**
     * @param  string|Question|IncomingMessage  $message
     * @param  IncomingMessage  $matchingMessage
     * @param  array  $additionalParameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function buildServicePayload($message, $matchingMessage, $additionalParameters = [])
    {

        $parameters = array_merge_recursive([
            "messaging_product"=> "whatsapp",
            "context" => ["message_id" => $this->event['messages'][0]['id']],
            "recipient_type"=> "individual",
            "to"=> '+'.$this->event['messages'][0]['from'],
            "type"=> 'text',
            'text' => [
                'body' => $message,
            ],
        ]);
        /*
         * If we send a Question with buttons, ignore
         * the text and append the question.
         */
        if ($message instanceof Question) {
            $parameters['text'] = $this->convertQuestion($message);
        }
        //elseif (is_object($message) && in_array(get_class($message), $this->templates)) {
        //    $parameters['message'] = $message->toArray();}
        elseif ($message instanceof OutgoingMessage) {
            //Currently there are no attachments though
            $attachment = $message->getAttachment();
            if (!is_null($attachment) && in_array(get_class($attachment), $this->supportedAttachments)) {
                $attachmentType = strtolower(basename(str_replace('\\', '/', get_class($attachment))));
                unset($parameters['message']['text']);
                $parameters['message']['attachment'] = [
                    'type' => $attachmentType,
                    'payload' => [
                        'is_reusable' => $attachment->getExtras('is_reusable') ?? false,
                        'url' => $attachment->getUrl(),
                    ],
                ];
            } else {
                $parameters['text']['body'] = $message->getText();
            }
        }

//        $parameters['access_token'] = $this->config->get('token');

        return $parameters;



    }

    /**
     * @param  mixed  $payload
     * @return \GuzzleHttp\Promise\PromiseInterface|\Illuminate\Http\Client\Response
     *
     * @throws FacebookException
     */
    public function sendPayload($payload)
    {


        try {

            $response = Http::withHeaders([
                'Authorization' => $this->config->get('token'),
                'Content-Type'=> 'application/json'
            ])->post($this->facebookProfileEndpoint.$this->event['metadata']['phone_number_id'].'/messages', $payload);


            // Handle the API response as needed
            $statusCode = $response->status();
            $responseData = $response->json();

            // Your further logic based on the API response
            if ($statusCode == 200) {
                // Successful request

                $db_log = new BotLogs();
                $db_log->message_id = $responseData['messages'][0]['id'];
                $db_log->data_1 = $responseData['contacts'][0]['input'];
                $db_log->save();

                return $response;
            } else {
                // Handle errors
                // Access $responseData for error details
                Log::error($responseData);
            }
        } catch (\Exception $e) {
            // Handle exceptions, such as connection errors
            Log::error( 'Error: ' . $e->getMessage());
        }

    }

    /**
     * @return bool
     */
    public function isConfigured()
    {
        return !empty($this->config->get('token'));
    }

    /**
     * Retrieve specific User field information.
     *
     * @param  array  $fields
     * @param  IncomingMessage  $matchingMessage
     * @return User
     *
     * @throws FacebookException
     */
    public function getUserWithFields(array $fields, IncomingMessage $matchingMessage)
    {
        $messagingDetails = $this->event->get('messaging')[0];
        // implode field array to create concatinated comma string
        $fields = implode(',', $fields);
        // WORKPLACE (Facebook for companies)
        // if community isset in sender Object, it is a request done by workplace
        if (isset($messagingDetails['sender']['community'])) {
            $fields = 'first_name,last_name,email,title,department,employee_number,primary_phone,primary_address,picture,link,locale,name,name_format,updated_time';
        }
        $userInfoData = $this->http->get($this->facebookProfileEndpoint . $matchingMessage->getSender() . '?fields=' . $fields . '&access_token=' . $this->config->get('token'));
        $this->throwExceptionIfResponseNotOk($userInfoData);
        $userInfo = json_decode($userInfoData->getContent(), true);
        $firstName = $userInfo['first_name'] ?? null;
        $lastName = $userInfo['last_name'] ?? null;

        return new User($matchingMessage->getSender(), $firstName, $lastName, null, $userInfo);
    }

    /**
     * Retrieve User information.
     *
     * @param  IncomingMessage  $matchingMessage
     * @return User
     *
     * @throws FacebookException
     */
    public function getUser(IncomingMessage $matchingMessage)
    {
        $firstName = $this->event['contacts'][0]['profile']['name'] ?? null;
        $lastName = ' ';
        $username = $this->event['contacts'][0]['wa_id'];

        return new User($matchingMessage->getSender(), $firstName, $lastName, $username, null);
    }

    /**
     * Low-level method to perform driver specific API requests.
     *
     * @param  string  $endpoint
     * @param  array  $parameters
     * @param  IncomingMessage  $matchingMessage
     * @return Response
     */
    public function sendRequest($endpoint, array $parameters, IncomingMessage $matchingMessage)
    {
        //TODo method needed for low level
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param  Response  $facebookResponse
     * @return mixed
     *
     * @throws FacebookException
     */
    protected function throwExceptionIfResponseNotOk(Response $facebookResponse)
    {
        if ($facebookResponse->getStatusCode() !== 200) {
            $responseData = json_decode($facebookResponse->getContent(), true);
            throw new FacebookException('Error sending payload: ' . $responseData['error']['message']);
        }
    }

    /**
     * @param $msg
     * @return string|null
     */
    protected function getMessageSender($msg)
    {
        if (isset($msg['sender'])) {
            return $msg['sender']['id'];
        } elseif (isset($msg['optin'])) {
            return $msg['optin']['user_ref'];
        }
    }

    /**
     * @param $msg
     * @return string|null
     */
    protected function getMessageRecipient($msg)
    {
        if (isset($msg['recipient'])) {
            return $msg['recipient']['id'];
        }
    }

    /**
     * Pass a conversation to the page inbox.
     *
     * @param  IncomingMessage  $message
     * @param $bot
     * @return Response
     */
    public function handover(IncomingMessage $message, $bot)
    {
        return $this->http->post($this->facebookProfileEndpoint . 'me/pass_thread_control?access_token=' . $this->config->get('token'), [], [
            'recipient' => [
                'id' => $message->getSender(),
            ],
            'target_app_id' => self::HANDOVER_INBOX_PAGE_ID,
        ]);
    }

}
