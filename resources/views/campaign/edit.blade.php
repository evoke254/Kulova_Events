<x-app-layout>
    @push('style')

        <link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet">

    @endpush
    <livewire:edit-campaign :title="$campaign" />

    @push('script')


    @endpush
</x-app-layout>
