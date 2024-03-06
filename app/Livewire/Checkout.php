<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;
use WireUi\Traits\Actions;

class Checkout extends Component
{
    use Actions;
    public Event$event;
    public $payment_in_progress = false;
    public $payment_method;
    public $tickets = 1;
    public $subtotal;
    public $total;
    public $payment;
    public $order;
    public $batchId;
    public $phoneNumber;

    protected $rules = [
        'tickets' => 'required|numeric|min:1',
    ];
    public $orderId;
    public $full_names;
    public $email;

    public function mount()
    {
        $this->tickets = 1;
        $this->computeTotals();
    }

    #[On('updateTickets')]
    public function computeTotals()
    {

        $this->total = $this->tickets * $this->event->cost;
        $this->subtotal = $this->tickets * $this->event->cost;
    }

    #[On('checkout')]
    public function checkout(){
        $this->validate();
        $this->payment_method = 'MPESA';
        $this->payment_in_progress = true;
        $this->createOrder('INITIATED');
    }

    public function prcsCashPayment()
    {
        $validatedData = $this->validate([
            'full_names' => 'required|min:2',
            'email' => 'required|email',
            'phoneNumber' => ['required', 'regex:/^(0|\+254|254)\d{9}$/'],
        ],
            [ 'regex' => ' Enter a valid kenyan Number',
            ]);

        $this->payment_status = true;
        $this->payment_method = 'CASH';
        $this->notification()->success(
            $title = 'Payment Received',
            $description = 'Thank you for purchasing tickets'
        );
        $this->createOrder(0, 'PAID');
    }

    public function prcsMPesaPayment()
    {
        $validatedData = $this->validate([
            'full_names' => 'required|min:2',
            'email' => 'required|email',
            'phoneNumber' => ['required', 'regex:/^(0|\+254|254)\d{9}$/'],
        ],
            [ 'regex' => ' Enter a valid kenyan Number' ]);


        $this->payment_in_progress = true;
        $this->payment_method = 'MPESA';

        $mpesa= new \Safaricom\Mpesa\Mpesa();

        $BusinessShortCode = "7487337";
        $TransactionDesc ="Event Tickets Purchase Text40";
        $Remarks = 'Event ticket Purchase';
        $TransactionType = "CustomerPayBillOnline";
        $Amount = $this->total;
        $PartyA = '254' . substr($this->phoneNumber, -9);
        $PartyB =$BusinessShortCode;
        $PhoneNumber = $PartyA;
        $CallBackURL = URL('/api/MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1O');
        $LipaNaMpesaPasskey = 'd19d1f26e66073935e11f5265708d09422f1e6c36c49deb4a4de02b2668d0e46' ;
        //$LipaNaMpesaPasskey = env('MPESA_PassKey');
        $AccountReference = $this->event->name;

        $stkPushSimulation=$mpesa->STKPushSimulation($BusinessShortCode,
            $LipaNaMpesaPasskey,
            $TransactionType,
            $Amount,
            $PartyA,
            $PartyB,
            $PhoneNumber,
            $CallBackURL,
            $AccountReference,
            $TransactionDesc,
            $Remarks);
        $stkPushSimulation = json_decode($stkPushSimulation);

        $this->dialog()->success(
            $title = 'Initiate Payment - MPESA',
            $description = 'MPESA Prompt sent to your number'
        );
        $this->createOrder('Initiated');
        $this->payment_in_progress = true;
    }
    protected function createOrder($status, $CheckoutRequestID = null, $MerchantRequestID = null){
        $this->order = Order::create(
            [
                'tickets' => $this->tickets,
                'user_id' => Auth::check() ? Auth::id() : null,
                'phone_number' => $this->phoneNumber,
                'email' => $this->email,
                'event_id' => $this->event->id,
                'name' => $this->full_names,
                'amount' => $this->total,
                'payment_method' => $this->payment_method,
                'status' => $status,
                'CheckoutRequestID' => $CheckoutRequestID,
                'MerchantRequestID' => $MerchantRequestID,
            ]
        );
        $this->notification()->success(
            $title = 'Order Generated',
            $description = 'waiting for payment confirmation'
        );
        $this->orderId = $this->order->id;
        return true;
    }

    public function pollTransactionStatus()
    {
        $order = Order::find($this->orderId);
        if ($order){
            if ( strpos($order->status, "PAYMENT SUCCESSFUL") !== false ){
                $this->payment_in_progress = false;
                $this->dialog()->confirm([
                    'title'       => 'Successfully Purchased Ticket(s)',
                    'description' => 'Thank you for your ticket purchase! Your tickets have been successfully sent to your email. ',
                    'icon'        => 'badge-check',
                    'accept'      => [
                        'label'  => 'View Event',
                        'method' => 'redirectEvent',
                        'params' => 'Saved',
                    ],
                    'reject' => [
                        'label'  => 'Go Home',
                        'method' => 'redirectHome',
                    ],
                ]);

            }
            elseif( strpos($order->status, "PAYMENT ERROR") !== false ) {
                $this->payment_in_progress = false;
                $this->dialog()->error(
                    $title = 'Payment Error',
                    $description = 'There was an error processing your transaction. Please try again.'
                );

            }

        }
        $this->payment_in_progress = true;
        return  $this->payment_in_progress;

    }
    public function redirectEvent()
    {
        redirect()->route('event.view', ['event' => $this->event->id]);
    }

        public function redirectHome()
    {
        redirect()->route('landing');
    }
    public function render()
    {
        return view('livewire.checkout');
    }
}
