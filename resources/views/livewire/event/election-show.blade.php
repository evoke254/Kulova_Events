<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

    <div class="relative mx-auto  w-full h-full bg-gray-100 dark:bg-gray-700">
        <div class="relative w-full">
            <div class="relative flex justify-center rounded-lg gap-4  ">
                <!-- Event details -->
                <div class="w-full col-span-3 p-2 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex gap-2 justify-between border-b border-gray-200 dark:border-gray-600 mb-2 pb-4 mt-2">
                        <div>
                        <h5 class=" text-3xl font-bold text-gray-900 dark:text-white  ">Election :  {{$election->name}}</h5>
                            <x-badge flat positive lg label="{{ isset($election->type) ?$election::ELECTION_TYPE[$election->type] : ' ' }}" />
                        </div>

                        <h5 class=" text-2xl font-bold text-gray-900 dark:text-white  ">Update</h5>

                        <div class="">
                            @if(!$updating)
                                <x-button warning
                                          wire:click="isUpdating"
                                          icon="pencil"
                                          class="px-5 py-2.5 rounded-lg"
                                          label="Update - Positions | Candidates | Res... " />
                        </div>
                        @endif
                    </div>






                </div>

                @if($updating)
                    <div class=" bg-white dark:bg-gray-800 dark:border-gray-700">
                        <div class=" mb-2">
                            <div class=" rounded-lg shadow-lg p-6">
                                   <div class="flex justify-end gap-2">
                                            <x-button label="Close" wire:click="isUpdating" type="button" icon="plus-circle"  class="rounded-lg my-4" negative />
                                            <x-button label="Save" type="submit" icon="plus-circle"  class="rounded-lg my-4" positive />
                                        </div>
                                <form wire:submit="createPositions">
                                    {{ $this->form }}
                                        <div class="flex justify-end gap-2">

                                            <x-button label="Close" wire:click="isUpdating" type="button" icon="plus-circle"  class="rounded-lg my-4" negative />
                                            <x-button label="Submit" type="submit" icon="plus-circle"  class="rounded-lg my-4" positive>

                                            </x-button>
                                        </div>
                                </form>

                                <x-filament-actions::modals />
                            </div>
                        </div>
                    </div>
            </div>
            @endif
        </div>
    </div>
</div>
