<div >



    <div class="relative  mt-2 mx-auto  w-3/4  ">


        <div class=" bg-white rounded-lg shadow dark:bg-gray-700">

            <div class="px-6 py-6 lg:px-8">
                <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white"> Create  Event</h3>

                <div>
                    <form wire:submit="create">
                        @csrf
                        {{ $this->form }}

                    </form>


                    <x-filament-actions::modals />
                </div>
            </div>

        </div>
    </div>

    <div class="flex justify-start m-5">
        <x-button wire:click="create" label="Submit"
                  type="button" icon="plus-circle"
                  x-on:click="close"
                  class="rounded-lg" lime />
    </div>

    <script>





    </script>


</div>
