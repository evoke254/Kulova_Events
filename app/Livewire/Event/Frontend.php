<?php

namespace App\Livewire\Event;

use App\Models\Event;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class Frontend extends Component
{
        use Actions;
    public $events;

    public Event $selectedEvent;
    public $subtotal = 0;    public $batchId;
    public $tax = 0;
    public $total = 0;
        protected $rules = [
        'cycle' => 'required|numeric|min:1',
        'qty' => 'required|numeric|min:1',
    ];

    public function confirmCheckout(Event $event){

        $this->selectedPackage = $event;
        // use a full syntax
        $this->dialog()->confirm([
            'title'       => 'Buy Tickets?',
            'class' => 'text-xl, ',
            'description' => 'Proceed to checkout?',
            'icon'        => 'question',
            'accept'      => [
                'label'  => 'Yes, checkout',
                'method' => 'initCheckout',
                'params' => 'Saved',
                'color' => 'lime',
                'size' => 'md'
            ],
            'reject' => [
                'label'  => 'No, cancel',
                //TODO add function to log each time a user cancels
                //           'method' => 'custom_log',
                'color' => 'red',
                'size' => 'md'
            ],
        ]);
    }
        public function initCheckout(){
        $this->step = $this->steps[1];
        $this->cycle = 3;
        $this->qty = 1;

    }

    public function mount(){
        $this->events = Event::orderBy('start_date', 'Desc')
                                                    ->get();
    }


        protected function createOrder(){
        $this->order = Order::updateOrCreate(
            ['id' => isset($this->order->id) ? $this->order->id : null],
            [
                'qty' => $this->qty,
                'user_id' => Auth::id(),
                'package_id' => $this->selectedPackage->id,
                'job_id' => null,
                'amount' => $this->total,
                'payment_method' => 'CASH',
                'status' => 'INITIALIZED'
            ]
        );
        $this->orderId = $this->order->id;
    }
    public function render()
    {
        return view('livewire.event.frontend');
    }
}
