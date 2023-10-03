<div>
    @push('style')
        <script src="https://cdn.tiny.cloud/1/3xvtlsi0rr8l8mjvrtyrulxw1uh2fc2ynjqqqfllw7rbs1sw/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    @endpush

    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    @if($error)
        <div class="relative flex justify-end mt-5 mx-4 pt-6">
            <div id="toast-danger" class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z"/>
                    </svg>
                    <span class="sr-only">Error icon</span>
                </div>
                <div class="ml-3 text-sm font-normal">
                    {{$error}}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex items-center justify-center h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-danger" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
        </div>
    @endif

    <div class="relative  mt-2 mx-auto  w-3/4 p-4 h-full ">
        <div class="relative w-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white"> {{isset($template) ? 'Update' : 'Create'}} Email Template</h3>
                    <form class="space-y-6" action="createTemplate" wire:submit.prevent="createTemplate">

                        <div class="grid grid-cols-2 gap-4 items-end">
                            <div>
                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Template Name</label>
                                <input type="text" wire:model="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                       placeholder="EG: paypal template ..." >
                                @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="subject" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Subject</label>
                                <input type="text" wire:model="subject" id="subject" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                       placeholder="RE:: Attention ...." >
                                @error('subject')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>

                            <div class="mx-2 pt-2 pl-5">
                                <label class="relative inline-flex items-center mr-5 cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" wire:change="updateStatus"
                                        {{ $is_active ? "checked" : " "}}
                                    >
                                    <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></div>
                                    <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300"> Activate Template </span>
                                </label>
                            </div>
                        </div>
                          {{--
                            <div>
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload Logo</label>
                                <input wire:model="logo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="file_input" type="file">
                                @error('logo')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{$message}}</p>
                                @enderror
                            </div> --}}

                        {{--
                            <div class="grid grid-cols-2 gap-4 items-end">
                                <div>
                                    <label for="heading" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Header</label>
                                    <input type="text" wire:model="heading" id="heading" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                           placeholder="Attention" >
                                    @error('heading')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                        {{$message}}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="button_text" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">CTA Button Label</label>
                                    <input type="text" wire:model="button_text" id="button_text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Login or Register" >
                                    @error('button_text')
                                    <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                        {{$message}}</p>
                                    @enderror
                                </div>


                            </div> --}}


                        <div class="grid grid-cols-1 gap-4 items-end">
                            <div wire:ignore>
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
                                @error('paragragh')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>
                        </div>











                        <div class="flex justify-end gap-4">
                            <button type="submit"  class="w-1/4  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





</div>
