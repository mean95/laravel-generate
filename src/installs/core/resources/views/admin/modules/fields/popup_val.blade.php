@if(startsWith($popupVal, '@'))
    <span class="error">{{ $popupVal }}</span>
@else
    @foreach(json_decode($popupVal) ?? [] as $value)
        <span class="badge badge-info">{{ $value }}</span>
    @endforeach
@endif
