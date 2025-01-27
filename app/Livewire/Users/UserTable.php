<?php

namespace App\Livewire\Users;

use App\Models\Roles\Role;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class UserTable extends DataTableComponent
{
    protected $model = User::class;

    protected int $index = 0;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setAdditionalSelects(['id', 'avatar'])
            ->setDefaultSort('created_at', 'desc')
            ->setSearchDisabled()
            ->setFilterLayoutSlideDown()
            ->setColumnSelectStatus(false)
            ->setToolsAttributes(['class' => 'card-body border-bottom py-3', 'default-styling' => false])
            ->setTableAttributes([
                'default' => false,
                'class' => 'table card-table table-vcenter text-nowrap datatable',
            ])
            ->setTrAttributes(fn ($row, $index) => ['default' => false, 'class' => 'align-middle'])
            ->setPaginationWrapperAttributes(['class' => 'card-footer p-3']);
    }

    public function columns(): array
    {
        return [
            Column::make('#')->label(
                fn ($row, Column $column) => ++$this->index + ($this->paginators['page'] - 1) * $this->perPage
            ),
            Column::make(__('messages.name'), 'name')
                ->sortable()
                ->view('users.columns.name'),
            Column::make(__('messages.email'), 'email')
                ->sortable(),
            Column::make(__('messages.verified'), 'email_verified_at')
                ->sortable()
                ->view('users.columns.email_verified_at'),
            Column::make(__('messages.roles'), 'role_id')
                ->label(
                    fn ($row, Column $column) => view('users.columns.roles')->withRow($row)
                ),
            Column::make(__('messages.created_at'), 'created_at')
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) => $value->format('d/m/Y h:i A')
                ),
            Column::make(__('messages.updated_at'), 'updated_at')
                ->sortable()
                ->format(fn ($value) => $value ? $value->diffForHumans() : '-'),
            Column::make(__('messages.actions'))
                ->label(
                    fn ($row, Column $column) => view('users.columns.table-actions')->withRow($row)
                )
                ->hideIf(
                    ! auth()->user()->can('read-users') &&
                    ! auth()->user()->can('edit-users') &&
                    ! auth()->user()->can('delete-users')
                ),
        ];
    }

    public function builder(): Builder
    {
        return User::with('roles');
    }

    public function filters(): array
    {
        $statusOptions = to_options([
            User::VERIFIED => __('messages.verified'), User::UNVERIFIED => __('messages.unverified'),
        ]);

        $roles = Role::all()->pluck('display_name', 'id')->toArray();
        // to_options helper is replacing index of the array
        $rolesOptions = ['' => __('messages.all')] + $roles;

        return [
            TextFilter::make(__('messages.name'), 'name')
                ->setWireLive()
                ->config([
                    'placeholder' => __('messages.search'),
                    'maxlength' => '25',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('name', 'like', '%'.$value.'%');
                }),
            TextFilter::make(__('messages.email'), 'email')
                ->setWireLive()
                ->config([
                    'placeholder' => __('messages.search'),
                    'maxlength' => '25',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('email', 'like', '%'.$value.'%');
                }),
            SelectFilter::make(__('messages.verified'), 'email_verified_at')
                ->setWireLive()
                ->options($statusOptions)
                ->filter(function (Builder $builder, string $value) {
                    if ($value == User::VERIFIED) {
                        $builder->whereNotNull('email_verified_at');
                    }

                    if ($value == User::UNVERIFIED) {
                        $builder->whereNull('email_verified_at');
                    }
                }),
            SelectFilter::make(__('messages.roles'), 'role_id')
                ->setWireLive()
                ->options($rolesOptions)
                ->filter(function (Builder $builder, string $value) {
                    $builder->whereHas('roles', fn ($query) => $query->where('id', $value));
                }),
            DateRangeFilter::make(__('messages.created_at'), 'created_at')
                ->setWireLive()
                ->config([
                    'allowInput' => false,   // Allow manual input of dates
                    'altFormat' => 'd/m/Y', // Date format that will be displayed once selected
                    'ariaDateFormat' => 'd/m/Y', // An aria-friendly date format
                ])
                ->filter(function (Builder $builder, array $dateRange) { // Expects an array.
                    $builder
                        ->whereDate('created_at', '>=', $dateRange['minDate']) // minDate is the start date selected
                        ->whereDate('created_at', '<=', $dateRange['maxDate']); // maxDate is the end date selected
                }),
        ];
    }

    public function destroy($id): void
    {
        if (auth()->user()->cannot('delete-users')) {
            flash()->error(__('messages.user_does_not_have_the_right_permissions'));
            $this->redirectRoute('dashboard');
        }

        $model = User::query()->find($id);

        if (! $model) {
            flash()->error(__('messages.user_not_found'));

            $this->redirectRoute('users.index');
        }

        $model->delete();

        flash()->success(__('messages.user_successfully_deleted'));

        $this->redirectRoute('users.index');
    }

    public function customView(): string
    {
        return 'partials.livewire-delete-confirmation';
    }
}
