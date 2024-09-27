<?php

return [
    /*
    * Features of Tomato CRM
    *
    * accounts: Enable/Disable Accounts Feature
    */
    'features' => [
        'accounts' => true,
        'meta' => true,
        'locations' => true,
        'contacts' => true,
        'requests' => true,
        'notifications' => true,
        'loginBy' => true,
        'avatar' => true,
        'types' => false,
        'teams' => false,
        'apis' => true,
        'send_otp' => true,
        'impersonate' => [
            'active' => false,
            'redirect' => '/app',
        ],
    ],

    /*
     * Accounts Configurations
     *
     * resource: User Resource Class
     */
    'resource' => null,

    /*
     * Accounts Configurations
     *
     * login_by: Login By Phone or Email
     */
    'login_by' => 'email',

    /*
     * Accounts Configurations
     *
     * required_otp: Enable/Disable OTP Verification
     */
    'required_otp' => true,

    /*
     * Accounts Configurations
     *
     * model: User Model Class
     */
    'model' => \App\Models\Account::class,

    /*
     * Accounts Configurations
     *
     * guard: Auth Guard
     */
    'guard' => 'accounts',

    'teams' => [
        'allowed' => false,
        'model' => \App\Models\Team::class,
        'invitation' => \App\Models\TeamInvitation::class,
        'membership' => \App\Models\Membership::class,
        'resource' => \App\Filament\Resources\TeamResource::class,
    ],

    /**
     * Accounts Relations Managers
     *
     * you can set selected relations to show in account resource
     */
    'relations' => \App\Filament\Resources\AccountResource\Releations\AccountRelations::class,

    /**
     * Accounts Resource Builder
     *
     * you can change the form, table, actions and filters of account resource by using filament-helpers class commands
     *
     * link: https://github.com/tomatophp/filament-helpers
     */
    'accounts' => [
        'form' => \App\Filament\Resources\AccountResource\Forms\AccountsForm::class,
        'table' => \App\Filament\Resources\AccountResource\Tables\AccountsTable::class,
        'actions' => \App\Filament\Resources\AccountResource\Actions\AccountsTableActions::class,
        'filters' => \App\Filament\Resources\AccountResource\Filters\AccountsFilters::class,
        'pages' => \App\Filament\Resources\AccountResource\Pages\AccountPagesList::class,
    ],
];
