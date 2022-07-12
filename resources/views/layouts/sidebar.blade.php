<div id="sidebar-menu">

    <ul class="metismenu" id="side-menu">

        <li>
            <a href="{{ route('dashboard') }}">
                <i class="fe-airplay"></i>
                <span> Dashboard </span>
            </a>
        </li>
        @foreach (getNavigations() as $jenis => $navs)
            @php
                $header = '';
            @endphp
            @foreach ($navs as $nav)
                @can('read '. $nav->url)
                    @php
                        $header = $header === '' ? true : false;
                    @endphp
                    @if ($header and $jenis != '')
                    <li class="menu-title mt-2">{{ strtoupper($jenis) }}</li>
                    @endif

                    @if ($nav->subMenus->count() > 0)
                        <li>
                            <a href="javascript: void(0);">
                                <i class="{{ $nav->icon }}"></i>
                                <span> {{ $nav->nama_menu }} </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                @foreach ($nav->subMenus as $sub)
                                    @can('read '. $sub->url)
                                    <li>
                                        <a href="{{ url($sub->url) }}">
                                            <i class="{{ $sub->icon }}" style="font-size: .7rem"></i>
                                            <span class="ml-2"> {{ $sub->nama_menu }} </span>
                                        </a>
                                    </li>
                                    @endcan
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li>
                            <a href="{{ url($nav->url) }}">
                                <i class="{{ $nav->icon }}"></i>
                                <span> {{ $nav->nama_menu }} </span>
                            </a>
                        </li>
                    @endif
                @endcan
            @endforeach
        @endforeach
    </ul>

</div>
