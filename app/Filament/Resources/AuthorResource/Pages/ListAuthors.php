<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use App\Filament\Resources\AuthorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAuthors extends ListRecords
{
    protected static string $resource = AuthorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    // public static function getRoute(): string
    // {
    //     return '/admin/authors';
    // }

    // public static function getMiddleware(): array
    // {
    //     return ['author'];  // Apply the 'admin' middleware
    // }


}
