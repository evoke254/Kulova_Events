<div >

    <div class="relative  mt-2 mx-auto  w-full p-4 h-full ">
        <div class="relative w-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white"> {{isset($campaign_template['id']) ? 'Update' : 'Create'}} Template</h3>
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
                                        Campaign Template Name
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
                                    Landing Page <span class="hidden sm:inline-flex sm:ml-2">Info</span>
                                    <svg class="w-3 h-3 ml-2 sm:ml-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m7 9 4-4-4-4M1 9l4-4-4-4"/>
                                    </svg>
                                </li>
                                <li class="flex items-center">
                                        <span class="flex items-center justify-center w-5 h-5 mr-2 text-xs border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
                                            3
                                        </span>
                                    Email Template
                                </li>
                            </ol>
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




                                    <div class="flex items-center justify-end gap-4">
                                        <button type="submit" wire:click="createTemplate" class="gap-4 inline-flex text-center  text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                            Next - (Build landing Page )
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" ml-2 w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </button>
                                    </div>


                                </form>
                            </div>
                            {{--End step 1

                            --}}
                        @elseif($stepper == 1)

                            <div class="relative  mt-2 mx-auto  w-full p-4 h-full ">
                                <div class="relative w-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                                        <div class="px-6 py-6 lg:px-8">
                                            <form class="space-y-6" action="completelandingPage( {{$landingPage['id']}} )"
                                                  wire:submit.prevent="completelandingPage( {{$landingPage['id']}} )">
                                                <div class="grid grid-cols-2 gap-4 items-end">
                                                    <div>
                                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Page Title (Meta Tag)</label>
                                                        <input type="text" wire:model="landingPage.title"
                                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                               placeholder="eg: Home - Official IRS Page" >
                                                        @error('landingPage.title')
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                                            {{$message}}</p>
                                                        @enderror
                                                    </div>

                                                </div>
                                                <div class="grid grid-cols-1 gap-2">
                                                    <div wire:ignore
                                                         id="gjs"
                                                         x-init="

                                                                 const escapeName = (name) => `${name}`.trim().replace(/([^a-z0-9\w-:/]+)/gi, '-');

                                                                 const projectEdpUrlLoad = `{{route('grapejs.get', ['landing_page' => $landingPage['id']]) }}`;
                                                                 const projectEdpUrlStore = `{{route('grapejs.store', ['landing_page' => $landingPage['id']]) }}`;

                                                                    const editor = grapesjs.init({
                                                                        container: '#gjs',
                                                                        showOffsets: true,
                                                                        fromElement: true,
                                                                        noticeOnUnload: true,
                                                                        selectorManager: { escapeName },
                                                                         storageManager: {
                                                                                type: 'remote',
                                                                                stepsBeforeSave: 1,
                                                                                options: {
                                                                                  remote: {
                                                                                    urlLoad: projectEdpUrlLoad,
                                                                                    urlStore: projectEdpUrlStore,
                                                                                    // The `remote` storage uses the POST method when stores data but
                                                                                    // the json-server API requires PATCH.
                                                                                    fetchOptions: opts => (opts.method === 'POST' ?  { method: 'PATCH' } : {}),
                                                                                    // As the API stores projects in this format `{id: 1, data: projectData }`,
                                                                                    // we have to properly update the body before the store and extract the
                                                                                    // project data from the response result.
                                                                                    onStore: data => ({ id: 1, data }),
                                                                                    onLoad: result => result.data,
                                                                                  }
                                                                                }
                                                                              },
                                                                        plugins: [
                                                                            'grapesjs-ga',
                                                                            'grapesjs-component-twitch',
                                                                            'grapesjs-plugin-forms',
                                                                            'grapesjs-tailwind'
                                                                        ],
                                                                        pluginsOpts: {
                                                                            'grapesjs-ga': {
                                                                               //
                                                                            },
                                                                            'grapesjs-component-twitch': {
                                                                            //
                                                                            }
                                                                        }
                                                                    });

                                                                            editor.Panels.addButton('options', {
                                                                                    id: 'update-theme',
                                                                                    className: 'fa fa-adjust',
                                                                                    command: 'open-update-theme',
                                                                                    attributes: {
                                                                                        title: 'Update Theme',
                                                                                        'data-tooltip-pos': 'bottom'
                                                                                    }
                                                                                });


                                                         "
                                                    >

                                                        @error('body')
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                                            {{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="flex items-center justify-end gap-4">


                                                    <button wire:click="stepperStage(-1)"  type="button" class="inline-flex w-1/3 items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Prev
                                                    </button>

                                                    <button type="submit"
                                                            class="w-1/4 inline-flex text-center  text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                                        Next - (Create Email Templates)
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class=" ml-2 w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{--End step 1 --}}
                        @elseif($stepper == 2)


                            <div class="relative  mt-2 mx-auto  w-full p-4 h-full ">
                                <div class="relative w-full">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                        <div class="px-6 py-6 lg:px-8">
                                            <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white"> {{isset($emailTpl['id']) ? 'Update' : 'Create'}} Email Template</h3>
                                            <form class="space-y-6" action="createEmailTpl" wire:submit.prevent="createEmailTpl">
                                                <div class="grid grid-cols-2 gap-4 items-end">
                                                    {{--}}<div>
                                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Template Name</label>
                                                        <input type="text"
                                                               wire:model="emailTpl.name"
                                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                               placeholder="eg: IRS Email template ..." >
                                                        @error('emailTpl.name')
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                                            {{$message}}</p>
                                                        @enderror
                                                    </div> --}}
                                                    <div>
                                                        <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subject</label>
                                                        <input type="text" wire:model="emailTpl.subject"
                                                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                                               placeholder="RE:: Attention John Doe Welcome  " >
                                                        @error('emailTpl.subject')
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                                            {{$message}}</p>
                                                        @enderror
                                                    </div>


                                                </div>


                                                <div class="grid grid-cols-1 gap-4 items-end">
                                                    <div >
                                                        <label for="paragragh" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Body</label>
                                                        <textarea id="templateBody"
                                                                  wire:model="body" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                                  placeholder="Add a table and build a great email template in it"
                                                                  wire:key="body"
                                                                  x-ref="body"
                                                                  x-init="
                                                                   tinymce.init({
                                                                            selector: '#templateBody',
                                                                            height : 700,
                                                                            menubar: false,
                                                                            resize: true,
                                                                            plugins : 'advlist autoresize codesample directionality emoticons fullscreen hr image imagetools link lists media table code colorpicker pagebreak',
                                                                            toolbar :  'table hr | image link emoticons |undo redo removeformat | formatselect fontsizeselect | bold italic underline| align | numlist bullist | forecolor backcolor | code fullscreen',
                                                                            images_upload_url : '{{route('uploadImages.tiny')}}',
                                                                            automatic_uploads: true,
                                                                            table_default_attributes : {
                                                                                    border :  0,
                                                                                    alignment: 'center'
                                                                                },
                                                                                setup: function (editor) {
                                                                                  editor.on('init change', function () {
                                                                                    editor.save();
                                                                                  });
                                                                                  editor.on('change', function (e) {
                                                                                    @this.set('body', editor.getContent());
                                                                                  });
                                                                                },
                                                                        });
                                                                   "

                                                                                >

                                                        </textarea>
                                                        @error('emailTpl.body')
                                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                                            {{$message}}</p>
                                                        @enderror
                                                    </div>
                                                </div>



                                                <div class="flex justify-end gap-4">

                                                    <button wire:click="stepperStage(-1)"  type="button" class="inline-flex w-1/3 items-center text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        Prev
                                                    </button>

                                                    <button type="submit"
                                                            class="w-1/4  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                                        Complete
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>











    <script type="text/javascript">








    </script>





</div>
