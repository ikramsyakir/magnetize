<div class="dropdown position-static">
    <a role="button" class="btn align-text-top" data-bs-toggle="dropdown" aria-expanded="true">
        <i class="fas fa-ellipsis-h text-muted"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end" data-popper-placement="bottom-end">
        @can('read-users')
            <a class="dropdown-item" href="{{ route('users.show', $row->id) }}">
                <i class="ti ti-eye me-2"></i>
                {{ __('messages.view') }}
            </a>
        @endcan
        @can('edit-users')
            <a class="dropdown-item" href="{{ route('users.edit', $row->id) }}">
                <i class="ti ti-pencil me-2"></i>
                {{ __('messages.edit') }}
            </a>
        @endcan
        @can('delete-users')
            <a class="dropdown-item" role="button" wire:click="$dispatch('triggerDelete', {{ $row->id }})">
                <i class="ti ti-trash me-2"></i>
                {{ __('messages.delete') }}
            </a>
        @endcan
    </div>
</div>

