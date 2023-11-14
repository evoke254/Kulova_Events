<img{!! $attributeString !!}
    class="rounded-lg shadow-lg"
    @if($loadingAttributeValue)
        loading="{{ $loadingAttributeValue }}"
   @endif src="{{ $media->getUrl($conversion) }}" alt="{{ $media->name }}">
