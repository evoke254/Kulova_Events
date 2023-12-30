<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

    <div class="bg-white dark:bg-gray-900">
        <div class="mx-auto max-w-2xl px-4 pb-24 pt-16 sm:px-6 lg:max-w-7xl lg:px-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-gray-100 sm:text-4xl">Event Ticket</h1>

            <form class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
                <section aria-labelledby="cart-heading" class="lg:col-span-7">
                    <h2 id="cart-heading" class="sr-only text-gray-800 dark:text-gray-100">Items in your shopping cart</h2>

                    <ul role="list" class="divide-y divide-gray-200 border-b border-t border-gray-200">
                        <li class="flex py-6 sm:py-10">
                            {{--}}<div class="flex-shrink-0">
                                <img src="https://tailwindui.com/img/ecommerce-images/shopping-cart-page-01-product-01.jpg" alt="Front of men&#039;s Basic Tee in sienna." class="h-24 w-24 rounded-md object-cover object-center sm:h-48 sm:w-48">
                            </div>--}}

                            <div class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                                <div class="relative pr-9 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:pr-0">
                                    <div>
                                        <div class="flex justify-between">
                                            <h3 class="">
                                                <a href="#" class="font-medium hover:text-gray-800 text-gray-800 dark:text-gray-100 ">{{$event->name}} - (Kshs. {{$event->cost}})</a>
                                            </h3>
                                        </div>
                                        <div class="mt-1 flex text-sm">
                                            @if(!$event->images()->get()->isEmpty() )
                                                <img src="{{ asset('storage/'. $event->images()->first()->image)  }}" alt=""
                                                     class=" w-full rounded-2xl bg-gray-100">
                                            @endif
                                        </div>
                                        <p class="mt-1 text-sm font-medium text-gray-900">${{number_format($event->cost)}}</p>
                                    </div>

                                    <div class="mt-4 sm:mt-0 sm:pr-9">
                                        <div>
                                            <x-inputs.number wire:model="tickets" label="Number of Tickets" wire:change="computeTotals" />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                    </ul>
                </section>

                <!-- Order summary -->
                <section aria-labelledby="summary-heading" class="mt-16 rounded-lg bg-gray-100  dark:bg-gray-900 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
                    <h2 id="summary-heading" class="text-lg font-medium text-gray-900 dark:text-gray-200 ">Order summary</h2>

                    <dl class="mt-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <dt class="text-sm text-gray-600 dark:text-gray-100">Tickets</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ (int)$tickets  }}</dd>
                        </div>
                        <div class="flex items-center justify-between">
                            <dt class="text-sm text-gray-600 dark:text-gray-100">Subtotal</dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">kshs. {{number_format($subtotal, 2)}}</dd>
                        </div>
                        {{--}} <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                             <dt class="flex items-center text-sm text-gray-600 dark:text-gray-100">
                                 <span>Shipping estimate</span>
                                 <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                                     <span class="sr-only">Learn more about how shipping is calculated</span>
                                     <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                         <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.061-1.061 3 3 0 112.871 5.026v.345a.75.75 0 01-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 108.94 6.94zM10 15a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                     </svg>
                                 </a>
                             </dt>
                             <dd class="text-sm font-medium text-gray-900">$5.00</dd>
                         </div> --}}
                        <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                            <dt class="flex text-sm text-gray-600 dark:text-gray-100">
                                <span>Tax estimate</span>
                                <a href="#" class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                                    <span class="sr-only">Learn more about how tax is calculated</span>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.94 6.94a.75.75 0 11-1.061-1.061 3 3 0 112.871 5.026v.345a.75.75 0 01-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 108.94 6.94zM10 15a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </dt>
                            <dd class="text-sm font-medium text-gray-900 dark:text-gray-100">$--</dd>
                        </div>
                        <div class="flex items-center justify-between border-t border-gray-200 pt-4">
                            <dt class="text-base font-medium text-gray-900 dark:text-gray-100">Order total</dt>
                            <dd class="text-base font-medium text-gray-900 dark:text-gray-100">Kshs. {{number_format($total, 2)}}</dd>
                        </div>
                    </dl>



                    <div class=" space-y-2.5">
                        <x-errors class="mt-2 text-md text-red-600 dark:text-red-500" />
                    </div>

                    <div class="mt-8">
                        <div>
                            <label for="full_names" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Full Name <span class="text-danger-500 mr-2">*</span></label>
                            <input type="text" wire:model="full_names" id="full_names" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                   placeholder="Kevin Simiyu">
                        </div>
                    </div>
                    <div class="mt-3">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email <span class="text-danger-500 mr-2">*</span></label>
                        <input type="email" wire:model="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               placeholder="abc@example.com">
                    </div>


                    <div class="mt-3">
                        <label for="phoneNumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number <span class="text-danger-500 mr-2">*</span></label>
                        <input type="number" wire:model="phoneNumber" id="phoneNumber" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                               placeholder="0712345678">
                        <p class="text-gray-300 dark:text-gray-600 text-sm mx-auto">MPESA registered number to receive payment prompt</p>
                    </div>





                    <div class="mt-6 flex gap-3">
                        <x-button
                            icon="cash"
                            warning
                            label="Test"
                            class="w-full rounded-md px-4 py-3 text-gray-900"
                            wire:click="prcsCashPayment"
                        />
                        {{--}}                        <x-button
                                                    icon="cash"
                                                    warning
                                                    label="Paypal"
                                                    class="w-full rounded-md px-4 py-3 text-gray-900"
                                                    x-on:click="prcsPayPalPayment"
                                                /> --}}
                        <x-button
                            icon="credit-card"
                            lime label="MPESA"
                            class="w-full rounded-md px-4 py-3 text-gray-900"
                            wire:click="prcsMPesaPayment"
                        />
                    </div>



                    <div wire:ignore  class="mt-16 rounded-lg px-4 py-6 sm:p-6  space-y-2.5">
                        <div class="flex-grow col-span-2" id="paypal-button-container" ></div>
                    </div>



                </section>
            </form>
        </div>
    </div>




    @if(env('APP_ENV')  == 'local')
        <script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_SANDBOX_CLIENT_ID')}}&enable-funding=card&currency=USD"></script>
    @else
        <script src="https://www.paypal.com/sdk/js?client-id={{env('PAYPAL_LIVE_CLIENT_ID')}}&enable-funding=card&currency=USD"></script>
    @endif

    <script>
        function computeDateTime(){
        @this.dispatchSelf('computeDateTime');
        }

        //VisuaFusion paypal payment button script js
        /*************************************************************************************************************
         Paypal Payment on Click
         **************************************************************************************************************/

        function prcsPayPalPayment(){
            console.log('test');
            let el = document.getElementById('paypal-button-container');


            @this.dispatchSelf('checkout')

            var FUNDING_SOURCES = [
                paypal.FUNDING.CARD,
                paypal.FUNDING.PAYPAL,
            ];


            FUNDING_SOURCES.forEach(function(fundingSource) {
                try {
                    var button = paypal.Buttons({
                        fundingSource: fundingSource,
                        style: {
                            layout: 'horizontal',
                            // color: 'black',
                            shape: 'pill',
                            size: 'responsive',
                            //label:   'checkout',
                            tagline: false,
                            height: 40
                        },

                        createOrder: function(data, actions) {
                            // This function sets up the details of the transaction, including the amount and line item details.

                            return actions.order.create({
                                purchase_units: [{
                                    amount: {
                                        value: @this.get('total')
                                    }
                                }]
                            });
                        },


                        // Authorize or capture the transaction after payer approves
                        onApprove: (data, actions) => {


                            return fetch('api/success/order/'+ @this.get('orderId'), {
                                method: "POST"
                            }).then((res) => {
                                window.$wireui.notify({
                                    title: 'Success!',
                                    description: 'Payment Successful',
                                    icon: 'success',
                                    timeout: 30000
                                });

                                location.replace( '/dashboard' )
                            });

                            return fetch('api/success/order/'+ @this.get('orderId'), {
                                method: 'post'
                            });
                        },

                        onError: function(err) {
                            window.$wireui.notify({
                                title: 'Payment Error!',
                                description: err.message,
                                icon: 'error',
                                timeout: 30000
                            });
                        },
                        onCancel: function(data) {
                            // Show notification

                            window.$wireui.notify({
                                title: 'Error!',
                                description: 'Payment Canceled by User',
                                icon: 'error',
                                timeout: 30000
                            });
                        }
                    });



                    //button.render('#paypal-button-container')
                    if(fundingSource == 'card'){

                    }

                    //console.log(fundingSource);

                    if (button.isEligible()) {
                        button.render('#paypal-button-container');
                    }

                } catch (error) {


                    console.log(error);
                    window.$wireui.notify({
                        title: 'Payment Error!',
                        description:  error ,
                        icon: 'error',
                        timeout: 30000
                    });
                }


            });
        }

    </script>
</div>
