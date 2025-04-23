<?php

namespace App\Filament\Resources\ProductTransactionsResource\Pages;

use App\Filament\Resources\ProductTransactionsResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductTransactions extends ListRecords
{
    protected static string $resource = ProductTransactionsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
