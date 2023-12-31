<div class="bg-white min-h-screen mt-4">

    <main class="isolate">
        <!-- Hero section -->
        <div class="relative pt-1">
            <div class="py-24 sm:py-32 sm:px-4 md:px-16 ">
                <div class="mx-auto w-full  ">
                    <div class="mx-auto text-center">
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{$election->name}}</h1>
                    </div>

                    <form >
                        <div class="mt-8 flow-root sm:mt-12 space-y-2.5">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 min-h-screen">
                                @foreach($elective_positions as $key => $pstn)
                                    <div class="justify-center">
                                        <h1 class="text-xl text-center font-semibold tracking-tight text-gray-900 my-2 "> {{$pstn->position}}</h1>
                                        <ul role="list" class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                                            @foreach($pstn?->candidates as $counter => $cdt)
                                                <li class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                                                    <div class="flex min-w-0 gap-x-4">
                                                        <img class="h-20 w-20 flex-none rounded-full bg-gray-50" src="{{asset('storage/'.$cdt->photo)}}" alt="">
                                                        <div class="min-w-0 flex-auto">
                                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                                <a href="#">
                                                                    <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                                                    Leslie Alexander
                                                                </a>
                                                            </p>
                                                            <p class="mt-1 flex text-xs leading-5 text-gray-500">
                                                                <a href="mailto:leslie.alexander@example.com" class="relative truncate hover:underline">leslie.alexander@example.com</a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="flex shrink-0 items-center gap-x-4">
                                                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                                                            <p class="text-sm leading-6 text-gray-900">Co-Founder / CEO</p>
                                                            <p class="mt-1 text-xs leading-5 text-gray-500">Last seen <time datetime="2023-01-23T13:23Z">3h ago</time></p>
                                                        </div>
                                                        <svg class="h-5 w-5 flex-none text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>

                            @foreach($elective_positions as $key => $pstn)
                                <div class=" rounded-xl bg-gray-900/5 p-2 ring-1 ring-inset ring-gray-900/10 lg:-m-4 lg:rounded-2xl lg:p-4 my-2 mb-4">
                                    <div class="my-2 pb-1 text-center ">

                                        <div class="flex justify-center gap-2 space-x-2.5 items-start">
                                            <h1 class="text-lg font-semibold tracking-tight text-gray-900 sm:text-3xl">{{$key+1}}. {{$pstn->position}}</h1>
                                            <div class="">
                                                <x-badge icon="check-circle" lg squared emerald label="{{$pstn->votes}} Vote(s)" />
                                            </div>
                                        </div>

                                        <div class="gap-2 grid grid-cols-1 md:grid-cols-2">
                                            @if($election->type == 3)
                                                @foreach($pstn?->candidates as $counter => $cdt)
                                                    <fieldset class="" wire:poll.100ms >
                                                        <div class=" my-3 ">
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
                                                                <div class="flex justify-center py-1">
                                                                    <div class="flex">
                                                                        <img class="h-40 object-center flex-none rounded-lg bg-gray-50" src="{{asset('storage/'.$cdt->photo)}}" alt="">
                                                                    </div>
                                                                    <div class="flex justify-centers items-center ">
                                                                    <span class="flex flex-col text-xl justify-center">
                                                                      <span id="server-size-0-label" class="font-semibold  text-xl text-gray-900 my-4">{{ $cdt->name  }}</span>
                                                                      <span id="server-size-0-description-0" class="text-gray-800">

                                                                        <span class="hidden sm:mx-1 sm:inline" aria-hidden="true">&middot;</span>
                                                                      </span>
                                                                    </span>
                                                                    </div>
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
                                            @else
                                                @foreach($pstn?->candidates as $counter => $cdt)

                                                    <fieldset class="" wire:poll.100ms >
                                                        <div class=" my-3 ">
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
                                                                <div class="flex justify-start gap-x-6 py-1">
                                                                    <div class="flex min-w-0 gap-x-4">
                                                                        <img class="h-40 object-center flex-none rounded-lg bg-gray-50" src="{{asset('storage/'.$cdt->photo)}}" alt="">
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
                                            @endif
                                        </div>
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
