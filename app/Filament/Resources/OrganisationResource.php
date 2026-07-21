<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrganisationResource\Pages;
use App\Models\Organisation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrganisationResource extends Resource
{
    protected static ?string $model = Organisation::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Paramètres Généraux';

    protected static ?string $modelLabel = 'Organisation';

    protected static ?string $pluralModelLabel = 'Informations de l\'Établissement';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('OrganisationTabs')
                    ->tabs([
                        // Onglet 1 : Informations Générales (Bilingue)
                        Forms\Components\Tabs\Tab::make('Informations Générales')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Forms\Components\Section::make('Identité de l\'Établissement')
                                    ->schema([
                                        Forms\Components\TextInput::make('nom_fr')
                                            ->label('Nom (Français)')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('nom_ar')
                                            ->label('Nom (Arabe)')
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\FileUpload::make('logo')
                                            ->label('Logo Officiel')
                                            ->image()
                                            ->directory('organisation')
                                            ->columnSpanFull(),
                                    ])->columns(2),

                                Forms\Components\Section::make('Coordonnées & Contact')
                                    ->schema([
                                        Forms\Components\TextInput::make('telephone')
                                            ->label('Téléphone')
                                            ->tel(),
                                        Forms\Components\TextInput::make('numero_vert')
                                            ->label('Numéro Vert')
                                            ->tel(),
                                        Forms\Components\TextInput::make('email')
                                            ->label('Adresse Email')
                                            ->email(),
                                        Forms\Components\Select::make('status')
                                            ->label('Statut')
                                            ->options([
                                                'actif' => 'Actif',
                                                'inactif' => 'Inactif',
                                            ])
                                            ->default('actif')
                                            ->required(),
                                        Forms\Components\Textarea::make('adresse_fr')
                                            ->label('Adresse (Français)')
                                            ->rows(2),
                                        Forms\Components\Textarea::make('adresse_ar')
                                            ->label('Adresse (Arabe)')
                                            ->rows(2),
                                    ])->columns(2),
                            ]),

                        // Onglet 2 : Réseaux Sociaux
                        Forms\Components\Tabs\Tab::make('Réseaux Sociaux')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\KeyValue::make('reseaux_sociaux')
                                    ->label('Liens des Réseaux Sociaux')
                                    ->keyLabel('Plateforme (ex: Facebook, X, Youtube)')
                                    ->valueLabel('Lien URL (https://...)')
                                    ->reorderable(),
                            ]),

                        // Onglet 3 : Référencement SEO par défaut
                        Forms\Components\Tabs\Tab::make('SEO par Défaut')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Forms\Components\Textarea::make('meta_description_fr_default')
                                    ->label('Méta Description par défaut (Français)')
                                    ->rows(3),
                                Forms\Components\Textarea::make('meta_description_ar_default')
                                    ->label('Méta Description par défaut (Arabe)')
                                    ->rows(3),
                                Forms\Components\FileUpload::make('og_image_default')
                                    ->label('Image de Partage Réseaux Sociaux (OpenGraph)')
                                    ->image()
                                    ->directory('organisation/seo'),
                            ]),
                    ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo'),
                Tables\Columns\TextColumn::make('nom_fr')
                    ->label('Nom (FR)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nom_ar')
                    ->label('Nom (AR)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('telephone')
                    ->label('Téléphone'),
                Tables\Columns\TextColumn::make('numero_vert')
                    ->label('N° Vert'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'success' => 'actif',
                        'danger' => 'inactif',
                    ]),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Dernière modification')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
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
            'index' => Pages\ListOrganisations::route('/'),
            'create' => Pages\CreateOrganisation::route('/create'),
            'edit' => Pages\EditOrganisation::route('/{record}/edit'),
        ];
    }
}
