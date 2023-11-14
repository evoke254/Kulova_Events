<div>
    <x-card class=" flex-col justify-center items-center ">
        <div class="justify-center w-3/4">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-1 gap-4">
                    <div class="">
                        <x-errors class="mt-2 text-sm text-red-600 dark:text-red-500" />
                    </div>
                    <x-input label="Name" placeholder="category name" wire:model="event_category.name" />
                    <x-textarea wire:model="event_category.description" label="Comment (Optional)" placeholder="Description" />
                </div>

                <x-slot name="footer">
                    <div class="flex justify-end gap-4">

                        <div class="flex gap-4">
                            <x-button lime label="Save & Close" wire:click="save" class="rounded-lg shadow-lg" />
                        </div>
                    </div>
                </x-slot>
            </form>
        </div>
    </x-card>
</div>
