<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Support\Str;

// Dashboard
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('dashboard'));
});

// Profile
Breadcrumbs::for('profile.edit', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('messages.profile'), route('profile.edit'));
});

// Update Password
Breadcrumbs::for('profile.update-password', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('Update Password'), route('profile.update-password'));
});

// Dashboard / Roles
Breadcrumbs::for('roles.index', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('messages.roles'), route('roles.index'));
});

// Dashboard / Roles / Create Role
Breadcrumbs::for('roles.create', function ($trail) {
    $trail->parent('roles.index');
    $trail->push(__('messages.create_role'), route('roles.create'));
});

// Dashboard / Roles / Edit Role
Breadcrumbs::for('edit_role', function ($trail, $role) {
    $trail->parent('roles.index');
    $trail->push('Edit Role', route('roles.edit', $role->id));
});

// Delete Account
Breadcrumbs::for('profile.delete-account', function ($trail) {
    $trail->parent('dashboard');
    $trail->push(__('Delete Account'), route('profile.delete-account'));
});

// Dashboard / Users
Breadcrumbs::for('users', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Users', route('users.index'));
});

// Dashboard / Users / Create
Breadcrumbs::for('new_user', function ($trail) {
    $trail->parent('users');
    $trail->push('New User', route('users.create'));
});

// Dashboard / View User
Breadcrumbs::for('view_user', function ($trail, $user) {
    // If user can view all user, else user will see dashboard
    if ($user->can('read-user')) {
        $trail->parent('users');
    } else {
        $trail->parent('dashboard');
    }
    $trail->push($user->name, route('users.show', $user->id));
});

// Dashboard / Name / Edit
Breadcrumbs::for('edit_user', function ($trail, $user) {
    $trail->parent('view_user', $user);
    $trail->push('Edit', route('users.edit', $user->id));
});

// Dashboard / Permissions
Breadcrumbs::for('permissions', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Permissions', route('permissions.index'));
});

// Dashboard / Permissions / New Permission
Breadcrumbs::for('new_permission', function ($trail) {
    $trail->parent('permissions');
    $trail->push('New Permission', route('permissions.create'));
});

// Dashboard / Permission / Edit Permission
Breadcrumbs::for('edit_permission', function ($trail, $permission) {
    $trail->parent('permissions');
    $trail->push('Edit Permission', route('permissions.edit', $permission->id));
});


// Dashboard / Posts
Breadcrumbs::for('posts', function ($trail) {
    $trail->parent('dashboard');
    $trail->push('Posts', route('posts.index'));
});

// Dashboard / Posts / Create
Breadcrumbs::for('new_post', function ($trail) {
    $trail->parent('posts');
    $trail->push('New Post', route('posts.create'));
});

// Dashboard / View Post
Breadcrumbs::for('view_post', function ($trail, $post) {
    $trail->parent('posts');
    $trail->push(Str::limit($post->title, 15), route('posts.show', $post->slug));
});

// Dashboard / Title / Edit
Breadcrumbs::for('edit_post', function ($trail, $post) {
    $trail->parent('view_post', $post);
    $trail->push('Edit', route('posts.edit', $post->slug));
});
