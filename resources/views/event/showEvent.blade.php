<x-guest-layout>


    <section class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-sm mt-16 text-center lg:mb-16 mb-8">

                <article class="mx-auto w-full max-w-2xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                    <header class="mb-4 lg:mb-6 not-format">
                        <h1 class="mb-4 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-6 lg:text-4xl dark:text-white"> {{$event->name}}</h1>
                        <div class="text-base">
                            <address class="inline"> <a rel="author" class="text-gray-900 no-underline dark:text-white hover:underline" href="#"> {{$event->organization->name}}</a></address>
                            on <time pubdate class="" datetime="2022-02-08" title="February 8th, 2022">

                                {{Carbon\Carbon::parse($event->start_date)->format('M jS Y')}}, {{ Carbon\Carbon::parse($event->start_date)->diffForHumans() }}
                            </time>
                        </div>
                    </header>

                    <div class="">



                        <div id="default-carousel" class="relative w-full" data-carousel="slide">
                            <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                                @foreach($event->images as $key1 => $image)
                                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                        <img  src="{{asset('storage/'.$image->image)}}" class="absolute block w-full " alt="...">
                                    </div>
                                @endforeach
                                @if($event->images()->count() <= 1)
                                        @foreach($event->images as $key2 => $image)
                                            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                                <img  src="{{asset('storage/'.$image->image)}}" class="absolute block w-full " alt="...">
                                            </div>
                                        @endforeach

                                @endif

                            </div>
                            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                            </button>
                            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                        <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                        </svg>
                                        <span class="sr-only">Next</span>
                                    </span>
                            </button>
                        </div>



                    </div>
                </article>



            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 dark:bg-gray-900 dark:text-gray-200 text-gray-800 w-full">

                <div id="default-carousel" class="relative w-full" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
                        @foreach($event->images as $key1 => $image)
                            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                                <img src="{{asset('storage/'.$image->image)}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="{{$event->name}}">


                            </div>
                        @endforeach
                    </div>
                </div>
                <div>
                    <div class="px-4 sm:px-0 space-y-2.5">
                        <h3 class=" text-3xl font-bold leading-7">{{$event->name}}</h3>
                        <a href="{{route('event.view', ['event' => $event->id])}}" class="relative z-10 rounded-full  px-3   font-medium  hover:bg-gray-100 dark:bg-gray-200 mt-5 dark:">
                            {{$event->category?->name}}
                        </a>
                    </div>
                    <div class="mt-6 border-t border-gray-100">
                        <dl class="divide-y divide-gray-100">
                            <div class="bg-gray-50 px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Event name</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$event->name}}</dd>
                            </div>
                            <div class="bg-white px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Venue</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$event->venue}}</dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Elections</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    @if($event->elections()?->count() > 0)
                                        <x-badge.circle positive icon="check" />
                                    @else
                                        <x-badge.circle negative icon="x" />
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Start date</dt>
                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                    {{Carbon\Carbon::parse($event->start_date)->format('M jS Y')}}, {{ Carbon\Carbon::parse($event->start_date)->diffForHumans() }}
                                </dd>
                            </div>
                            @if($event->cost > 0)

                                <div class="bg-white px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Attend</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        <x-button class="block rounded-md py-2 px-3" lime label="Buy Ticket" icon="shopping-cart" href="{{route('order.buy-ticket', ['event' => $event])}}" />
                                    </dd>
                                </div>

                            @endif

                            <div class="bg-gray-50 px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Info</dt>
                                <dd class="mt-1 sm:col-span-2 sm:mt-0">
                                    <p class="text-lg leading-8 text-gray-600">
                                        {{$event->description}}
                                        .</p>
                                </dd>
                            </div>
                            {{--}}
                            <div class="bg-white px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                <dt class="text-sm font-medium leading-6 text-gray-900">Attachments</dt>
                                <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                    <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                                        <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                            <div class="flex w-0 flex-1 items-center">
                                                <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                    <span class="truncate font-medium">resume_back_end_developer.pdf</span>
                                                    <span class="flex-shrink-0 text-gray-400">2.4mb</span>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                                            </div>
                                        </li>
                                        <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                            <div class="flex w-0 flex-1 items-center">
                                                <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                                </svg>
                                                <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                    <span class="truncate font-medium">coverletter_back_end_developer.pdf</span>
                                                    <span class="flex-shrink-0 text-gray-400">4.5mb</span>
                                                </div>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                                            </div>
                                        </li>
                                    </ul>
                                </dd>
                            </div> --}}
                        </dl>
                    </div>
                </div>


            </div>
        </div>
    </section>

    <div class="bg-white ">

        <div class="isolate dark:bg-gray-800 dark:text-gray-200">

            <div class="relative isolate -z-10 overflow-hidden bg-gradient-to-b from-indigo-100/20">
                <div class="absolute inset-y-0 right-1/2 -z-10 -mr-96 w-[200%] origin-top-right skew-x-[-30deg] bg-white shadow-xl shadow-indigo-600/10 ring-1 ring-indigo-50 sm:-mr-80 lg:-mr-96" aria-hidden="true"></div>
                <div class="mx-auto max-w-7xl py-32 sm:py-40 lg:px-8">
                    <div class="mx-auto lg:mx-0 lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-x-16 lg:gap-y-6 xl:grid-cols-1 xl:grid-rows-1 xl:gap-x-8">

                        <div class=" max-w-xl lg:mt-0 xl:col-end-1 xl:row-start-1">

                            <div>
                                <div class="px-4 sm:px-0 space-y-2.5">
                                    <h3 class=" text-3xl font-bold leading-7 text-gray-900">{{$event->name}}</h3>
                                    <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500 my-2">
                                        <a href="{{route('event.view', ['event' => $event->id])}}" class="relative z-10 rounded-full bg-gray-200  dark:bg-gray-200 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">
                                            {{$event->category?->name}}
                                        </a>
                                    </p>
                                </div>
                                <div class="mt-6 border-t border-gray-100">
                                    <dl class="divide-y divide-gray-100">
                                        <div class="bg-gray-50 px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Event name</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$event->name}}</dd>
                                        </div>
                                        <div class="bg-white px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Venue</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">{{$event->venue}}</dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Elections</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                @if($event->elections()?->count() > 0)
                                                    <x-badge.circle positive icon="check" />
                                                @else
                                                    <x-badge.circle negative icon="x" />
                                                @endif
                                            </dd>
                                        </div>
                                        <div class="bg-white px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Start date</dt>
                                            <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                {{Carbon\Carbon::parse($event->start_date)->format('M jS Y')}}, {{ Carbon\Carbon::parse($event->start_date)->diffForHumans() }}
                                            </dd>
                                        </div>
                                        @if($event->cost > 0)

                                            <div class="bg-white px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                                <dt class="text-sm font-medium leading-6 text-gray-900">Attend</dt>
                                                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                                    <x-button class="block rounded-md py-2 px-3" lime label="Buy Ticket" icon="shopping-cart" href="{{route('order.buy-ticket', ['event' => $event])}}" />
                                                </dd>
                                            </div>

                                        @endif

                                        <div class="bg-gray-50 px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Info</dt>
                                            <dd class="mt-1 sm:col-span-2 sm:mt-0">
                                                <p class="text-lg leading-8 text-gray-600">
                                                    {{$event->description}}
                                                    .</p>
                                            </dd>
                                        </div>
                                        {{--}}
                                        <div class="bg-white px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-3">
                                            <dt class="text-sm font-medium leading-6 text-gray-900">Attachments</dt>
                                            <dd class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                                <ul role="list" class="divide-y divide-gray-100 rounded-md border border-gray-200">
                                                    <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                                        <div class="flex w-0 flex-1 items-center">
                                                            <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                                            </svg>
                                                            <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                                <span class="truncate font-medium">resume_back_end_developer.pdf</span>
                                                                <span class="flex-shrink-0 text-gray-400">2.4mb</span>
                                                            </div>
                                                        </div>
                                                        <div class="ml-4 flex-shrink-0">
                                                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                                                        </div>
                                                    </li>
                                                    <li class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                                                        <div class="flex w-0 flex-1 items-center">
                                                            <svg class="h-5 w-5 flex-shrink-0 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                <path fill-rule="evenodd" d="M15.621 4.379a3 3 0 00-4.242 0l-7 7a3 3 0 004.241 4.243h.001l.497-.5a.75.75 0 011.064 1.057l-.498.501-.002.002a4.5 4.5 0 01-6.364-6.364l7-7a4.5 4.5 0 016.368 6.36l-3.455 3.553A2.625 2.625 0 119.52 9.52l3.45-3.451a.75.75 0 111.061 1.06l-3.45 3.451a1.125 1.125 0 001.587 1.595l3.454-3.553a3 3 0 000-4.242z" clip-rule="evenodd" />
                                                            </svg>
                                                            <div class="ml-4 flex min-w-0 flex-1 gap-2">
                                                                <span class="truncate font-medium">coverletter_back_end_developer.pdf</span>
                                                                <span class="flex-shrink-0 text-gray-400">4.5mb</span>
                                                            </div>
                                                        </div>
                                                        <div class="ml-4 flex-shrink-0">
                                                            <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Download</a>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </dd>
                                        </div> --}}
                                    </dl>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <div class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t from-white sm:h-32"></div>
            </div>
            @if($event->elections()->count())
                <!-- Timeline section -->
                <div class="mx-auto -mt-8 max-w-7xl px-6 lg:px-8 gap-y-2">
                    <div class="my-2 mb-4 grid  grid-cols-1 mx-auto max-w-2xl lg:mx-0 lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-x-16 lg:gap-y-6 xl:grid-cols-1 xl:grid-rows-1 xl:gap-x-8">
                        <h1 class="max-w-2xl text-3xl font-bold tracking-tight text-gray-900 sm:text-6xl lg:col-span-2 xl:col-auto mb-3">
                            Elections
                        </h1>
                    </div>


                    <ul role="list" class="grid grid-cols-1 gap-x-4 gap-y-6 lg:grid-cols-2 xl:gap-x-6">
                        @foreach($event->elections as $election)
                            <li class="overflow-hidden rounded-xl border border-gray-200">
                                <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                                    <div class="text-sm font-medium leading-6 text-gray-900">
                                        <p class="mt-6 text-lg font-semibold leading-8 tracking-tight text-gray-900">{{$election->name}} </p>
                                    </div>
                                    <div class="relative ml-auto">
                                        <x-button icon="check" green
                                                  href="{{route('election.vote', ['election' => $election->id])}}"
                                                  class="rounded-lg"
                                                  label="Vote" />

                                    </div>
                                </div>
                                <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                                    <div class="flex justify-between gap-x-4 py-3">
                                        <dt class="text-gray-600">Election Start</dt>
                                        <dd class="text-gray-800">            {{Carbon\Carbon::parse($election->election_date)->format('M jS Y')}}
                                            <br>
                                            {{ Carbon\Carbon::parse($election->election_date)->diffForHumans() }}
                                        </dd>
                                    </div>

                                    @foreach($election->elective_positions as $position)
                                        <div class="flex  justify-between gap-x-4 py-3">
                                            <dt class="text-gray-500">{{$position->position}}</dt>
                                            <dd class="flex items-start gap-x-2">
                                                <div class="font-medium text-gray-900">{{$position?->candidates()->count()}} Positions</div>
                                            </dd>
                                        </div>
                                    @endforeach
                                </dl>
                            </li>
                        @endforeach

                    </ul>
                </div>

            @endif

            <!-- Content section -->
            <div class="flex justify-center overflow-hidden sm:mt-40">



                <div id="default-carousel" class="relative w-3/4" data-carousel="slide">
                    <!-- Carousel wrapper -->
                    <div class="relative min-h-min overflow-hidden rounded-lg">
                        @foreach($event->getMedia()->all() as $key1 => $image)
                            @if($key1 >0)
                                <div class="hidden duration-700 ease-in-out h-96" data-carousel-item>
                                    <img src="{{$image->getUrl()}}" class="absolute block w-full object-center object-fill" alt="...">
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <!-- Slider indicators -->
                    <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                        @foreach($event->getMedia()->all() as $key => $image)
                            @if($key >0)
                                <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide {{$key+1}}" data-carousel-slide-to="{{$key+1}}"></button>
                            @endif
                        @endforeach
                    </div>
                    <!-- Slider controls -->
                    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                    </button>
                    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                    </button>
                </div>



            </div>


        </div>


    </div>

















</x-guest-layout>
