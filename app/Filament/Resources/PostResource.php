<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Illuminate\Support\Str;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'gmdi-post-add-s';

    protected static ?string $navigationGroup = 'Blog';

    protected static ?string $recordTitleAttribute = 'title';

        public static function getGloballySearchableAttributes(): array
    {
        return ['user.name'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                ->schema([
                    Forms\Components\TextInput::make('title')
                ->live()
    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('slug')
                ->required()
                ->readOnly()
                ->maxLength(255),
                    RichEditor::make('description')
                    ->label('content')
                    ->required()
                    ->columnSpan('full'),
                    Hidden::make('user_id')
                    ->default(auth()->user()->id),
                    // Select::make('user_id')
                    // ->options(function () {
                    //     return User::where('role', 'author')->pluck('name', 'id');
                    // }),
                    Select::make('category_id')
                    ->required()
                    ->relationship('category','name')
                    ->columnSpan(1),
                    DatePicker::make('created_at')
                    ->label('Pulished Date')
                    ->columnSpan(1),
                    Select::make('tags')
                    ->relationship('tags','name')
                    ->columnSpan(1),
                    Select::make('status')
                    ->options([
                        'published' => 'published',
                        'draft' => 'draft',
                    ])
                    ->columnSpan(1),

                    ])->columns(2),
                    FileUpload::make('image')
                    // ->disk('public')
                // ->disk('images')
                // ->disk('s3')
                ->directory('/')
                ->columnSpan(2)
            ]);
        }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                // ImageColumn::make('image')->disk('s3'),
                TextColumn::make('title')
                ->searchable()
                ->formatStateUsing(fn ($state) => Str::limit($state, 30))
                ->url(fn (Post $post) => PostResource::getUrl('comments',[
                    'record' => $post->id,
                ])),
                TextColumn::make('user.name')->state(fn($record) => $record->user->role == 'author')->label('Author'),
                TextColumn::make('comments.user.name')
                // ->formatStateUsing(function ($state) {
                //     return implode(', ', $state->pluck('user.name')->toArray()); // Join user names
                // })
                ->label('comment authors'),
                TextColumn::make('category.name')->toggleable(true),
                TextColumn::make('slug')->toggleable(true),
            TextColumn::make('status')->badge()
            ->color(fn (string $state): string => match ($state) {
                    'published' => 'gray',
                    'draft' => 'gray',
                }),
                TextColumn::make('created_at')
                ->label('Published At')
                ->date(),
                ])
                ->filters([
                    Filter::make('created_at')
                        ->form([
                            DatePicker::make('created_from'),
                            DatePicker::make('created_until'),
                        ])
                        ->query(function (Builder $query, array $data): Builder {
                            return $query
                                ->when(
                                    $data['created_from'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                                )
                                ->when(
                                    $data['created_until'],
                                    fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                                );
                        })
                    ])
                    ->actions([
                        Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                ->requiresConfirmation()
                ->action(fn (Post $post) => $post->delete())
                ->icon('heroicon-s-trash'),
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
            RelationManagers\TagRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'view' => Pages\ViewPost::route('/{record}'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
            'comments' => Pages\Comments::route('/{record}/comments'),
        ];
    }
}
