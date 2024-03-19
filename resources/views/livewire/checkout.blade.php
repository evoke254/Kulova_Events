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
                            <div class="ml-3 flex flex-1 flex-col justify-between sm:ml-6">
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
                                            <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Number Of Tickets:</label>
                                            <input type="number" wire:model="tickets" wire:change="computeTotals" id="number-input" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="1" required />
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </li>
                    </ul>
                </section>

                <!-- Order summary -->
                <section aria-labelledby="summary-heading" class="mt-16 rounded-lg bg-gray-100  dark:bg-gray-900 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8" wire:poll="pollTransactionStatus">
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

                  @if(!$payment_in_progress)
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
                        <p class="text-gray-500 dark:text-gray-400 text-sm mx-auto mt-2">MPESA registered number to receive payment prompt</p>
                    </div>


                    <div class="mt-6 flex gap-3">
                        <x-button
                            icon="credit-card"
                            lime label="MPESA"
                            class="w-full rounded-md px-4 py-3 text-gray-900"
                            wire:click="prcsMPesaPayment"
                        />
                    </div>
                    @else
                    <div class="w-full mx-auto   m-10">
                        <div role="status" class="align-content-center " >
                            <svg aria-hidden="true" class="mx-auto w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                            </svg>
                            <span class="sr-only mx-auto">Loading...</span>
                        </div>
                    </div>
                    @endif

                </section>
            </form>
        </div>
    </div>




    <script>

    </script>
</div>
