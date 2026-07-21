<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupeServiceResource\Pages;
use App\Models\GroupeService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GroupeServiceResource extends Resource
{
    protected static ?string $model = GroupeService::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Gestion des Services';

    protected static ?string $modelLabel = 'Groupe de services';

    protected static ?string $pluralModelLabel = 'Groupes de services';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations Générales')
                    ->schema([
                        Forms\Components\TextInput::make('titre_fr')
                            ->label('Titre (Français)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('titre_ar')
                            ->label('Titre (Arabe)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description_fr')
                            ->label('Description (Français)')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description_ar')
                            ->label('Description (Arabe)')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('icone')
                            ->label('Icône (Nom Heroicon)')
                            ->placeholder('ex: heroicon-o-academic-cap')
                            ->maxLength(255),

                        Forms\Components\Select::make('status')
                            ->label('Statut')
                            ->options([
                                'actif' => 'Actif',
                                'inactif' => 'Inactif',
                            ])
                            ->default('actif')
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titre_fr')
                    ->label('Titre (FR)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('titre_ar')
                    ->label('Titre (AR)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('services_count')
                    ->label('Nb Services')
                    ->counts('services')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'actif' => 'success',
                        'inactif' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'actif' => 'Actif',
                        'inactif' => 'Inactif',
                    ]),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGroupeServices::route('/'),
            'create' => Pages\CreateGroupeService::route('/create'),
            'edit' => Pages\EditGroupeService::route('/{record}/edit'),
        ];
    }
}
