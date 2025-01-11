<?php

namespace App\Livewire\Roles;

use App\Models\Roles\Role;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;

class RoleTable extends DataTableComponent
{
    protected $model = Role::class;

    protected int $index = 0;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setAdditionalSelects('id')
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
                ->sortable(),
            Column::make(__('messages.display_name'), 'display_name')
                ->sortable(),
            Column::make(__('messages.description'), 'description')
                ->sortable(),
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
                    fn ($row, Column $column) => view('roles.columns.table-actions')->withRow($row)
                )
                ->hideIf(
                    ! auth()->user()->can('read-roles') &&
                    ! auth()->user()->can('edit-roles') &&
                    ! auth()->user()->can('delete-roles')
                ),
        ];
    }

    public function filters(): array
    {
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
            TextFilter::make(__('messages.display_name'), 'display_name')
                ->setWireLive()
                ->config([
                    'placeholder' => __('messages.search'),
                    'maxlength' => '25',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('display_name', 'like', '%'.$value.'%');
                }),
            TextFilter::make(__('messages.description'), 'description')
                ->setWireLive()
                ->config([
                    'placeholder' => __('messages.search'),
                    'maxlength' => '50',
                ])
                ->filter(function (Builder $builder, string $value) {
                    $builder->where('description', 'like', '%'.$value.'%');
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

    public function destroy($id)
    {
        if (auth()->user()->cannot('delete-roles')) {
            flash()->error(__('messages.user_does_not_have_the_right_permissions'));

            return to_route('dashboard');
        }

        $model = Role::query()->find($id);

        if ($model) {
            $model->delete();

            flash()->success(__('messages.role_successfully_deleted'));
        } else {
            flash()->error(__('messages.something_went_wrong'));
        }

        return to_route('roles.index');
    }

    public function customView(): string
    {
        return 'partials.livewire-delete-confirmation';
    }
}
