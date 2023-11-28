<div>

    <div class="grid sm:grid-cols-[repeat(auto-fit,minmax(0,1fr))] md:grid-cols-2 my-4 gap-4 ">


        @foreach($event->elections as $election)
            <div class="mt-5 p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-700 dark:border-gray-700">

                <div class="w-full flex justify-between">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        {{$election->name}}
                    </h5>
                    {{--}}
                                        <button
                                            data-modal-target="editElectionModal"
                                            data-modal-toggle="editElectionModal"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                            Edit
                                            <svg class="w-3.5 h-3.5 ml-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                            </svg>
                                        </button> --}}

                    <x-button
                        data-modal-target="editElectionModal-{{$election->id}}"
                        data-modal-toggle="editElectionModal-{{$election->id}}"
                        class="rounded-lg " warning
                        label="Update" icon="document-add" />

                </div>


                <div class="w-full my-4 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    @foreach($election->elective_positions as $position)
                        <div class="flex items-center justify-between mb-4 divide-y divide-gray-200 dark:divide-gray-700">
                            <h5 class="text-2xl font-semibold leading-none text-gray-900 dark:text-white">
                                {{$loop->index +1}}.  {{$position->position}}
                            </h5>
                        </div>

                        <div class="flow-root mb-4 ">
                            <ul role="list" class=" mt-5 ">
                                @if($position->candidates->isEmpty() )
                                    <h2 class="font-bold pl-10 text-red-800">There are no candidates listed for the {{$position->position}} position!</h2>
                                @elseif($loop->index == 0)

                                @endif
                                @foreach($position->candidates as $cdt)
                                    <li class="py-3 mt-5 pl-10 sm:py-4  ">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <img class="w-20 rounded-lg" src="{{asset('storage/'.$cdt->photo)}}" alt="Simiyu">
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="gap-4 sm:grid sm:grid-cols-1">


                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                        {{$cdt->name}}
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        member no. : {{$cdt->member_no}}
                                                    </p>
                                                </div>

                                                    <div class=" mt-3">
                                                        <dl>
                                                            <dd class="flex items-center mb-3">
                                                                <div class="w-full bg-gray-200 rounded h-5 dark:bg-gray-600 me-2">
                                                                    <div class="bg-blue-600 h-5 rounded dark:bg-blue-500" style="width: 88%"></div>
                                                                </div>
                                                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300">8.8</span>
                                                            </dd>
                                                        </dl>
                                                    </div>

                                            </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>

                @livewire('event.election.edit', ['event' => $event, 'election_detail' => $election])

            </div>
        @endforeach

    </div>


</div>
