@if($provider == 'youtube')

<iframe width="{{ $width }}" height="{{ $height }}" src="//www.youtube.com/embed/{{ $code }}" frameborder="0" allowfullscreen></iframe>

@elseif($provider == 'vimeo')

<iframe src="//player.vimeo.com/video/{{ $code }}" width="{{ $width }}" height="{{ $height }}" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>

@endif