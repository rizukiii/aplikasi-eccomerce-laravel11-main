<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTransactionsResource\Pages;
use App\Models\Products;
use App\Models\ProductTransactions;
use App\Models\PromoCodes;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductTransactionsResource extends Resource
{
    protected static ?string $model = ProductTransactions::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Product and Price')
                    ->schema([
                        Grid::make(2)
                        ->schema([
                            Forms\Components\Select::make('products_id')
                            ->relationship('product','name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated( function($state, callable $get, callable $set){
                                $product = Products::find($state);
                                $price = $product ? $product->price : 0 ;
                                $quantity = $get('quantity') ?? 1;
                                $subTotalAmount = $price * $quantity;
    
                                $set('price',$price);
                                $set('sub_total_amount', $subTotalAmount);
    
                                $discon = $get('discount_amount') ?? 0;
                                $grandtotalamount = $subTotalAmount - $discon;
                                $set('grand_total_amount', $grandtotalamount);

                                $sizes = $product ? $product->sizes->pluck('size', 'id')->toArray() : [];
                                $set('product_sizes',$sizes);
                            })
                            ->afterStateHydrated(function(callable $get, callable $set, $state){
                                $productId = $state;
                                if ($productId) {
                                    $product = Products::find($productId);
                                    $sizes = $product ? $product->sizes->pluck('size','id')->toArray() : [];
                                    $set('product_sizes', $sizes);
                                }
                            }),

                            Forms\Components\Select::make('product_sizes_id')
                            ->label('Product Size')
                            ->options(function (callable $get) {
                                $sizes = $get('product_sizes');
                                return is_array($sizes) ? $sizes : [];
                            })
                            ->required()
                            ->live(),

                            Forms\Components\TextInput::make('quantity')
                            ->required()
                            ->numeric()
                            ->prefix('Qty')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set){
                                $price = $get('price');
                                $quantity = $state;
                                $subTotalAmount = $price * $quantity;
                                $set('sub_total_amount',$subTotalAmount);
                                $discon = $get('discount_amount') ?? 0;
                                $grandtotalamount = $subTotalAmount - $discon;
                                $set('grand_total_amount',$grandtotalamount);
                            }),

                            Forms\Components\Select::make('promo_codes_id')
                            ->searchable()
                            ->relationship('promo','code')
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $get, callable $set){
                                $subTotalAmount = $get('sub_total_amount');
                                $promoCode = PromoCodes::find($state);
                                $discon = $promoCode ? $promoCode->discount_amount : 0;
                                $set('discount_amount',$discon);
                                $grandtotalamount = $subTotalAmount - $discon;
                                $set('grand_total_amount',$grandtotalamount);
                            }),
                            Forms\Components\TextInput::make('sub_total_amount')
                            ->required()
                            ->readOnly()
                            ->numeric()
                            ->prefix('IDR'),

                            Forms\Components\TextInput::make('grand_total_amount')
                            ->required()
                            ->readOnly()
                            ->numeric()
                            ->prefix('IDR'),

                            Forms\Components\TextInput::make('discount_amount')
                            ->required()
                            ->numeric()
                            ->prefix('IDR')
                        ])
                    ]),

                    Forms\Components\Wizard\Step::make('Customer Information')
                    ->schema(([
                        Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                            Forms\Components\TextInput::make('phone')
                            ->required()
                            ->maxLength(255),

                            Forms\Components\TextInput::make('email')
                            ->required()
                            ->maxLength(255),

                            Forms\Components\TextInput::make('city')
                            ->required()
                            ->maxLength(255),

                            Forms\Components\TextInput::make('post_code')
                            ->required()
                            ->maxLength(255),

                        ]),
                        Forms\Components\Textarea::make('address')
                        ->required()
                        ->rows(5),
                    ])),

                    Forms\Components\Wizard\Step::make('Payment Information')
                    ->schema(([
                        Forms\Components\TextInput::make('booking_trx_id')
                            ->required()
                            ->unique('product_transactions','booking_trx_id',ignoreRecord: true)
                            ->maxLength(255),

                            ToggleButtons::make('is_paid')
                            ->label('Apakah anda sudah membayar ?')
                            ->boolean()
                            ->grouped()
                            ->icons([
                                true => 'heroicon-o-pencil',
                                false => 'heroicon-o-clock'
                            ])
                            ->required(),

                            Forms\Components\FileUpload::make('proof')
                            ->image(255)
                            ->required(),
                    ])),
                ])
                ->columnSpan('full')
                ->columns(1)
                ->skippable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\ImageColumn::make('product.thumbnail'),

                Tables\Columns\TextColumn::make('name')
                ->searchable(),

                Tables\Columns\TextColumn::make('booking_trx_id')
                ->searchable(),

                Tables\Columns\IconColumn::make('is_paid')
                ->boolean()
                ->trueColor('success')
                ->falseColor('danger')
                ->trueIcon('heroicon-o-check-circle')
                ->falseIcon('heroicon-o-x-circle')
                ->label('Terverifikasi')
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('approve')
                ->label('Approve')
                ->action(function(ProductTransactions $record){
                    $record->is_paid = true;
                    $record->save();

                    Notification::make()
                    ->title('Order Approved')
                    ->success()
                    ->body('Pesanan telah di setujui')
                    ->send();
                })
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (ProductTransactions $record) => !$record->is_paid)
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
            'index' => Pages\ListProductTransactions::route('/'),
            'create' => Pages\CreateProductTransactions::route('/create'),
            'edit' => Pages\EditProductTransactions::route('/{record}/edit'),
        ];
    }
}
