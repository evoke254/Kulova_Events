@php use App\Models\CandidateElectivePosition;use App\Models\ElectivePosition; @endphp
<div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

    <div class="relative mx-auto  w-full h-full bg-gray-100 dark:bg-gray-700">
        <div class="relative w-full">
            <div class="relative flex justify-center rounded-lg gap-4  ">
                <!-- Event details -->
                <div
                    class="w-full col-span-3 p-2 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <div
                        class="flex gap-2 justify-between border-b border-gray-200 dark:border-gray-600 mb-2 pb-4 mt-2">
                        <div>
                            <h5 class=" text-3xl font-bold text-gray-900 dark:text-white  ">Election
                                : {{$election->name}}</h5>
                            <x-badge flat positive lg
                                     label="{{ isset($election->type) ?$election::ELECTION_TYPE[$election->type] : ' ' }}"/>
                        </div>

                        <h5 class=" text-2xl font-bold text-gray-900 dark:text-white  ">Update</h5>

                        <div class="">
                            @if(!$updating)
                                <x-button warning
                                          wire:click="isUpdating"
                                          icon="pencil"
                                          class="px-5 py-2.5 rounded-lg"
                                          label="Update - Positions | Candidates | Res... "/>
                        </div>
                        @endif
                    </div>


                    @if(!$updating)
                        <div class="bg-white dark:bg-gray-700 dark:border-gray-800">

                            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-200">
                                    <thead
                                        class=" text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200 py-2">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Position / Resolution
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Details
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($election->elective_positions as $postn)
                                        @php
                                            $totalVotes = ElectivePosition::find($postn->id)->votes()->get()->count();
                                        @endphp

                                        <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                            <th scope="row"
                                                class="px-6  py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="grid grid-cols-1 gap-2">
                                                    <div><h5 class="text-xl ">{{$postn ->position}}</h5></div>
                                                    <div class="text-sm">Votes: {{$postn ->votes}}</div>
                                                </div>

                                                {{--}}
                                                <div class="  flex justify-start items-baseline mt-5">
                                                    <x-button negative rounded sm
                                                              wire:click="cnfmDelete({{$postn->id}} ) " icon="trash"/>
                                                </div> --}}
                                            </th>
                                            <td class="px-6 py-4">
                                                <ul role="list" class="divide-y divide-gray-100">
                                                    @foreach($postn->candidates as $candt)
                                                        @php
                                                            $candidateVotes = CandidateElectivePosition::find($candt->id)->votes()->get()->count();
                                                            $rslts = round(($candidateVotes/ (($totalVotes > 0) ? $totalVotes : 1) * 100) , 1);
                                                        @endphp
                                                        <li class="flex justify-between gap-x-6 py-5">
                                                            <div class="flex min-w-0 gap-x-4 items-center">
                                                                @if($election->type == 1)
                                                                    <img
                                                                        class="h-16 w-16 flex-none rounded-full bg-gray-50"
                                                                        src="{{asset('storage/'. $candt->photo)}}"
                                                                        alt="">
                                                                    <div class="min-w-0 flex-auto">
                                                                        <p class=" text-xl leading-6 text-gray-900 dark:text-gray-300">
                                                                            {{$candt->name}}</p>
                                                                        <p class="mt-1 truncate text-md leading-6 text-gray-800 dark:text-gray-300">
                                                                            Member: {{$candt ->member_no}}</p>
                                                                    </div>
                                                                @else
                                                                    <x-avatar xl
                                                                              label="{{substr($candt->name, 0, 3)}}"/>
                                                                @endif
                                                            </div>
                                                            <div
                                                                class=" flex shrink-0 sm:flex sm:flex-col sm:items-end items-center justify-center">
                                                                <h3 class="text-2xl font-bold text-center">Votes - {{$candt->votes->count()}}</h3>
                                                                <h3 class="text-2xl font-bold text-center">{{$rslts}} %</h3>
                                                            </div>
                                                        </li>
                                                    @endforeach

                                                </ul>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    @endif


                </div>

                @if($updating)
                    <div class=" bg-white dark:bg-gray-800 dark:border-gray-700">
                        <div class=" mb-2">
                            <div class=" rounded-lg shadow-lg p-6">

                                <form wire:submit="createPositions">
                                    <div class="flex justify-end gap-2">
                                        <x-button label="Close" wire:click="isUpdating" type="button" icon="plus-circle"
                                                  class="rounded-lg my-4" negative/>
                                        <x-button label="Submit" type="submit" icon="plus-circle"
                                                  class="rounded-lg my-4" positive/>
                                    </div>
                                    {{ $this->form }}
                                    <div class="flex justify-end gap-2">

                                        <x-button label="Close" wire:click="isUpdating" type="button" icon="plus-circle"
                                                  class="rounded-lg my-4" negative/>
                                        <x-button label="Submit" type="submit" icon="plus-circle"
                                                  class="rounded-lg my-4" positive>

                                        </x-button>
                                    </div>
                                </form>

                                <x-filament-actions::modals/>
                            </div>
                        </div>
                    </div>
            </div>
            @endif
        </div>
    </div>
</div>
