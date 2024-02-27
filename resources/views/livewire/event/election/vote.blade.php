@php use App\Models\CandidateElectivePosition;use App\Models\ElectivePosition; @endphp
<div class="bg-white min-h-screen mt-4">

    <main class="isolate">
        <!-- Hero section -->
        <div class="relative pt-1">
            <div class="py-24 sm:py-32 sm:px-4 md:px-16 ">
                <div class="mx-auto w-full  ">
                    <div class="mx-auto text-center ">

                        <div class=" w-full flex justify-center ">
                            <div class="sm:min-w-0 md:w-1/2">
                                <div class="px-2 sm:px-0">
                                    <h1 class=" text-2xl font-semibold leading-7 text-gray-900">Election
                                        Information</h1>
                                    <p class="mt-1 text-sm leading-6 text-gray-500">Voter details and Election info.</p>
                                </div>
                                <div class="mt-3 border-t border-gray-100">
                                    <dl class="divide-y divide-gray-100">
                                        <div class="px-1 py-6 sm:grid sm:grid-cols-3 sm:gap-2 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Your name</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$voter->name}}</dd>
                                        </div>
                                        <div class="px-1 py-6 sm:grid sm:grid-cols-3 sm:gap-2 sm:px-0">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Election</dt>
                                            <div class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                {{$election->name}}
                                            </div>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                        </div>

                        <form>
                            <div class="mt-8 grid">
                                <div class=" flex justify-center">
                                    <div class="grid grid-cols-1  gap-4 w-1/2 self-center">
                                        @foreach($elective_positions as $key => $pstn)
                                            <div class="justify-center">
                                                @php
                                                    if ($election->type == 1){
                                                        $prev_votes = $voter->castVoteInPstn($pstn->id);
                                                        }else{
                                                        $prev_votes = $voter->castVoteInPstn($pstn->id);
                                                        }
                                                @endphp
                                                @if($prev_votes)
                                                    <h1 class="text-xl ml-2 font-semibold tracking-tight text-gray-900 my-2 "> {{$pstn->position}}</h1>
                                                    <p class="ml-2 mb-1">You can vote {{$pstn->votes}} times</p>
                                                    <ul role="list"  class="divide-y divide-gray-100 overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
                                                        @foreach($pstn->candidates as $counter => $cdt)
                                                            <li class="" wire:poll.100ms
                                                                wire:click="castVote({{$pstn->id}}, {{$cdt->id}} )">
                                                                <label
                                                                    class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6 hover:cursor-pointer ">
                                                                    <input
                                                                        wire:model="ballot_papers.{{$pstn->id}}.candidate.{{$cdt->id}}"
                                                                        type="checkbox" value="{{$cdt->id}}" class="sr-only">
                                                                    <div class="flex min-w-0 gap-x-4">
                                                                        @if($election->type == 1)
                                                                            <img class="h-20 w-20 flex-none rounded-full bg-gray-50"  src="{{asset('storage/'.$cdt->photo)}}" alt="">
                                                                        @elseif($cdt->name == 'Yes')
                                                                            <x-button.circle positive xl label="{{$cdt->name}}" />
                                                                        @elseif($cdt->name == "No")
                                                                            <x-button.circle xl  negative label="{{$cdt->name}}"  />
                                                                        @endif
                                                                        <div class="min-w-0 flex-auto">
                                                                            <p class="text-sm font-semibold leading-6 text-gray-900">
                                                                                <span   class="absolute inset-x-0 -top-px bottom-0"></span>
                                                                                {{ $cdt->name  }}
                                                                            </p>
                                                                            @if($cdt->member_no >=0)
                                                                                <p class="mt-1 flex text-xs leading-5 text-gray-700">
                                                                                    Member No. {{$cdt->member_no}}
                                                                                </p>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex shrink-0 items-center gap-x-4">
                                                                        @if( isset($ballot_papers[$pstn->id]['candidate'][$cdt->id]) && $ballot_papers[$pstn->id]['candidate'][$cdt->id] == $cdt->id )
                                                                            <div
                                                                                class="hidden sm:flex sm:flex-col sm:items-end">
                                                                                <p class="text-sm leading-6 text-gray-900">
                                                                                    Voted</p>

                                                                            </div>


                                                                            <svg class="h-9 w-9 text-indigo-600"
                                                                                 viewBox="0 0 20 20" fill="currentColor"
                                                                                 aria-hidden="true">
                                                                                <path fill-rule="evenodd"
                                                                                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                                                                      clip-rule="evenodd"/>
                                                                            </svg>
                                                                        @endif
                                                                    </div>
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-red-500">You have already cast your vote</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @if($prev_votes)
                                    <div class="my-2 mt-5 flex justify-center">
                                        <x-button green lg label="Cast Ballot" wire:click="submit"
                                                  class="rounded-lg shadow-lg"/>
                                    </div>
                                @endif
                            </div>
                        </form>


                        <div class="mt-3 border-t border-gray-100">
                            <dl class="divide-y divide-gray-100">


                                <h1 class="text-xl ml-2 font-semibold tracking-tight text-gray-900 my-2 mt-3">
                                    Provisional Results</h1>
                                @foreach($elective_positions as $postn)
                                    <div class="px-1 py-6 sm:grid sm:grid-cols-3 sm:gap-2 sm:px-0">
                                        <dt class="text-sm font-medium leading-6 text-gray-900">{{$postn->position}} </dt>
                                        <div
                                            class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 w-3/4 flex justify-end">
                                            <ul role="list" class="divide-y divide-gray-100">
                                                @php
                                                    $totalVotes = ElectivePosition::find($postn->id)->votes()->get()->count();
                                                @endphp

                                                @foreach($postn->candidates as $candt )
                                                    @php
                                                        $prev_votes = $this->voter->castVotes($postn->id, $candt->id);

                                                        $candidateVotes = CandidateElectivePosition::find($candt->id)->votes()->get()->count();
                                                        $rslts = round(($candidateVotes/ (($totalVotes > 0) ? $totalVotes : 1) * 100) , 1);
                                                    @endphp

                                                    <li class="grid sm:grid-cols-1 md:grid-cols-2 justify-between gap-x-6 py-2">
                                                        <div class="flex min-w-0 gap-x-4">

                                                            @if($election->type == 1)
                                                                <img
                                                                    class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                                                    src="{{asset('storage/'.$candt->photo)}}"
                                                                    alt="">
                                                            @elseif($candt->name == 'Yes')
                                                                <x-button.circle positive xl label="{{$candt->name}}" />
                                                            @elseif($candt->name == "No")
                                                                <x-button.circle xl  negative label="{{$candt->name}}"  />
                                                            @endif
                                                            <div class="min-w-0 flex-auto">
                                                                <p class="text-sm font-semibold leading-6 text-gray-900"> {{ $candt->name  }}</p>
                                                                @if($candt->member_no >= 0)
                                                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">    Member No. {{ $candt->member_no  }}</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div  class=" self-end">
                                                            <p class="text-sm leading-6 text-gray-900">
                                                                Votes : {{$candidateVotes}} </p>
                                                            <p class="mt-1 text-sm leading-6 text-gray-900">
                                                                {{$rslts}} %

                                                            </p>
                                                        </div>
                                                    </li>

                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach
                            </dl>
                        </div>
                    </div>
                </div>
            </div>


    </main>

</div>
