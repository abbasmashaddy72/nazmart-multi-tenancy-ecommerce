<div class="dropdown">
    <a class="btn btn-info dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $periods[$period] }}
    </a>

    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        @foreach ($periods as $key => $value)
            <li>
                <a class="dropdown-item" href="{{ route('landlord.admin.dashboard') }}?period={{ $key }}">{{ $value }}</a>
            </li>
        @endforeach
    </ul>
</div>
