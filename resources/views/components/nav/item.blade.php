<li class="nav-item @if($isTree && in_array(request()->segment(2), $treeNav)) menu-open @endif">
<a href="@if(!$isTree) {{ route($getNavUrl()) }} @endif" class="nav-link {{ $isCurrent()? (!$isTree? 'active': '') : '' }}">
    @if($isTree)
        <i class="right fas fa-angle-left"></i>
    @endif
    <i class="nav-icon fas {{ $icon }}"></i>
    <p>
        {{ ucfirst($currentPage) }}
    </p>
</a>
    @if($isTree)
        <ul class="nav nav-treeview">
            @if($treeNav != [])
                @foreach($treeNav as $treeData)
                    <li class="nav-item">
                        <a  href="{{ route(request()->segment(1).".$treeData") }}" class="nav-link text-white {{ request()->segment(2) == $treeData? 'active' : '' }}">
                            <i class="nav-icon fas fa-clipboard-list"></i>
                            <p>{{  ucfirst(str_replace("-", ' ', $treeData)) }}</p>
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
    @endif
</li>
