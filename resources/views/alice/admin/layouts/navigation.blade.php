@if($adminNav)
    <ul class="navbar-nav mr-auto">
        @foreach($adminNav->items as $key => $menuItem)
            @if (!$menuItem->hasParent())
                <li class="nav-item {{ (URL::current() == $menuItem->url()) ? 'active' : '' }} {{($menuItem->hasChildren()?"dropdown":'')}}">
                    <a class="nav-link {{($menuItem->hasChildren()?"dropdown-toggle":'')}}" href="{{$menuItem->url()}}" {{($menuItem->hasChildren()? 'id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"':'')}}>{!!  $menuItem->title !!}</a>
            @endif
            @if ($menuItem->hasChildren())
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    @foreach($menuItem->children() as $subMenuItem)
                        <a class="dropdown-item" href="{{$subMenuItem->url() }}">{!! $subMenuItem->title !!}</a>
                    @endforeach
                </div>
                </li>
            @else
                </li>
            @endif
        @endforeach
    </ul>
@endif
