@foreach($row->roles as $role)
    <span class="badge bg-primary text-primary-fg @if($row->roles()->count() > 1) me-1 @endif">
        {{ $role->display_name }}
    </span>
@endforeach
