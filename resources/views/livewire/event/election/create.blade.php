<div class="mt-2">


    <x-button
        onclick="$openModal('createElectionModal')"
        class="rounded-lg " primary
        label="Create Election" icon="plus" />


    <x-modal.card
        max-width='6xl'
        blur
        static
        title="Election Wizard"
        wire:model.defer="createElectionModal"
        class="w-full">
        <div class="relative w-full max-h-full ">
            <div class="relative ">
                <div class="">
                    <x-errors class="mt-2 text-sm text-red-600 dark:text-red-500" />
                </div>
                <div class="p-2 space-y-6">
                    @if($steps ==0)
                        <div class=" rounded-xl bg-gray-900/5 p-2 ring-1 ring-inset ring-gray-900/10 lg:-m-4 lg:rounded-2xl lg:p-4 my-2 mb-4">
                            <div class="my-2 pb-4">
                                <h2 class="mt-6 text-xl leading-8 text-gray-800 font-bold dark:text-gray-100 text-center">Election Type </h2>
                            </div>
                            @foreach($electionTypes as $typekey => $elctnType)
                                <fieldset class="gap-2" >
                                    <div class="space-y-4 my-3 " wire:click="setElectionType({{$typekey}})">
                                        <!-- Active: "border-indigo-600 ring-2 ring-indigo-600", Not Active: "border-gray-300" -->
                                        <label class="relative block cursor-pointer rounded-lg border px-6 py-4 shadow-sm focus:outline-none sm:flex sm:justify-between
                                            @if( !empty($electionType) && $typekey == $electionType )
                                            border-indigo-600 ring-2 ring-indigo-600
                                            @else
                                            border-gray-300 dark:border-gray-100
                                            @endif
                                            ">
                                            <input wire:model="electionType" type="radio"
                                                   value="{{$typekey}}"
                                                   class="sr-only" aria-labelledby="server-size-0-label" aria-describedby="server-size-0-description-0 server-size-0-description-1">
                                            <div class="flex justify-start gap-x-6 py-5">
                                                <div class="flex min-w-0 gap-x-4">
                                                    <h4 class="text-xl text-slate-800 dark:text-white ">{{$elctnType}}</h4>
                                                </div>
                                            </div>
                                            <div class=" flex items-center">
                                                @if( !empty($electionType) && $typekey == $electionType )
                                                    <svg class="h-9 w-9 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                            </div>
                                            <span class="pointer-events-none absolute -inset-px rounded-lg
                                                    @if( !empty($electionType) && $typekey == $electionType )
                                                    border border-indigo-600
                                                    @else
                                                     border-2 border-transparent
                                                    @endif
                                                " aria-hidden="true"></span>
                                        </label>
                                    </div>
                                </fieldset>

                            @endforeach

                            <div class="flex justify-end space-x-2 space-y-2.5 mt-5">

                                <button type="button" wire:click="stepTwo" class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-green-700 sm:w-fit hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    Next >>
                                </button>
                            </div>
                        </div>

                    @elseif($steps == 1)

                        <section class="">
                            <div class="py-8 lg:py-16 px-4 mx-auto p-4">
                                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                                    Create {{$electionTypes[$electionType]}} Election
                                </h2>
                                <form  wire:submit.prevent="createElection" class="space-y-8">
                                    @if(empty($event))
                                        <div>
                                            <label for="Event" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Event Name *</label>
                                            <select type="text" wire:model="election.event_id" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                    shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                    dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                                            >
                                                <option>Select Event</option>
                                                @foreach(\App\Models\Event::where('user_id', \Illuminate\Support\Facades\Auth::id())->get() as $event )
                                                    <option value="{{$event->id}}">{{$event->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('election.event_id')
                                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                                {{$message}}</p>
                                            @enderror
                                        </div>
                                    @endif
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
                                    <div class="flex justify-end gap-2">
                                        <x-button  wire:click="prev" secondary label="Previous" />
                                        <x-button positive label="Submit"  wire:click="createElection" />

                                    </div>
                                </form>
                            </div>
                        </section>

                    @elseif($steps == 2 && ($electionType == 1 || $electionType == 2 ))

                        <section class="">
                            <div class="py-8 lg:py-16 px-4 mx-auto p-4">
                                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                                    Add Elective Positions
                                </h2>
                                <form   class="space-y-8" wire:submit.prevent="addElectivePositions">


                                    @if(!$positions->isEmpty())
                                        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Elective Positions : </h2>
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
                                                            Votes : {{$position->votes}}
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

                                    <div class="flex justify-center gap-2">
                                        <div class="mb-0 w-3/4">
                                            <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Position Title* </label>
                                            <input type="text"
                                                   wire:model="position"
                                                   class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                                            shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                                            dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                                                   placeholder="example: Chairman" >

                                        </div>
                                        @if( $electionType == 2)
                                            <div class="mb-0 flex-grow">
                                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">No. Votes </label>
                                                <input type="number"
                                                       min="1"
                                                       max="30"
                                                       wire:model="positionVotes"
                                                       class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                                            shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                                            dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                                                       placeholder="example: Chairman" >

                                            </div>
                                        @endif
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
                                        <button type="button" wire:click="prev"  class="py-2 px-5 text-sm font-medium text-center text-white rounded-lg bg-gray-700 sm:w-fit hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                            Prev
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


                    @elseif($steps == 2 && ($electionType == 3) )

                        <section class="">
                            <div class="py-8 lg:py-16 px-4 mx-auto p-4">
                                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-center text-gray-900 dark:text-white">
                                    Add Resolutions
                                </h2>
                                <form   class="space-y-8" wire:submit.prevent="addElectivePositions">


                                    @if(!$positions->isEmpty())
                                        <h2 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">Resolutions</h2>
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
                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"> Resolution *</label>
                                        <textarea
                                            wire:model="position"
                                            class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300
                                                            shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                                                            dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light"
                                            placeholder="example: Resolution that the Company shall implement a comprehensive ...."  >
                                        </textarea>
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
                                        <button type="button" wire:click="prev"  class="py-2 px-5 text-sm font-medium text-center text-white rounded-lg bg-gray-700 sm:w-fit hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                            << Prev
                                        </button>
                                        @if(!$positions->isEmpty())
                                            <button type="button" wire:click="submitResolutions" x-on:click="close"
                                                    class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-green-700 sm:w-fit
                                                    hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600
                                                    dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                Submit
                                            </button>
                                        @endif
                                    </div>

                                </form>
                            </div>
                        </section>


                    @elseif($steps == 3 && ($electionTypes[$electionType] == 1 || $electionTypes[$electionType] == 2 ))
                        <div class="">
                            <div class="py-2 lg:py-4 px-4 mx-auto p-4 space-x-3">
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
                                    <button type="button" wire:click="prev"  class="py-2 px-5 text-sm font-medium text-center text-white rounded-lg bg-gray-700 sm:w-fit hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                                        Prev
                                    </button>


                                    @if($this->complete)
                                        <button x-on:click="close" href="{{route('events.show', ['event' =>$event->id])}}"
                                                class="py-3 px-5 text-sm font-medium text-center text-white rounded-lg bg-green-700 sm:w-fit
                                                    hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 dark:bg-green-600
                                                    dark:hover:bg-green-700 dark:focus:ring-green-800">
                                            Submit
                                        </button>
                                    @endif
                                </div>



                            </div>
                        </div>

                    @elseif($steps == 'Complete')
                        <div id="alert-additional-content-3" class="p-4 mb-4 text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 dark:border-green-800" role="alert">
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <span class="sr-only">Info</span>
                                <h3 class="text-lg font-medium">Success </h3>
                            </div>
                            <div class="mt-2 mb-4 text-sm">
                            You have created an election. Proceed to update and add Resolutions, Elective Positions...
                            </div>
                            <div class="flex">
                                <button type="button" Wire:click="Complete"  x-on:click="close" class="text-white bg-green-800 hover:bg-green-900 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 me-2 text-center inline-flex items-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    <svg class="me-2 h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                                        <path d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z"/>
                                    </svg>
                                    Update Election
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-modal.card>

</div>
