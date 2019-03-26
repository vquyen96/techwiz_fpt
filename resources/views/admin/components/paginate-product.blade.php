@if ($paginator->lastPage() > 1)
    <nav>
        <ul class="pagination">
            <li class="page-item {{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
                <a class="page-link" href="{{
                $paginator->url(1)
                .'&search='.app('request')->input('search')
                .'&status='.app('request')->input('status')
                .'&count='.app('request')->input('count')
                }}" tabindex="-1" aria-disabled="true">{{ __('locale/components/paginate.first') }}</a>
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @if($i >= ($paginator->currentPage()-2) && $i <= ($paginator->currentPage()+2))
                    <li class=" page-item{{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                        <a class="page-link" href="{{
                        $paginator->url($i)
                        .'&search='.app('request')->input('search')
                        .'&status='.app('request')->input('status')
                        .'&count='.app('request')->input('count')
                        }}">{{ $i }} </a>
                    </li>
                @endif
            @endfor
            <li class="page-item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
                <a class="page-link" href="{{
                $paginator->url($paginator->lastPage())
                .'&search='.app('request')->input('search')
                .'&status='.app('request')->input('status')
                .'&count='.app('request')->input('count')
                }}">{{ __('locale/components/paginate.last') }}</a>
            </li>
        </ul>
    </nav>

@endif
