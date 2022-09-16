<a href="{{ route($getNavUrl()) }}" class="nav-link {{ $isCurrent()? 'active' : '' }}">
    <i class="nav-icon fas {{ $icon }}"></i>
    <p>
        {{ ucfirst($currentPage) }}
    </p>
</a>
