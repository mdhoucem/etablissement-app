<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalerieMediaResource\Pages;
use App\Models\GalerieMedia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class GalerieMediaResource extends Resource
{
    protected static ?string $model = GalerieMedia::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Communication';

    protected static ?string $modelLabel = 'Média';

    protected static ?string $pluralModelLabel = 'Galerie Média';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations du Média')
                    ->schema([
                        Forms\Components\TextInput::make('titre_fr')
                            ->label('Titre (Français)')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('titre_ar')
                            ->label('Titre (Arabe)')
                            ->maxLength(255),

                        Forms\Components\Select::make('type')
                            ->label('Type de média')
                            ->options([
                                'photo' => 'Photo',
                                'video' => 'Vidéo',
                            ])
                            ->default('photo')
                            ->live()
                            ->required(),

                        Forms\Components\FileUpload::make('fichier')
                            ->label('Fichier Image')
                            ->image()
                            ->directory('galerie')
                            ->visible(fn (Get $get) => $get('type') === 'photo')
                            ->required(fn (Get $get) => $get('type') === 'photo'),

                        Forms\Components\TextInput::make('url_video')
                            ->label('Lien Vidéo (YouTube / Vimeo)')
                            ->url()
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->visible(fn (Get $get) => $get('type') === 'video')
                            ->required(fn (Get $get) => $get('type') === 'video'),

                        Forms\Components\Textarea::make('description_fr')
                            ->label('Description (Français)')
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('description_ar')
                            ->label('Description (Arabe)')
                            ->rows(2)
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('featured')
                            ->label('Mettre en avant dans la galerie principale')
                            ->default(false),

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
                Tables\Columns\ImageColumn::make('fichier')
                    ->label('Aperçu')
                    ->circular(),

                Tables\Columns\TextColumn::make('titre_fr')
                    ->label('Titre (FR)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'photo' => 'info',
                        'video' => 'warning',
                    }),

                Tables\Columns\IconColumn::make('featured')
                    ->label('À la une')
                    ->boolean(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'actif' => 'success',
                        'inactif' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date d\'ajout')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'photo' => 'Photo',
                        'video' => 'Vidéo',
                    ]),
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
            'index' => Pages\ListGalerieMedia::route('/'),
            'create' => Pages\CreateGalerieMedia::route('/create'),
            'edit' => Pages\EditGalerieMedia::route('/{record}/edit'),
        ];
    }
}
