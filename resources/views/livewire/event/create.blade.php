<div>

    <div class="relative  mt-2 mx-auto  w-3/4 p-4 min-h-screen overflow-scroll">
        <div class="relative w-full">

            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <div class="px-6 py-6 lg:px-8">
                    <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white"> {{isset($event) ? 'Update' : 'Create'}}  Event</h3>
                    <form class="space-y-6" action="createEvent" wire:submit.prevent="createEvent">

                        <div class="">
                            <x-errors class="mt-2 text-sm text-red-600 dark:text-red-500" />
                        </div>




                        <div class="grid md:grid-cols-2  gap-4">

                        <div class=" pt-2">
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event Name *</label>
                            <input type="text" wire:model="event.name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                   placeholder="Annual general Meeting-{{date('Y')}}">
                            @error('event.name')
                            <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                {{$message}}</p>
                            @enderror
                        </div>


                            <div class="pt-2">
                                <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Organization *</label>
                                <select type="category_id"
                                        wire:model="category_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                >
                                    <option> Select A Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('event.organization_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Sorry!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>


                            <div class="pt-2">
                                <label for="event.organization_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Organization *</label>
                                <select type="event.organization_id"
                                        wire:model="event.organization_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                >
                                    <option> Select An Organization</option>
                                    @foreach($organizations as $organization)
                                        <option value="{{$organization['id']}}">{{$organization['name']}}</option>
                                    @endforeach
                                </select>
                                @error('event.organization_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Sorry!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>


                            <div class="pt-2">
                                <label for="event.cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Event Cost (Optional)</label>
                                <input type="number"
                                       wire:model="event.cost" id="email"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                       placeholder="100,000" >
                                @error('event.cost')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>


                            <div class="pt-2">
                                <label for="mail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                <textarea
                                    wire:model="event.description"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500
                                          block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                >
                                </textarea>
                                @error('event.description')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500"><span class="font-medium">Oops!</span>
                                    {{$message}}</p>
                                @enderror
                            </div>

                            <div class="pt-2">
                                <label for="mail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Location</label>
                                <textarea
                                    wire:model="event.venue"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500
                                          block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                >
                                </textarea>
                                @error('event.venue')
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
                                        label="Event Start Date"
                                        placeholder="Event Start Date"
                                        wire:model.defer="start_date"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    />
                                </div>
                            </div>


                            <div class="pt-2">
                                <div>
                                    <x-datetime-picker
                                        min="today"
                                        interval="30"
                                        time-format="24"
                                        display-format="ddd, DD MMM YYYY - HH:mm"
                                        label="Event End Date"
                                        placeholder="Event End Date"
                                        wire:model.defer="end_date"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                    />
                                </div>
                            </div>



                            <label class="col-span-1 sm:col-span-2 cursor-pointer rounded-xl shadow-md min-h-fit flex items-center
                                                                    justify-center mt-3 border border-gray-400 border-dashed file-upload overflow-y-auto">
                                <div  x-data="fileUpload()">
                                    <div class="flex flex-col items-center justify-center py-3 px-3"
                                         x-on:drop="isDroppingFile = false"
                                         x-on:drop.prevent="handleFileDrop($event)"
                                         x-on:dragover.prevent="isDroppingFile = true"
                                         x-on:dragleave.prevent="isDroppingFile = false">

                                        <input type="file" hidden multiple id="file-upload" @change="handleFileSelect" >
                                        @if(count($files))
                                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                                    @foreach($files as $file)
                                                        @if( getimagesize( $file->path() ) )
                                                            <div>
                                                                <img class="h-auto max-w-full rounded-lg w-20 "
                                                                     src="{{ $file->temporaryUrl()  }}" alt="">
                                                            </div>
                                                        @else
                                                            <div>
                                                                <video class="h-auto max-w-full rounded-lg w-20" controls>
                                                                    <source src="{{ $file->path()  }}" >
                                                                </video>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                            </div>
                                        @endif
                                        <x-icon name="cloud-upload" class="w-16 h-16 text-gray-600 dark:text-gray-400" />
                                        <p class="text-gray-600 dark:text-gray-400">Click or drop files here</p>
                                    </div>
                                </div>

                            </label>
                        </div>


                        <div class="flex justify-end gap-4">
                            <button type="submit"  class="w-1/4  text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script>




        function fileUpload() {
            return {
                isDropping: false,
                isUploading: false,
                progress: 0,
                handleFileSelect(event) {
                    if (event.target.files.length ) {
                        this.uploadFiles(event.target.files)
                    }
                },
                handleFileDrop(event) {
                    if (event.dataTransfer.files.length > 0) {
                        this.uploadFiles(event.dataTransfer.files)
                    }
                },
                uploadFiles(files) {
                    const $this = this;
                    this.isUploading = true
                @this.uploadMultiple('files', files,
                    function (success) {
                        $this.isUploading = false
                        $this.progress = 0

                        //Adjust height
                        /*  var photoVideoModEl = document.getElementById('photoVideoMod')
                          var photoVideoModal = bootstrap.Modal.getInstance(photoVideoModEl) // Returns a Bootstrap modal instance
                          photoVideoModal.handleUpdate()*/

                    },
                    function(error) {
                        console.log('error', error)
                    },
                    function (event) {
                        $this.progress = event.detail.progress
                    }
                )
                },
                removeUpload(filename) {
                @this.removeUpload('files', filename);

                    //Adjust height
                    /*                    var photoVideoModEl = document.getElementById('photoVideoMod')
                                        var photoVideoModal = bootstrap.Modal.getInstance(photoVideoModEl) // Returns a Bootstrap modal instance
                                        photoVideoModal.handleUpdate()*/
                },
            }
        }
    </script>


</div>
