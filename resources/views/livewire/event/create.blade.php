<div>

    <div class="relative  mt-2 mx-auto  w-3/4 p-4 h-full ">
        <div class="relative w-full">

            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white"> {{isset($event) ? 'Update' : 'Create'}}  Event</h3>
                    <form class="space-y-6" action="createEvent" wire:submit.prevent="createEvent">

                        <div class="">
                            <x-errors class="mt-2 text-sm text-red-600 dark:text-red-500" />
                        </div>


                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event Name *</label>
                            <input type="text" wire:model="event.name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                   placeholder="Annual general Meeting-{{date('Y')}}">
                            @error('event.name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                {{$message}}</p>
                            @enderror
                        </div>

                        <div class="grid md:grid-cols-2  gap-4">
                            <div class="pt-2">
                                <label for="event.organization_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Organization *</label>
                                <select type="event.organization_id"
                                        wire:model="event.organization_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                >
                                    <option> Select An Organization</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{$organization['id']}}">{{$organization['name']}}</option>
                                    @endforeach
                                </select>
                                @error('event.organization_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Sorry!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>


                            <div class="pt-2">
                                <label for="event.cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event Cost (Optional)</label>
                                <input type="number"
                                       wire:model="event.cost" id="email"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                       placeholder="100,000" >
                                @error('event.cost')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>


                            <div class="pt-2">
                                <label for="mail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea
                                    wire:model="event.description"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500
                                          block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                >
                                </textarea>
                                @error('event.description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>

                            <div class="pt-2">
                                <label for="mail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                                <textarea
                                    wire:model="event.venue"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500
                                          block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                >
                                </textarea>
                                @error('event.venue')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>



                            <div class="pt-2">
                                <div>
                                    <x-datetime-picker
                                        min="today"
                                        interval="30"
                                        time-format="24"
                                        display-format="ddd, DD MMM YYYY - HH:mm"
                                        label="Event Start Date"
                                        placeholder="Event Start Date"
                                        wire:model.defer="start_date"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    />
                                </div>
                            </div>


                            <div class="pt-2">
                                <div>
                                    <x-datetime-picker
                                        min="today"
                                        interval="30"
                                        time-format="24"
                                        display-format="ddd, DD MMM YYYY - HH:mm"
                                        label="Event End Date"
                                        placeholder="Event End Date"
                                        wire:model.defer="end_date"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    />
                                </div>
                            </div>
                        </div>


                        <div class="flex justify-end gap-4">
                            <button type="submit"  class="w-1/4  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/datepicker.min.js" ></script>



    <script>

        document.addEventListener('livewire:initialized', () => {

            const startDatepickerEl = document.getElementById('start_date');
            const endDatepickerEl = document.getElementById('end_date');

            endDatepickerEl.addEventListener('changeDate', (event2) => {
                console.log(event2.detail);
            @this.dispatch('endDateSelected', {date: event2.detail.date});
            });

            startDatepickerEl.addEventListener('changeDate', (event) => {
            @this.dispatch('startDateSelected', {date: event.detail.date});
            });

        });


    </script>


</div>
