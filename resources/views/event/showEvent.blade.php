<x-guest-layout>


    <section class="bg-white dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen ">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6 mt-10">
            <div class="mx-auto max-w-screen-2xl mt-16 text-center lg:mb-16 mb-8">

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

@if($event->elections()->count())
    <!-- Block start -->
    <section class="bg-white dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="mx-auto max-w-screen-sm text-center mb-8 lg:mb-16">
                <h2 class="mb-4 text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white">Elections</h2>
            </div>


                <!-- Timeline section -->
                <div class="mx-auto -mt-8 max-w-7xl px-6 lg:px-8 gap-y-2">
                    <div class="my-2 mb-4 grid  grid-cols-1 mx-auto max-w-2xl lg:mx-0 lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-x-16 lg:gap-y-6 xl:grid-cols-1 xl:grid-rows-1 xl:gap-x-8">
                        <h1 class="max-w-2xl text-3xl font-bold tracking-tight text-gray-900 sm:text-6xl lg:col-span-2 xl:col-auto ">
                            Elections
                        </h1>

                    <ul role="list" class="grid grid-cols-1 gap-x-4 gap-y-6 lg:grid-cols-2 xl:gap-x-6">
                        @foreach($event->elections as $election)
                            <li class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-x-4 border-b border-gray-900/5 p-6">
                                    <div class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-200">
                                        <p class="mt-6 text-lg font-semibold leading-8 tracking-tight ">{{$election->name}} </p>
                                    </div>
                                    <div class="relative ml-auto">
                                        <x-button icon="check" green
                                                  href="{{route('election.vote', ['election' => $election->id])}}"
                                                  class="rounded-lg"
                                                  label="Vote" />

                                    </div>
                                </div>
                                <dl class="-my-3 divide-y divide-gray-200 dark:divide-gray-700 px-6 py-4 text-sm leading-6">
                                    <div class="flex justify-between gap-x-4 py-3">
                                        <dt class="text-gray-800 dark:text-gray-200">Election date</dt>
                                        <dd class="text-gray-800 dark:text-gray-200">            {{Carbon\Carbon::parse($election->election_date)->format('M jS Y')}}
                                            <br>
                                            {{ Carbon\Carbon::parse($election->election_date)->diffForHumans() }}
                                        </dd>
                                    </div>
{{--}}
                                    @foreach($election->elective_positions as $position)
                                        <div class="flex  justify-between gap-x-4 py-3">
                                            <dt class="text-gray-500">{{$position->position}}</dt>
                                            <dd class="flex items-start gap-x-2">
                                                <div class="font-medium text-gray-900">{{$position?->candidates()->count()}} Positions</div>
                                            </dd>
                                        </div>
                                    @endforeach --}}
                                </dl>
                            </li>
                        @endforeach

                    </ul>

                        <div>
                                        {!! $event->description !!}
                        </div>
                    </div>


                </div>


        </div>
      </section>
            @endif


            </div>

        </div>
    </section>
















</x-guest-layout>
