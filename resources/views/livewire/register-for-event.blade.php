<div>


    <div class="flex flex-col items-center justify-center px-6 pt-28 mt-10 my-auto mx-auto  pt:mt-0 dark:bg-gray-900">
        <a href="#" class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
            <img src="{{asset('images/logo.jpg')}}" class="mr-4 w-28 rounded-lg">
        </a>
        <!-- Card -->
        <div class="w-full max-w-4xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800 mb-3 foc">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white text-center text-capitalize">
                Register for <span class="text-green-600 dark:text-green-500"></span> {{$event->name}}
            </h2>
            <div class="my-2">
                <x-errors class="mt-2 text-sm text-red-600 dark:text-red-500" />
            </div>
                 <div>
                        <form wire:submit="create">
                            {{ $this->form }}

                            <div class="flex justify-end">

                            <x-button label="Submit" type="submit" icon="plus-circle" class="rounded-lg my-4" lime>

                            </x-button>
                            </div>
                        </form>

                        <x-filament-actions::modals />
                    </div>
        </div>
    </div>

</div>
