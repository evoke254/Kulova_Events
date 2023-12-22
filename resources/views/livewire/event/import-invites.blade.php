<div>

    <!-- Modal toggle -->

<x-button icon="cloud" md fuchsia label="Import" class="rounded-lg"
        data-modal-target="importInvitesModal"
        data-modal-toggle="importInvitesModal" />
    <!-- Main modal -->
    <div id="importInvitesModal"
         wire:ignore.self
         data-modal-placement="top-center"
         data-modal-backdrop="static"
         tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-7xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-2xl text-center font-semibold text-gray-900 dark:text-white">
                        Import Wizard
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="importInvitesModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="p-6 space-y-6">

                    @if(!$importing)
                        <div class="flex justify-center ">
                            <div class="flex mx-4 p-4 text-xs
                            text-gray-700
                            bg-white
                            dark:bg-gray-100 dark:text-gray-700 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                     class="w-10 h-10 mr-2 text-red-800">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                                <ol>
                                    <li>
                                        1. Please ensure your excel file has the following columns.
                                    </li>
                                    <li>
                                        2. The column "member_no" should not have a space.
                                    </li>
                                    <li>
                                        3. Column "member_no" MUST be UNIQUE
                                    </li>
                                </ol>
                            </div>
                        </div>

                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 bg-white dark:bg-gray-100 dark:text-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        name
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        email
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        phone
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        member_no
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="bg-white border-b text-gray-800 dark:text-white dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        John Doe
                                    </td>
                                    <td class="px-6 py-4">
                                        solutions@swiftappsafrica.com
                                    </td>
                                    <td class="px-6 py-4">
                                        0702755928
                                    </td>
                                    <td class="px-6 py-4">
                                        324545
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex justify-center p-4 items-center">
                            <form action="save" wire:submit.prevent="save" class="m-4 items-center">
                                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="large_size">Import Excel File</label>
                                <input class="block w-full text-lg text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                       wire:model="imported_excel_file" type="file">
                                @error('imported_excel_file')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{$message}}
                                </p>
                                @enderror

                                {{-- -Get validation errors from job--}}
                                @if (count($errors) > 0)
                                    @foreach($errors->all() as $error)
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                            {{$error}}
                                        </p>
                                    @endforeach
                                @endif
                                <div class="flex justify-center my-4">
                                    <button  type="submit" class="text-white font-bold bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300
                                 rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                        Import
                                    </button>
                                </div>
                            </form>
                        </div>

                    @elseif($importing && !$importFinished)
                        <div wire:poll="updateImportProgress" class="w-full flex justify-center">
                            <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                                Importing Users...  please wait.
                            </div>
                        </div>
                    @elseif($importFinished)
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                            <span class="font-medium">Success</span>
                            Finished importing.
                        </div>
                    @endif
                </div>
                <div class="flex justify-end items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="importInvitesModal" type="button" class="text-white font-bold bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Close</button>
                </div>
            </div>
        </div>
    </div>

</div>
