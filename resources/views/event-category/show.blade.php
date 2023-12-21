<x-app-layout>




    <div class="relative  mt-2 mx-auto  w-full p-4 h-full bg-gray-100 dark:bg-gray-700">
        <div class="relative w-full">
            <div class="relative flex rounded-lg gap-4  p-4 ">
                <!-- Event details -->
                <div class="w-3/4 col-span-3 p-2 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <div class="border-b border-gray-200 dark:border-gray-600 mb-2 pb-4 ">
                        <h5 class=" text-3xl font-bold text-gray-900 dark:text-white  ">Event Name :  {{$event->name}}</h5>
                    </div>

                    <div class="relative overflow-x-auto shadow-lg sm:rounded-lg  mt-3">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <tbody>
                            <tr class=" bg-gray-100 dark:bg-gray-800 ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Cost
                                </th>
                                <td class="px-6 py-4">
                                    Kshs. {{ number_format($event->cost) }}
                                </td>
                            </tr>
                            <tr class="bg-white  dark:bg-gray-900 ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Status
                                </th>
                                <td class="px-6 py-4">
                                    <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                        <input type="checkbox" class="sr-only peer" disabled
                                            {{ $event->is_active ? "checked" : " "}}
                                        >
                                        <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                                    </label>
                                </td>
                            </tr>
                            <tr class=" bg-gray-100 dark:bg-gray-800 ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Organization
                                </th>
                                <td class="px-6 py-4">
                                    {{ $event->organization->name }}
                                </td>
                            </tr>
                            <tr class=" bg-white dark:bg-gray-900 ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Venue
                                </th>
                                <td class="px-6 py-4">
                                    {{ $event->venue }}
                                </td>
                            </tr>
                            <tr class=" bg-gray-100 dark:bg-gray-800 ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Start date & Time
                                </th>
                                <td class="px-6 py-4">
                                    {{date('D, d M Y H:i:s',strtotime($event->start_date))}}
                                </td>
                            </tr>

                            <tr class=" bg-white dark:bg-gray-900 ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    End
                                </th>
                                <td class="px-6 py-4">
                                    {{date('D, d M Y H:i:s',strtotime($event->end_date))}}
                                </td>
                            </tr>

                            <tr class=" bg-gray-100 dark:bg-gray-800 ">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Description
                                </th>
                                <td class="px-6 py-4">
                                    {{$event->description}}
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="w-1/4 items-center p-2 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex flex-col items-center p-6">
                            <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">Invites</h5>
                            <h5 class="mb-2 text-3xl font-bold text-gray-900 dark:text-white">{{ isset($event->invites) ? $event->invites->count() : 0}}</h5>
                            <div class="flex mx-4 space-x-3 md:mt-6">
                                @livewire('event.show-invites', ['invites' => $event->invites])

                                @livewire('event.import-invites', ['event' => $event->id])
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700 max-h-min">
                <div class="border-b border-gray-200 dark:border-gray-600 mb-2 pb-4  mb-4">
                    <h5 class=" text-2xl font-bold text-gray-900 dark:text-white  ">Elections  </h5>
                </div>


                @livewire('event.election.create', ['event' => $event])


            </div>


        </div>
    </div>
</x-app-layout>
