<div>

    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700 w-full">
        <div class="w-full mb-1">
            <div class="mb-4">
            </div>
            <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">

                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Events</h1>
                </div>
                <div class=" flex gap-2">
                    {{--}}<x-button label="Create" icon="plus-circle" class="rounded-lg" lime
                              href="{{route('events.create')}}"
                    /> --}}

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




    <x-modal.card
        max-width='7xl'
        blur
        static
        x-on:recipient-created:create-recipient-modal.window="close"
        name="createOrganizationModal"
        wire:model.defer="createOrganizationModal"
        class="w-full">
            @livewire('event.create')

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">

                <div class="flex">
                    <x-button rounded negative label="Close" x-on:click="close" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>


</div>
