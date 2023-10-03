<x-app-layout>

    @push('style')
        <link href="{{asset('page-Builder/grapesjs.min.css')}}" rel="stylesheet">
        <script src="{{asset('page-Builder/grapesjs.min.js')}}"></script>


        <script src="https://unpkg.com/grapesjs-ga"></script>
        <script src="https://unpkg.com/grapesjs-component-twitch"></script>
        <script src="{{ asset('page-Builder/grapesjs-plugin-forms.js') }}" ></script>
        <script src="{{ asset('page-Builder/pageBuilder.js') }}" ></script>
        <script src="https://cdn.tiny.cloud/1/3xvtlsi0rr8l8mjvrtyrulxw1uh2fc2ynjqqqfllw7rbs1sw/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

    @endpush

    @livewire('campaign-template.create', ['campaign_template' => $campaignTemplate])
</x-app-layout>
