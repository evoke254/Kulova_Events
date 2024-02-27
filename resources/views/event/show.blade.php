<x-app-layout>


    <div class="relative  mt-2 mx-auto  w-full p-4 h-full bg-gray-100 dark:bg-gray-700">
        <div class="relative w-full">
            <div class="gap-4">
                <div class=" flex justify-between border-b border-gray-200 dark:border-gray-600 mb-2 pb-4 ">
                    <h5 class=" text-3xl font-bold text-gray-900 dark:text-white  ">Event :  {{$event->name}}</h5>
                    <div>

                        <x-button label="Edit" icon="plus-circle" class="rounded-lg" warning  href="{{route('events.edit', ['event' => $event->id])}}"   />

                    </div>
                </div>


                <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                        <dt>
                            <div class="absolute rounded-md bg-indigo-500 p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            <p class="ml-16 truncate text-sm font-medium text-gray-500">Total Invitees</p>
                        </dt>
                        <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                            <p class="text-2xl font-semibold text-gray-900">
                                {{ $event->invites->count() }}</p>

                        </dd>
                    </div>

                    <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                        <dt>
                            <div class="absolute rounded-md bg-indigo-500 p-3">
                                <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 9v.906a2.25 2.25 0 01-1.183 1.981l-6.478 3.488M2.25 9v.906a2.25 2.25 0 001.183 1.981l6.478 3.488m8.839 2.51l-4.66-2.51m0 0l-1.023-.55a2.25 2.25 0 00-2.134 0l-1.022.55m0 0l-4.661 2.51m16.5 1.615a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V8.844a2.25 2.25 0 011.183-1.98l7.5-4.04a2.25 2.25 0 012.134 0l7.5 4.04a2.25 2.25 0 011.183 1.98V19.5z" />
                                </svg>
                            </div>
                            <p class="ml-16 truncate text-sm font-medium text-gray-500">No. Elections</p>
                        </dt>
                        <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                            <p class="text-2xl font-semibold text-gray-900">{{$event->elections->count()}}</p>

                        </dd>
                    </div>

                </dl>

            </div>


            <div class=" grid grid-cols-1 md:grid-cols-2 mt-5 gap-4 ">
                <div class=" overflow-x-auto rounded-2xl border border-gray-400 ">
                    <table class="w-full text-left text-gray-700 rounded-lg dark:text-gray-300 ">
                        <tbody>
                        <tr class=" bg-gray-200 dark:bg-gray-800 items-start ">
                            <th scope="row" class="px-6 py-4 font-medium items-start text-gray-900 whitespace-nowrap dark:text-white">
                                Elections
                            </th>
                            <td class="px-6 py-4">
                                <div class="grid grid-cols-1">
                                    <div class="gap-2">
                                        @foreach($event->elections as $election)
                                            <x-button class="mt-2" icon="mail-open" sm rounded positive label="{{$election->name}}" href="{{route('election.show', $election)}}" />
                                        @endforeach
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr class=" bg-gray-300 dark:bg-gray-900 items-start ">
                            <th scope="row" class="px-6 py-4 font-medium items-start text-gray-900 whitespace-nowrap dark:text-white">
                                Status
                            </th>
                            <td class="px-6 py-4">
                                <div class="grid grid-cols-1">
                                    <div>
                                        <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                            <input type="checkbox" class="sr-only peer" disabled
                                                {{ $event->is_active ? "checked" : " "}}
                                            >
                                            <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr class=" bg-gray-200 dark:bg-gray-800 items-start ">
                            <th scope="row" class="px-6 py-4 font-medium items-start text-gray-900 whitespace-nowrap dark:text-white">
                                Organization
                            </th>
                            <td class="px-6 py-4">
                                <div class="grid grid-cols-1">
                                    <div>
                                        {{ $event->organization->name }}
                                    </div>
                                </div>
                            </td>
                        </tr>



                        <tr class=" bg-gray-300 dark:bg-gray-900 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Created At
                            </th>
                            <td class="px-6 py-4">
                                {{ date('D, d M Y H:i:s', strtotime($event->created_at)) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class=" overflow-x-auto rounded-2xl border border-gray-400 ">
                    <table class="w-full shadow-lg text-left text-gray-500 rounded-lg dark:text-gray-400 ">
                        <tbody>
                        <tr class=" bg-gray-100 dark:bg-gray-900 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Start Date
                            </th>
                            <td class="px-6 py-4">
                                {{date('D, d M Y H:i:s',strtotime($event->start_date))}}
                            </td>
                        </tr>
                        <tr class=" bg-gray-100 dark:bg-gray-800 items-start ">
                            <th scope="row" class="px-6 py-4 font-medium items-start text-gray-900 whitespace-nowrap dark:text-white">
                                End Date
                            </th>
                            <td class="px-6 py-4">
                                <div class="grid grid-cols-1">
                                    <div>
                                        {{date('D, d M Y H:i:s',strtotime($event->end_date))}}
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class=" bg-gray-100 dark:bg-gray-900 ">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Venue
                            </th>
                            <td class="px-6 py-4">
                                {{ $event->venue }}
                            </td>
                        </tr>
                        <tr class=" bg-gray-100 dark:bg-gray-800 items-start ">
                            <th scope="row" class="px-6 py-4 font-medium items-start text-gray-900 whitespace-nowrap dark:text-white">
                                Cost
                            </th>
                            <td class="px-6 py-4">
                                <div class="grid grid-cols-1">
                                    <div>
                                        Kshs. {{ number_format($event->cost) }}

                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr class=" bg-gray-200 dark:bg-gray-800 items-start ">
                            <th scope="row" class="px-6 py-4 font-medium items-start text-gray-900 whitespace-nowrap dark:text-white">
                                Merchandise
                            </th>
                            <td class="px-6 py-4">
                                <div class="grid grid-cols-2 gap-2 ">
                                    <div>
                                        {{ $event->merchandise()->get()->count() }}
                                    </div>
                                    <div>
                                        {{--}}
                                        <x-button class="rounded-lg" primary label="View | Add Merchandise"
                                                  data-modal-target="eventMerchandisesModal"
                                                  data-modal-toggle="eventMerchandisesModal" />--}}
                                    </div>
                                </div>
                            </td>
                        </tr>


                        </tbody>
                    </table>
                </div>
            </div>


            <div class="mt-5  rounded-lg bg-gray-300 dark:bg-gray-900" >
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center text-gray-700 dark:text-gray-200" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                        <li class="me-2">
                            <button id="users_members-tab" data-tabs-target="#users_members" type="button" role="tab" aria-controls="users_members" aria-selected="true"
                                    class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Attendees
                            </button>
                        </li>
                        <li class="me-2">
                            <button id="event_elctns-tab" data-tabs-target="#event_elctns" type="button" role="tab" aria-controls="event_elctns" aria-selected="false"
                                    class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Event Elections
                            </button>
                        </li>

                        <li class="me-2">
                            <button id="event_mcds-tab" data-tabs-target="#event_mcds" type="button" role="tab" aria-controls="event_mcds" aria-selected="false"
                                    class="inline-flex items-center justify-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 group">
                                Merchandise
                            </button>
                        </li>

                        <li class="my-2 flex items-center self-end">
                        </li>
                    </ul>
                </div>

            </div>

            <div class=" grid grid-cols-1 mt-5 gap-4 justify-end " id="fullWidthTabContent">

                <div class="" id="users_members" role="tabpanel" aria-labelledby="users_members-tab">
                    <div class="flex justify-end my-2">
                        @livewire('event.import-invites', ['event' => $event])
                    </div>

                    @livewire('event.show-invites', ['event' => $event])
                    {{--}}                    @livewire('event.import-invites', ['event' => $event->id]) --}}
                </div>
                <div class="" id="event_elctns" role="tabpanel" aria-labelledby="event_elctns-tab">
                    @livewire('event.event-elections', ['event' => $event])
                </div>

                <div class="" id="event_mcds" role="tabpanel" aria-labelledby="event_mcds-tab">
                    @livewire('event-merchandises', ['event' => $event])
                </div>


            </div>
        </div>

</x-app-layout>
