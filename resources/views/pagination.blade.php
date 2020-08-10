@if ($paginator->hasPages())
    <ul class="pagination">
        @if ($paginator->onFirstPage())
            <li class="paginate_button page-item previous disabled"
                id="datatable_previous">
                <a href="#" aria-controls="datatable"
                    data-dt-idx="0" tabindex="0"
                    class="page-link">
                    <span aria-hidden="true">
                        {{ trans('supervisor.list_courses.previous') }}
                    </span>
                </a>
            </li>
        @else
            <li class="paginate_button page-item previous"
                id="datatable_previous">
                <a href="{{ $paginator->previousPageUrl() }}"
                    aria-controls="datatable" data-dt-idx="0" tabindex="0"
                    class="page-link" rel="prev">
                    <span aria-hidden="true">
                        {{ trans('supervisor.list_courses.previous') }}
                    </span>
                </a>
            </li>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled">
                    {{ $element }}
                </li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active">
                            <a href="#" class="page-link">
                                {{ $page }}
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $url }}" class="page-link">
                                {{ $page }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li class="paginate_button page-item next" id="datatable_next">
                <a href="{{ $paginator->nextPageUrl() }}"
                    aria-controls="datatable" data-dt-idx="3" tabindex="0"
                    class="page-link" rel="next">
                    {{ trans('supervisor.list_courses.next') }}
                </a>
            </li>
        @else
            <li class="paginate_button page-item next disabled" id="datatable_next">
                <a href="{{ $paginator->nextPageUrl() }}"
                    aria-controls="datatable" data-dt-idx="3" tabindex="0"
                    class="page-link">
                    {{ trans('supervisor.list_courses.next') }}
                </a>
            </li>
        @endif
    </ul>
@endif
