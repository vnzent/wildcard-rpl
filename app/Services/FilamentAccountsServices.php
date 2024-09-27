<?php

namespace App\Services;

class FilamentAccountsServices
{
    public array $api_validation_create = [];

    public array $actions = [];

    public array $api_validation_edit = [];

    //Media
    public bool $has_media = true;

    public array $media = [
        'avatar' => false,
    ];

    //Filters
    public array $filters = [];

    //Table
    public ?string $table_cells = null;

    public array $table_cols = [];

    public array $attached_items = [];

    //Create
    public ?string $create_form = null;

    //Edit
    public ?string $edit_form = null;

    //Show
    public array $show = [];

    //Validation
    public array $validation_create = [];

    public array $validation_edit = [];

    public array $createInputs = [];

    public array $editInputs = [];

    public array $relations = [];

    /**
     * @return $this
     */
    public function create(
        ?string $form = null
    ): static {
        $this->create_form = $form;

        return $this;
    }

    /**
     * @return $this
     */
    public function edit(
        ?string $form = null
    ): static {
        $this->edit_form = $form;

        return $this;
    }

    /**
     * @return $this
     */
    public function show(
        array $show = []
    ): static {
        $this->show = $show;

        return $this;
    }

    /**
     * @return $this
     */
    public function table(
        array $cols = [],
        ?string $view = null
    ): static {
        $this->table_cols = $cols;
        $this->table_cells = $view;

        return $this;
    }

    /**
     * @return $this
     */
    public function validation(
        array $create = [],
        array $edit = [],
        array $api_create = [],
        array $api_edit = [],
    ): static {
        $this->validation_create = $create;
        $this->validation_edit = $edit;
        $this->api_validation_create = $edit;
        $this->api_validation_edit = $edit;

        return $this;
    }

    /**
     * @return $this
     */
    public function filters(
        array $filters = []
    ): static {
        $this->filters = $filters;

        return $this;
    }

    /**
     * @return $this
     */
    public function media(
        array $media = []
    ): static {
        if (count($media)) {
            $this->has_media = true;
            $this->media = $media;
        }

        return $this;
    }

    public function attach(
        string $key,
        string $label,
        string $type = 'text',
        string|array|null $create_validation = null,
        string|array|null $update_validation = null,
        string|array|null $api_create_validation = null,
        string|array|null $api_update_validation = null,
        bool $show_on_view = true,
        bool $show_on_create = true,
        bool $show_on_edit = true,
        bool $show_on_table = false,
        bool $allow_filter = false,

    ): static {
        $this->attached_items[$key] = $type;

        if ($create_validation) {
            $this->validation_create[$key] = $create_validation;
        }
        if ($update_validation) {
            $this->validation_edit[$key] = $update_validation;
        }

        if ($api_create_validation) {
            $this->api_validation_create[$key] = $api_create_validation;
        }
        if ($update_validation) {
            $this->api_validation_edit[$key] = $api_update_validation;
        }

        if ($show_on_view) {
            $this->show[$key] = [
                'label' => $label,
                'type' => $type,
            ];
        }
        if ($show_on_table) {
            $this->table_cols[$key] = $label;
        }
        if ($allow_filter) {
            $this->filters[$key] = $key;
        }
        if ($show_on_create) {
            $this->createInputs[$key] = [
                'label' => $label,
                'type' => $type,
            ];
        }
        if ($show_on_edit) {
            $this->editInputs[$key] = [
                'label' => $label,
                'type' => $type,
            ];
        }
        if ($type === 'media') {
            $this->has_media = true;
            $this->media[$key] = false;
        }

        return $this;
    }

    public function isHasMedia(): bool
    {
        return $this->has_media;
    }

    public function getMedia(): array
    {
        return $this->media;
    }

    public function getFilters(): array
    {
        return $this->filters;
    }

    public function getTableCells(): ?string
    {
        return $this->table_cells;
    }

    public function getTableCols(): array
    {
        return $this->table_cols;
    }

    public function getCreateForm(): ?string
    {
        return $this->create_form;
    }

    public function getEditForm(): ?string
    {
        return $this->edit_form;
    }

    public function getShow(): array
    {
        return $this->show;
    }

    public function getValidationCreate(): array
    {
        return $this->validation_create;
    }

    public function getValidationEdit(): array
    {
        return $this->validation_edit;
    }

    public function getAttachedItems(): array
    {
        return $this->attached_items;
    }

    public function getApiValidationCreate(): array
    {
        return $this->api_validation_create;
    }

    public function getApiValidationEdit(): array
    {
        return $this->api_validation_edit;
    }

    public function getCreateInputs(): array
    {
        return $this->createInputs;
    }

    public function getEditInputs(): array
    {
        return $this->editInputs;
    }

    public function registerAccountRelation(array $relation): void
    {
        foreach ($relation as $item) {
            $this->relations[] = $item;
        }

    }

    public function loadRelations(): array
    {
        return $this->relations;
    }

    public function registerAccountActions(array $action): void
    {
        foreach ($action as $item) {
            $this->actions[] = $item;
        }
    }

    public function loadActions(): array
    {
        return $this->actions;
    }
}
