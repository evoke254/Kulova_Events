<div class="mt-2">


    <x-button
        onclick="$openModal('createElectionModal')"
        class="rounded-lg " lime
        label="Create" icon="document-add" />


    <x-modal.card
        max-width='6xl'
        blur
        static
        title="Election Wizard"
        wire:model.defer="createElectionModal"
        class="w-full">
        <div class="relative w-full max-h-full ">
            <div class="relative ">
                <div class="p-6 space-y-6">
                    @if($steps ==1)
                        <section class="">
                            <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
                                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                                    Create An Election
                                </h2>
                                <form  wire:submit.prevent="createElection" class="space-y-8">
                                    <div>
                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Election Name *</label>
                                        <input type="text" wire:model="election.name" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                    shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                    dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                                               placeholder="example: Annual General Meeting (AGM) Elections" >
                                        @error('election.name')
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
                                                label="Election Date"
                                                placeholder="Election Date"
                                                wire:model.defer="election_date"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                            />
                                        </div>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-400">Description / Info (Optional)</label>
                                        <textarea wire:model="election.details" rows="6"
                                                  class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300
                                              focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                              dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Describe the election ..."></textarea>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="button" wire:click="createElection" class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-green-700 sm:w-fit hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                            Next >> Add Elective Positions
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </section>


                    @elseif($steps == 2)

                        <section class="">
                            <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
                                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                                    Add Elective Positions
                                </h2>
                                <form   class="space-y-8" wire:submit.prevent="addElectivePositions">


                                    @if(!$positions->isEmpty())
                                        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Positions</h2>
                                    @endif
                                    @foreach($positions as $position)

                                        <ul class="max-w-md w-3/4 divide-y divide-gray-200 dark:divide-gray-700">
                                            <li class="pb-3 sm:pb-4 @if($loop->index > 1)border-b  border-gray-400 @endif">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                            {{$loop->index + 1}}
                                                        </p>
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-lg text-lg font-bold text-gray-900 truncate dark:text-white">
                                                            {{$position->position}}
                                                        </p>
                                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        </p>
                                                    </div>
                                                    <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                        <button type="button"  wire:click="rmvElectivePositions({{$position->id}})"  class="inline-flex items-center text-white bg-red-700  hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-2.5 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                 class="w-6 h-6 mr-2">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            remove
                                                        </button>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    @endforeach

                                    <div class="mb-0">
                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Position Title *</label>
                                        <input type="text"
                                               wire:model="position"
                                               class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                                            shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                                            dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                                               placeholder="example: Chairman" >
                                        @error('position')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                            <span class="font-medium">Oops!</span>
                                            {{$message}}</p>
                                        @enderror
                                    </div>
                                    <div class="flex justify-end mt-1">
                                        <button type="button"
                                                wire:click="addElectivePositions"
                                                class="inline-flex items-center text-white bg-blue-700
                                                                            hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 mr-2 mb-2
                                                                            dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                 class="w-6 h-6 mr-2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Add
                                        </button>
                                    </div>
                                    <div class="flex justify-end space-x-2 space-y-2.5">
                                        <button type="button" wire:click="prev"  class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-gray-700 sm:w-fit hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                            << prev  - Election
                                        </button>
                                        @if(!$positions->isEmpty())
                                            <button type="button" wire:click="next"
                                                    class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-green-700 sm:w-fit
                                                    hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600
                                                    dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                Next >> Add Candidates
                                            </button>
                                        @endif
                                    </div>

                                </form>
                            </div>
                        </section>


                    @elseif($steps == 3)
                        <div class="">
                            <div class="py-2 lg:py-4 px-4 mx-auto max-w-screen-md space-x-3">
                                <div class="pt-6">
                                    <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                                        Add Candidates
                                    </h2>
                                </div>

                                <div class="divide-x-4 mb-4">

                                    @foreach($positions as $elctV_pstn_id => $position)
                                        <div class="w-full max-w-md my-4 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                                            <div class="flex items-center justify-between mb-4">
                                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">
                                                    {{$position->position}}
                                                </h5>
                                            </div>
                                            <div class="flow-root mb-4">
                                                <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700 mt-5">
                                                    @if($position->candidates->isEmpty() )
                                                        <h2 class="font-bold text-red-800">There are no candidates listed for this {{$position->position}} position!</h2>
                                                    @endif
                                                    @foreach($position->candidates as $cdt)
                                                        <li class="py-3 mt-5 sm:py-4
                                                        border-b border-gray-200
                                                        dark:border-gray-700
                                                        ">
                                                            <div class="flex items-center space-x-4">
                                                                <div class="flex-shrink-0">
                                                                    <img class="w-20 rounded-lg" src="{{asset('storage/'.$cdt->photo)}}" alt="Simiyu">
                                                                </div>
                                                                <div class="flex-1 min-w-0">
                                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                                        {{$cdt->name}}
                                                                    </p>
                                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                                        member no. : {{$cdt->member_no}}
                                                                    </p>
                                                                </div>
                                                                <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                                                    <button
                                                                        wire:click="rmvCandidate({{$cdt->id}})"
                                                                        type="button"  class="inline-flex items-center text-white bg-red-700  hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm
                                                                px-2 py-1 mr-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                             class="w-6 h-6 mr-2">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                        </svg>
                                                                        remove
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>


                                <div class="w-full">
                                    <form class="grid grid-cols-2 mt-5 gap-2 " wire:submit.prevent="addCandidate">
                                        <div class="mb-6">
                                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Select The Position*</label>
                                            <select id="" wire:model="candidate.elective_position_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option selected>Choose Elective Position</option>
                                                @foreach($positions as $pstn)
                                                    <option value="{{$pstn->id}}">{{$pstn->position}}</option>
                                                @endforeach
                                            </select>

                                            @error("candidate.elective_position_id")
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{$message}}
                                            </p>
                                            @enderror
                                        </div>

                                        <div class="mb-6">
                                            <label for="" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name*</label>
                                            <input type="text" wire:model="candidate.name"
                                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block
                                                       w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                                                       dark:focus:border-blue-500" placeholder="John Doe" >
                                            @error("candidate.name")
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{$message}}
                                            </p>
                                            @enderror
                                        </div>

                                        <div class="mb-6">
                                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Member no *</label>
                                            <input type="text" wire:model="candidate.member_no" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                            @error("candidate.member_no")
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{$message}}
                                            </p>
                                            @enderror
                                        </div>

                                        <div class=" h-5 mb-6">
                                            <label class="block mb-2 mr-2 text-sm font-medium text-gray-900 dark:text-white" for="multiple_files">Photo</label>
                                            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                                   wire:model="candidate.photo"
                                                   type="file">
                                            @error("candidate.photo")
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500">
                                                {{$message}}
                                            </p>
                                            @enderror
                                        </div>

                                        <button type="submit"
                                                wire:click="addCandidate"
                                                class="text-white  bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg
                                                    text-sm w-1/2 sm:w-auto px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Candidate</button>
                                    </form>
                                </div>


                                <div class="flex justify-end space-x-2 space-y-2.5 mt-5">
                                    <button type="button" wire:click="prev"  class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-gray-700 sm:w-fit hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                        << prev  - Elective Positions
                                    </button>


                                    @if($this->complete)
                                        <a href="{{route('events.show', ['event' =>$event->id])}}"
                                           class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-green-700 sm:w-fit
                                                    hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600
                                                    dark:hover:bg-green-700 dark:focus:ring-green-800">
                                            Finish
                                        </a>
                                    @endif
                                </div>



                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-modal.card>

</div>
