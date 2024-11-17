<div class="col-12 col-md-3 border-end">
    <div class="card-body">
        <h4 class="subheader">{{ __('messages.manage_account') }}</h4>
        <div class="list-group list-group-transparent">
            <a href="{{ route('profile.edit') }}"
               class="list-group-item list-group-item-action d-flex align-items-center {{ isset($profile) && $profile ? 'active' : null }}">
                {{ __('Profile Information') }}
            </a>
            <a href="#"
               class="list-group-item list-group-item-action d-flex align-items-center {{ isset($updatePassword) && $updatePassword ? 'active' : null }}">
                {{ __('Update Password') }}
            </a>
            <a href="#"
               class="list-group-item list-group-item-action d-flex align-items-center {{ isset($deleteAccount) && $deleteAccount ? 'active' : null }}">
                {{ __('Delete Account') }}
            </a>
        </div>
    </div>
</div>
