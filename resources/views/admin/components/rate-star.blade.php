@for($i = 0; $i < 5; $i++)
    @if($rate > $i && $rate < ($i+1))
        <i class="la la-star-half-full"></i>
    @elseif($rate > $i)
        <i class="la la-star"></i>
    @else
        <i class="la la-star-o"></i>
    @endif
@endfor