<div >



    <div class="bg-white py-12 sm:py-32 dark:bg-gray-800 dark:text-white">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">

            <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">

                @foreach($events as $event)

                    <article class="flex flex-col items-start justify-between shadow-lg p-4 rounded-lg">
                        <div class="relative w-full">
                            @if(!$event->images()->isEmpty() )
                                <img src="{{ $event->images()->first()->image  }}" alt=""
                                     class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                            @endif
                            <a href="{{route('event.view', ['event' => $event->id])}}">
                                <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
                            </a>
                        </div>

                        <div class="max-w-xl">
                            <div class="mt-8 flex items-center gap-x-4 text-xs">
                                <time datetime="2020-03-16" class="text-gray-500 dark:text-gray-200">
                                    {{Carbon\Carbon::parse($event->start_date)->format('M jS Y')}}, {{ Carbon\Carbon::parse($event->start_date)->diffForHumans() }}
                                </time>
                                <a href="{{route('event.view', ['event' => $event->id])}}" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100">
                                    {{$event->category?->name}}
                                </a>
                            </div>
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
