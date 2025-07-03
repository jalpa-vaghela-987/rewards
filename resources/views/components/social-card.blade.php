@if($point->isSpecial())
    @include('components.special-social-card', ['point' => $point])
@else
    @include('components.standard-social-card', ['point' => $point])
@endif
