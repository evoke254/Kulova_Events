<div class="bg-white min-h-screen">

    <main class="isolate">
        <!-- Hero section -->
        <div class="relative pt-7">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80" aria-hidden="true">
                <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
            <div class="py-24 sm:py-32">
                <div class="mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-6xl">{{$election->name}}</h1>
                        <p class="mt-6 text-xl leading-8 text-gray-800 font-bold">You are voting... </p>
                    </div>

                    <form >
                        <div class="mt-16 flow-root sm:mt-24 space-y-2.5">
                            @foreach($elective_positions as $key => $pstn)
                                <div class=" rounded-xl bg-gray-900/5 p-2 ring-1 ring-inset ring-gray-900/10 lg:-m-4 lg:rounded-2xl lg:p-4 my-2 mb-4">
                                    <div class="my-2 pb-4">
                                        <h2 class="mt-6 text-xl leading-8 text-gray-800 font-bold">{{$key+1}}. {{$pstn->position}} </h2>
                                    </div>
                                    @foreach($pstn?->candidates as $counter => $cdt)
                                        <fieldset class="gap-2" wire:poll.100ms >
                                            <div class="space-y-4 my-3 ">
                                                <!-- Active: "border-indigo-600 ring-2 ring-indigo-600", Not Active: "border-gray-300" -->
                                                <label class="relative block cursor-pointer rounded-lg border bg-white px-6 py-4 shadow-sm focus:outline-none sm:flex sm:justify-between
                                            @if( isset($ballot_papers[$pstn->id]) && $ballot_papers[$pstn->id]['candidate'] == $cdt->id )
                                            border-indigo-600 ring-2 ring-indigo-600
                                            @else
                                            border-gray-300
                                            @endif
                                            ">
                                                    <input wire:model="ballot_papers.{{$pstn->id}}.candidate" type="radio"
                                                           value="{{$cdt->id}}"
                                                           class="sr-only" aria-labelledby="server-size-0-label" aria-describedby="server-size-0-description-0 server-size-0-description-1">
                                                    <div class="flex justify-start gap-x-6 py-5">
                                                        <div class="flex min-w-0 gap-x-4">
                                                            <img class="h-36 w-36 object-center flex-none rounded-lg bg-gray-50" src="{{asset('storage/'.$cdt->photo)}}" alt="">
                                                        </div>
                                                        <span class="flex items-center">
                                                        <span class="flex flex-col text-sm">
                                                          <span id="server-size-0-label" class="font-semibold  text-xl text-gray-900 my-4">{{$cdt->name}}</span>
                                                          <span id="server-size-0-description-0" class="text-gray-800">
                                                      <span id="server-size-0-label" class="font-medium text-gray-900">Member No. {{$cdt->member_no}}</span>
                                                            <span class="hidden sm:mx-1 sm:inline" aria-hidden="true">&middot;</span>
                                                          </span>
                                                        </span>
                                                      </span>
                                                    </div>
                                                    <div class=" flex items-center">
                                                        @if( isset($ballot_papers[$pstn->id]) && $ballot_papers[$pstn->id]['candidate'] == $cdt->id )
                                                            <svg class="h-9 w-9 text-indigo-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                                            </svg>
                                                        @endif

                                                    </div>
                                                    <span class="pointer-events-none absolute -inset-px rounded-lg
                                                    @if( isset($ballot_papers[$pstn->id]) && $ballot_papers[$pstn->id]['candidate'] == $cdt->id )
                                                    border border-indigo-600
                                                    @else
                                                     border-2 border-transparent
                                                    @endif
                                                " aria-hidden="true"></span>
                                                </label>
                                            </div>
                                        </fieldset>

                                    @endforeach
                                </div>
                        @endforeach
                        <div class="my-2 mt-5 flex justify-center">
                                                    <x-button green lg label="Cast Ballot" wire:click="submit" class="rounded-lg shadow-lg" />
                                                </div>
                    </form>
                </div>
            </div>
        </div>



</main>

</div>
