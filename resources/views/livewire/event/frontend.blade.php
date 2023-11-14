<div >


    <section>
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
                <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Events</h2>
                <p class="font-light text-gray-500 sm:text-xl dark:text-gray-400">
                    Some description text here!!!!!!!!!!!!!!!!!!!!!!!
                    !!!!!
                    Motre
                </p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($events as $event)
                    <div class=" bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                        <div>
                            @if($event->getMedia())
                                <a href="#" class="rounded-t-lg mb-4">
                                    {{$event->getFirstMedia()}}
                                </a>
                            @endif
                            <article class="pt-6 p-6">
                                <div class="flex justify-between items-center mb-5 text-gray-500">
                              <span class="bg-primary-100 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
                                  <svg class="mr-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 002 2H4a2 2 0 01-2-2V5zm3 1h6v4H5V6zm6 6H5v2h6v-2z" clip-rule="evenodd"></path><path d="M15 7h1a2 2 0 012 2v5.5a1.5 1.5 0 01-3 0V7z"></path></svg>
                                  Article
                              </span>
                                    <span class="text-sm">14 days ago</span>
                                </div>
                                <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><a href="#">{{$event->name}}</a></h2>
                                <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
                                    {{substr($event->description, 0 , 20)}}....
                                </p>
                                <div class="flex justify-end items-center mt-3 gap-4">
                                    <x-button class="rounded-lg mx-3 font-semibold" lime label="Attend" icon="identification" />
                                    @if($event->elections->count())
                                        <x-button class="rounded-lg mx-3 font-semibold" warning
                                                  href="{{route('event.vote', ['event' => $event->id])}}"
                                                  label="Vote" icon="identification" />
                                    @endif
                                </div>
                            </article>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>




</div>
