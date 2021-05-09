@if ($items->firstItem())
    <div class="card-footer d-flex align-items-center">
        <div class="col-1 w-auto">
            <select name="status" class="form-select form-control-sm d-inline-block w-auto" id="select-status" onchange="onChangePaginationLimit()">
                <option value="10" {{ request()->has('limit') ? request()->get('limit') == 10 ? 'selected' : '' : 'selected' }}>10</option>
                <option value="25" {{ request()->get('limit') == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request()->get('limit') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request()->get('limit') == 100 ? 'selected' : '' }}>100</option>
            </select>
        </div>
        <p class="m-0 m-lg-2 text-muted">per page. <span>{{ $items->firstItem() }}</span> - <span>{{ $items->lastItem() }}</span> of <span>{{ $items->total() }}</span> records.</p>
        {!! $items->withPath(request()->url())->withQueryString()->links() !!}
    </div>
@endif

@push('scripts')
    <script type="text/javascript">
        function onChangePaginationLimit() {
            let path = '';

            if (window.location.search.length) {
                if (window.location.search.includes('limit')) {
                    let queries = [];
                    let query = window.location.search;

                    query = query.replace('?', '');
                    queries = query.split('&');

                    path = window.location.origin + window.location.pathname;

                    queries.forEach(function (_query, index) {
                        let query_partials = _query.split('=');

                        if (index == 0) {
                            path += '?'
                        } else {
                            path += '&';
                        }

                        if (query_partials[0] == 'limit') {
                            path += 'limit=' + event.target.value;
                        } else {
                            path += query_partials[0] + '=' + query_partials[1];
                        }
                    });

                } else {
                    path = window.location.href + '&limit=' + event.target.value;
                }
            } else {
                path = window.location.href + '?limit=' + event.target.value;
            }

            window.location.href = path;
        }
    </script>
@endpush
