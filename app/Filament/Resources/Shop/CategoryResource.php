<?php

namespace App\Filament\Resources\Shop;

use App\Filament\Resources\Shop\CategoryResource\Pages;
use App\Filament\Resources\Shop\CategoryResource\RelationManagers;
use App\Models\Shop\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use FilamentTiptapEditor\TiptapEditor;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    // protected static ?string $navigationIcon = 'carbon-archive';
    protected static ?string $navigationGroup = 'Shop';
    protected static ?string $navigationParentItem = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->live(debounce: 300)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->unique(Category::class, ignoreRecord: true),

                Forms\Components\Toggle::make('visible')
                    ->inline()
                    ->label('Visible to public')
                    ->columnSpanFull(),
                TiptapEditor::make('description')
                ->columnSpanFull()
                ->profile('simple'),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->wrap()
                    ->searchable(['name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->wrap()
                    ->color('gray')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('visible')
                    ->label('Visibility'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label("Created At")
                    ->dateTime('M j, Y')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label("Updated At")
                    ->dateTime('M j, Y')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->sortable(),
                
            ])
            ->filters([
                
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCategories::route('/'),
        ];
    }
}
