<div >

    <section style="background-image: url('{{asset('images/landing_pg_bg.jpg')}}');"
             class="bg-[url('{{url('images/landing_pg_bg.jpg')}}')] mt-10 bg-no-repeat bg-cover bg-center bg-gray-700 bg-blend-multiply ">
        <div class="relative py-8 px-4 mx-auto max-w-screen-xl text-white lg:py-16 xl:px-0 z-1">
            <div class="mb-6 max-w-screen-md lg:mb-0">
                <h1
                    class="mb-4 text-4xl font-extrabold tracking-tight leading-tight text-white md:text-5xl lg:text-6xl">
                    Text40 Event Management System</h1>
                <p class="mb-6 font-light text-gray-300 lg:mb-8 md:text-lg lg:text-xl">
                    Experience the Future of Event Management: Seamlessly plan, execute, and optimize with EMS – Your All-in-One Solution for Success!
                </p>
                <a href="{{route('login')}}"
                   class="inline-flex items-center py-3 px-5 font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-900 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                    Sign In / Register
                </a>
            </div>
            <div class="flex justify-center ">
                <div class="md:w-3/4">
                    <div    class="grid gap-y-4 p-4 mt-8 rounded lg:gap-x-4 grid-cols-1 md:grid-cols-4  lg:mt-12 bg-white  dark:bg-gray-800">
                        <div class="md:col-span-3 " id="search">
                            <label for="location-form" class="sr-only">Events</label>
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor"
                                         viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                              d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                              clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="text" wire:model="search" wire:keyup="searchFilter"
                                       class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                       placeholder="Search event name, venue">
                            </div>
                        </div>

                        <button type="button" wire:click="searchFilter"
                                class=" justify-center md:w-auto text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 inline-flex items-center">
                            <svg class="mr-2 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                      d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                      clip-rule="evenodd"></path>
                            </svg>
                            Search
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="bg-white py-4 dark:bg-gray-800 dark:text-white">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <h1    class="mb-4 text-xl  tracking-tight leading-tight dark:text-gray-200 text-gray-800 text-center md:text-5xl lg:text-6xl">Events</h1>

            <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">


                @if($events->isEmpty())
                    <div class="">
                        <p class="text-red-600">No events found</p>
                    </div>
                @endif
                @foreach($events as $event)
                    <article class="flex flex-col items-start justify-between shadow-lg p-4 rounded-lg">
                        <div class="relative w-full">
                            @if(!$event->images()->get()->isEmpty() )
                                <img src="{{ asset('storage/'. $event->images()->first()->image)  }}" alt=""
                                     class=" w-full max-h-72 rounded-2xl bg-gray-100">
                            @else

                                <img src="{{ asset('images/def_event.jpg')  }}" alt=""
                                     class=" w-full max-h-72 rounded-2xl bg-gray-100">


                            @endif
                            <a href="{{route('event.view', ['event' => $event->id])}}">
                                <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                            </a>
                        </div>

                        <div class="max-w-xl">
                            <div class="mt-8 flex items-center gap-x-4 text-xs">
                                <x-icon name="clock" class="w-5 h-5" solid />
                                <time datetime="2020-03-16" class="text-gray-500 dark:text-gray-200">
                                    {{Carbon\Carbon::parse($event->start_date)->format('M jS Y')}}, {{ Carbon\Carbon::parse($event->start_date)->diffForHumans() }}
                                </time>
                                <a href="{{route('event.view', ['event' => $event->id])}}" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">
                                    {{$event->category?->name}}
                                </a>
                            </div>
                            <div class="pt-3 flex items-center gap-x-1 text-xs">
                                <x-icon name="location-marker" class="w-5 h-5" solid />
                                <p class="mx-2 text-md text-gray-600 dark:text-gray-300">
                                    {{$event->venue }}
                                </p>
                            </div>

                            @if($event->elections()?->count() > 0)
                                <div class="pt-3 flex items-center gap-x-1 text-xs">
                                    <x-badge.circle positive class="w-5 h-5" icon="check" />
                                    <p class="mx-2 text-md text-gray-600 dark:text-gray-300">
                                        Elections
                                    </p>

                                </div>

                            @endif


                            <div class="group relative">
                                <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                                    <a href="{{route('event.view', ['event' => $event->id])}}" class="dark:text-white">
                                        <span class="absolute inset-0"></span>
                                        {{$event->name}}
                                    </a>
                                </h3>
                                <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600 dark:text-gray-200 ">
                                    @if(strlen($event->description > 100))

                                        {!! substr($event->description , 0 , 100)   !!}
                                    @else
                                        {!! $event->description !!}
                                    @endif

                                </p>
                            </div>
                            @if($event->cost > 0)
                                <div class=" flex">

                                    <x-button class="mt-6 block rounded-md py-2 px-3" lime label="Buy Ticket" icon="shopping-cart" href="{{route('order.buy-ticket', ['event' => $event])}}" />

                                </div>
                            @endif

                        </div>
                    </article>

                @endforeach
            </div>
        </div>
    </div>





</div>
