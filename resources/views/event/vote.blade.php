<x-guest-layout>

    <div class=" min-h-fit flex justify-center">

        <div class="w-3/4">
            <div class="w-full p-4 text-center bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">{{$event->name}}</h5>

                <h5 class="mb-2 text-2xl font-semibold text-gray-900 dark:text-white mt-3">How would you like to vote?</h5>
                <p class="mb-5 text-base text-gray-500 sm:text-lg dark:text-gray-400">
                    XXXXXXXXXXXXXX  Add some more explanation
                </p>
                <div class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 mt-5">
                    <a href="{{route('event.vote.online', ['event' => $event])}}" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-300 text-white rounded-lg inline-flex items-center justify-center px-4 py-2.5 dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-700">
                        <x-icon class="mr-3 w-7 h-7" name="wifi"/>
                        <div class="text-center">
                            <div class="mb-1 text-sm">
                                Phone or Laptop
                            </div>
                            <div class="-mt-1 font-sans text-sm font-semibold">Vote Online</div>
                        </div>
                    </a>

                </div>
            </div>
        </div>




    </div>



</x-guest-layout>
