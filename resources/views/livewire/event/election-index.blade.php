<div>
    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700 w-full">
        <div class="w-full mb-1">
            <div class="mb-4">
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">All Elections</h1>
                </div>
                <div class=" flex gap-2">
{{--}}                    @livewire('event.election.create') --}}
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col ">
        <div class="overflow-x-auto w-100">
            <div class="min-w-full align-middle">
                <div class="overflow-hidden shadow w-100">

                    {{ $this->table }}
                </div>
            </div>
        </div>
    </div>
</div>
