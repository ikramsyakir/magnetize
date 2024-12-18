<div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <i class="ti ti-alert-triangle text-danger fs-1"></i>
                <h3>{{ __('messages.are_you_sure') }}</h3>
                <div class="text-secondary">{{ __('messages.you_wont_be_able_to_revert_this') }}</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <a id="cancel-btn" href="#" class="btn w-100" data-bs-dismiss="modal">
                                {{ __('messages.cancel') }}
                            </a>
                        </div>
                        <div class="col">
                            <a id="confirm-delete-btn" href="#" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                {{ __('messages.yes_delete_it') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('triggerDelete', (id) => {
        new bootstrap.Modal('#modal-danger').show();

        $('#confirm-delete-btn').click(function () {
            $wire.call('destroy', id); // Trigger Livewire method to delete files
            document.activeElement.blur();
        });

        $('#cancel-btn').click(function () {
            document.activeElement.blur();
        });

        $('#modal-danger').click(function () {
            document.activeElement.blur();
        });
    });
</script>
@endscript
