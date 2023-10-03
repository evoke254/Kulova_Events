<div class="h-auto overflow-scroll">
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}

    <a class=" text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800" type="button" data-drawer-target="create-campaign-modal" data-drawer-show="create-campaign-modal" aria-controls="create-campaign-modal"
       wire:click="resetNewComponent"
       data-modal-target="createCampaignTemplateModal"
       data-modal-toggle="createCampaignTemplateModal"
    >
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                        </svg>
        Update
    </a>

    <div id="createCampaignTemplateModal"
         wire:ignore.self
         data-modal-backdrop="static"
         tabindex="-1"
         class="fixed top-0 left-0 right-0 z-50
         hidden
         w-96 p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative h-auto w-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <div class="flex items-center justify-between p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-medium text-gray-900 dark:text-white p-4">
                        Edit Template
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900
                rounded-lg text-sm w-10 h-10 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="createCampaignTemplateModal">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6 space-y-6  grid-flow-row justify-center">
                    <div class="mt-2 w-full ">

                        <ol class="flex items-center w-full p-4 space-x-6 text-sm
                                 text-center text-gray-500
                                bg-white border border-gray-200 rounded-lg shadow-sm dark:text-gray-400 sm:text-base dark:bg-gray-800 dark:border-gray-700 sm:p-4
                                sm:space-x-4">
                            <li >
                                <a href="#" class="flex items-center
                                    @if(isset($stepper[1]))
                                    text-green-600 dark:text-green-500
                                @endif">
                                                <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs
                                                border  rounded-full shrink-0
                                                @if(isset($stepper[1]))
                                                    border-blue-600
                                                    dark:border-blue-500
                                                @endif">
                                                1
                                            </span>
                                    Personal <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                                    <svg class="w-3 h-3 ml-2 sm:ml-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
                                    </svg>
                                </a>
                            </li>
                            <li class="flex items-center">
                                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                                            2
                                        </span>
                                Account <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                                <svg class="w-3 h-3 ml-2 sm:ml-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
                                </svg>
                            </li>
                            <li class="flex items-center">
                                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                                            3
                                        </span>
                                Review
                            </li>
                        </ol>
                    </div>
                </div>

                @if($stepper == 0)
                {{--Start step 1 --}}
                <div class="mt-3 p-6 space-y-6  grid-flow-row justify-center ">
                    <form action="createTemplate" wire:submit.prevent="createTemplate" class="rounded  p-4">
                        <div class="grid grid-cols-2 gap-4 items-end">
                            <div>
                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Template Name</label>
                                <input type="text" wire:model="campaign_template.name" id="campaign_template.name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                       placeholder="EG: IRS template ..." >
                                @error('campaign_template.name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>

                            <div class="mx-2 pt-2 pl-5">
                                <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" wire:model="campaign_template.is_active"
                                        {{ $campaign_template['is_active'] ? "checked" : " "}}
                                    >
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"> Activate Template </span>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-center p-6 space-x-2 rounded-b dark:border-gray-600 ">



                            <button  type="submit" wire:click="createTemplate" class="inline-flex items-center text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                Next
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
                {{--End step 1 --}}
                @elseif($stepper == 1)
                    @livewire('landing-page.create')
                @endif




                <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button
                        wire:click="resetNewComponent"
                        data-modal-hide="createCampaignTemplateModal"
                        type="button"
                        class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Close Wizard</button>
                </div>
            </div>
        </div>
    </div>
</div>
