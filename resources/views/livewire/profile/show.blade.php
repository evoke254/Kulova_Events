<div>
    <div class="px-4 py-4">

           <div class="items-center justify-between block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">

            <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white mt-3">Organization settings - {{$organization->name}}</h1>
                </div>
                <div class=" flex gap-2">
                    <x-button label="Update" icon="cog" class="rounded-lg p-3" lime
                              x-on:click="$openModal('createOrganizationModal')"
                    />

                </div>
            </div>
    </div>

    <div class="flex
    gap-2
                            px-4 pt-4
                            dark:bg-gray-900 ">


        <div class="w-full">
            @livewire('profile.user', ['user' => $user, 'organization' => $organization])
        </div>

    </div>
{{--}}
    <!-- Right Hand side -->
    <div>


        @livewire('profile.partials.picture', ['user' => $user])

        <div class="max-w-full mx-auto space-y-6">
            <div class=" sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class=" sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class=" sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div> --}}



    <x-modal.card
        max-width='7xl'
        blur
        static
        x-on:recipient-created:create-recipient-modal.window="close"
        name="createOrganizationModal"
        wire:model.defer="createOrganizationModal"
        class="w-full">
            @livewire('organization.edit' , ['organization' => $organization])

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">

                <div class="flex">
                    <x-button rounded negative label="Close" x-on:click="close" />
                </div>
            </div>
        </x-slot>
    </x-modal.card>


</div>
