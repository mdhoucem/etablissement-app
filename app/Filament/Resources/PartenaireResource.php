<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PartenaireResource\Pages;
use App\Models\Partenaire;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PartenaireResource extends Resource
{
    protected static ?string $model = Partenaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Gestion de l\'Établissement';

    protected static ?string $modelLabel = 'Partenaire';

    protected static ?string $pluralModelLabel = 'Partenaires';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du Partenaire')
                    ->schema([
                        Forms\Components\TextInput::make('nom')
                            ->label('Nom de l\'organisme / partenaire')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('type_partenariat')
                            ->label('Type de partenariat')
                            ->placeholder('ex: Institutionnel, Financier, ONG')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('site_web')
                            ->label('Lien du site Web')
                            ->url()
                            ->placeholder('https://exemple.tn')
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo du partenaire')
                            ->image()
                            ->directory('partenaires')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('ordre_affichage')
                            ->label('Ordre d\'affichage')
                            ->numeric()
                            ->default(0),

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
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular(),

                Tables\Columns\TextColumn::make('nom')
                    ->label('Partenaire')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type_partenariat')
                    ->label('Type')
                    ->searchable(),

                Tables\Columns\TextColumn::make('site_web')
                    ->label('Site Web')
                    ->url(fn ($record) => $record->site_web, true)
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'actif' => 'success',
                        'inactif' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('ordre_affichage')
                    ->label('Ordre')
                    ->sortable(),
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
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPartenaires::route('/'),
            'create' => Pages\CreatePartenaire::route('/create'),
            'edit' => Pages\EditPartenaire::route('/{record}/edit'),
        ];
    }
}
