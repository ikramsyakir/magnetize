<div class="toast-container position-fixed bottom-0 top-0 end-0 p-3">
    @if(flash()->message)
        <div id="flash-toast" class="toast align-items-center {{ flash()->class }} border-0" role="alert"
             aria-live="assertive" aria-atomic="true" data-bs-autohide="true">
            <div class="d-flex">
                <div class="toast-body">
                    <div class="d-flex align-items-center">
                        <!-- Icon -->
                        <div class="flex-shrink-0 me-2 d-flex align-items-center">
                            @if(flash()->level == 'success')
                                <i class="ti ti-circle-check align-middle fs-1"></i>
                            @elseif(flash()->level == 'info')
                                <i class="ti ti-info-circle align-middle fs-1"></i>
                            @elseif(flash()->level == 'warning')
                                <i class="ti ti-alert-circle align-middle fs-1"></i>
                            @elseif(flash()->level == 'error')
                                <i class="ti ti-alert-triangle align-middle fs-1"></i>
                            @endif
                        </div>
                        <!-- Text -->
                        <div class="flex-grow-1 d-flex align-items-center">
                            <h4 class="mb-0 text-white">{{ flash()->message }}</h4>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                        aria-label="Close"></button>
            </div>
        </div>
    @endif
</div>

@push('scripts')
    <script type="module">
        $(function () {
            [...document.querySelectorAll('.toast')].map(toastEl => new bootstrap.Toast(toastEl).show())
        })
    </script>
@endpush
