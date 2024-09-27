<?php

namespace App\Filament\Resources;

use App\Components\TypeColumn;
use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use App\Models\Type;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    public static function getNavigationGroup(): ?string
    {
        return trans('account.group');
    }

    public static function getNavigationLabel(): string
    {
        return trans('account.contacts.label');
    }

    public static function getPluralLabel(): ?string
    {
        return trans('account.contacts.label');
    }

    public static function form(Form $form): Form
    {
        $fields = [];
        $fields[] = Forms\Components\Select::make('status')
            ->label(trans('account.contacts.columns.status'))
            ->columnSpan(2)
            ->searchable()
            ->options(Type::where('for', 'contacts')->where('type', 'status')->pluck('name', 'key')->toArray())
            ->default('pending');

        return $form
            ->schema(array_merge($fields, [
                Forms\Components\TextInput::make('subject')
                    ->label(trans('account.contacts.columns.subject'))
                    ->disabled()
                    ->columnSpan(2)
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->label(trans('account.contacts.columns.message'))
                    ->disabled()
                    ->columnSpan(2)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('active')
                    ->label(trans('account.contacts.columns.active')),
            ]));
    }

    public static function table(Table $table): Table
    {
        $columns = [];

        $columns[] = TypeColumn::make('status')
            ->label(trans('account.contacts.columns.status'))
            ->searchable();

        return $table
            ->columns(array_merge($columns, [
                Tables\Columns\TextColumn::make('type')
                    ->label(trans('account.contacts.columns.type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(trans('account.contacts.columns.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(trans('account.contacts.columns.email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(trans('account.contacts.columns.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('subject')
                    ->label(trans('account.contacts.columns.subject'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->label(trans('account.contacts.columns.active'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]))
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
        ];
    }
}
