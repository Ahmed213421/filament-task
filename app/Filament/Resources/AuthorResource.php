<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuthorResource\Pages;
use App\Filament\Resources\AuthorResource\RelationManagers;
use App\Models\Author;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AuthorResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'entypo-users';
    protected static ?int $navigationSort = 3;

    public static ?string $label = 'author';


    protected static ?string $navigationGroup = 'Blog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required(),
                TextInput::make('email')
                ->email()
                ->required(),
                TextInput::make('password')
                ->required(),
                RichEditor::make('bio')
                ->columnSpan('full'),
                Forms\Components\Section::make('link')
                    ->relationship('link')
                    ->schema([
                    TextInput::make('git')->url(),
                    TextInput::make('twitter')->url(),
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->query(User::where('role', 'author')) // Filter to only include admins
        ->columns([
            TextColumn::make('name')
                ->label('')
                ->description(fn (User $user) => $user->email),
                TextColumn::make('link.git')
                ->description(fn (User $user) => $user->link ? $user->link->twitter : 'No Twitter')
            ->label('')

        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->action(fn (User $user) => $user->delete()),
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
            'index' => Pages\ListAuthors::route('/'),
            'create' => Pages\CreateAuthor::route('/create'),
            // 'edit' => Pages\EditAuthor::route('/{record}/edit'),
        ];
    }

}
