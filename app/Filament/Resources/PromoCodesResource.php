<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PromoCodesResource\Pages;
use App\Filament\Resources\PromoCodesResource\RelationManagers;
use App\Models\PromoCodes;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PromoCodesResource extends Resource
{
    protected static ?string $model = PromoCodes::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\TextInput::make('code')
                ->required()
                ->unique('promo_codes','code'),
                Forms\Components\TextInput::make('discount_amount')
                ->required()
                ->numeric()
                ->prefix('IDR')
                ->label('Total Discount')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('code')
                ->searchable(),
                Tables\Columns\TextColumn::make('discount_amount')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPromoCodes::route('/'),
            'create' => Pages\CreatePromoCodes::route('/create'),
            'edit' => Pages\EditPromoCodes::route('/{record}/edit'),
        ];
    }
}
