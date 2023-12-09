<div>


    <div class="relative  mt-2 mx-auto  w-3/4 p-4 h-full ">
        <div class="relative w-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="px-6 py-6 lg:px-8">

                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white"> {{isset($organization['id']) ? 'Update' : 'Create'}} Organization</h3>
                    <div>
                        <form wire:submit="create">
                            {{ $this->form }}

                            <div class="flex justify-end">

                            <x-button label="Submit" type="submit" icon="plus-circle" x-on:click="close"  class="rounded-lg my-4" lime>

                            </x-button>
                            </div>
                        </form>

                        <x-filament-actions::modals />
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>
