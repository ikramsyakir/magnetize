@if($row->hasVerifiedEmail())
    <span class="badge bg-success text-success-fg">{{ __('messages.yes') }}</span>
@else
    <span class="badge bg-danger text-danger-fg">{{ __('messages.no') }}</span>
@endif
