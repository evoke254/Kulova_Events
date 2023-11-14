<div>
    <x-button lime class="rounded-lg dark:bg-gray-700 " label="Add Category"
              onclick="$openModal('addCategoryModal')"
              icon="plus-circle"/>

    <x-modal.card
        x-on:close-modal.window="close"
 class="font-bold" title="Add Category" blur wire:model.defer="addCategoryModal">
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
                        <x-button negative  class="rounded-lg shadow-lg" label="Cancel" x-on:click="close" />
                        <x-button lime label="Save & Close" wire:click="save" class="rounded-lg shadow-lg" />
                    </div>
                </div>
            </x-slot>
        </form>
    </x-modal.card>

</div>
