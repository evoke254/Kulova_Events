<div>

    <div class="flex flex-col items-center justify-center px-6 pt-28 mt-10 my-auto mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
        <a href="#" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
            <img src="{{asset('images/logo.jpg')}}" class="mr-4 w-28 rounded-lg">
        </a>
        <!-- Card -->
        <div class="w-full max-w-4xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800 mb-3 foc">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center">
                SMS OTP
            </h2>
            <div class="my-2">
                <x-errors class="mt-2 text-sm text-red-600 dark:text-red-500" />
            </div>

            <div class="grid grid-cols-1 gap-4">
                <div class=" flex gap-3 ">
                    <div class="w-3/4">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number<span class="text-danger-500 mr-2">*</span></label>
                        <x-input type="number" wire:model="phone_no" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5
                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                    </div>
                    <div class="pt-7 ml-2">
                        <x-button warning wire:click="store" class=" px-5 py-3 text-base font-medium text-center text-white  rounded-lg ">Send SMS</x-button>
                    </div>
                </div>
                <div class="w-1/2">
                    <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Code</label>
                    <x-input type="number" wire:model="code" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5
                    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" />
                </div>

                <div class=" flex justify-center submit">
                        <x-button primary wire:click="submit" class=" px-5 py-3 text-base font-medium text-center text-white  rounded-lg ">Submit</x-button>
                </div>
            </div>

        </div>
    </div>
</div>
