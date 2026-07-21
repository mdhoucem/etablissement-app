<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActualiteResource\Pages;
use App\Models\Actualite;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ActualiteResource extends Resource
{
    protected static ?string $model = Actualite::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Communication';

    protected static ?string $modelLabel = 'Actualité / Événement';

    protected static ?string $pluralModelLabel = 'Actualités & Événements';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Titre & Contenu (Français)')
                            ->schema([
                                Forms\Components\TextInput::make('titre_fr')
                                    ->label('Titre (Français)')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\Textarea::make('resume_fr')
                                    ->label('Résumé court (FR)')
                                    ->rows(2),

                                Forms\Components\RichEditor::make('contenu_fr')
                                    ->label('Contenu détaillé (FR)'),
                            ]),

                        Forms\Components\Section::make('Titre & Contenu (Arabe)')
                            ->schema([
                                Forms\Components\TextInput::make('titre_ar')
                                    ->label('Titre (Arabe)')
                                    ->required(),

                                Forms\Components\Textarea::make('resume_ar')
                                    ->label('Résumé court (AR)')
                                    ->rows(2),

                                Forms\Components\RichEditor::make('contenu_ar')
                                    ->label('Contenu détaillé (AR)'),
                            ]),
                    ])->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Publication & Configuration')
                            ->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                Forms\Components\Select::make('type')
                                    ->label('Type de publication')
                                    ->options([
                                        'actualite' => 'Actualité',
                                        'evenement' => 'Événement',
                                        'annonce' => 'Annonce officielle',
                                    ])
                                    ->default('actualite')
                                    ->required(),

                                Forms\Components\Select::make('status')
                                    ->label('Statut')
                                    ->options([
                                        'brouillon' => 'Brouillon',
                                        'publie' => 'Publié',
                                        'archive' => 'Archivé',
                                    ])
                                    ->default('publie')
                                    ->required(),

                                Forms\Components\DateTimePicker::make('date_publication')
                                    ->label('Date de publication')
                                    ->default(now()),

                                Forms\Components\Toggle::make('featured')
                                    ->label('A la une (Carrousel principal)')
                                    ->default(false),
                            ]),

                        Forms\Components\Section::make('Détails Événement')
                            ->schema([
                                Forms\Components\DateTimePicker::make('date_evenement')
                                    ->label('Date & Heure de l\'événement'),

                                Forms\Components\TextInput::make('lieu_evenement')
                                    ->label('Lieu')
                                    ->placeholder('ex: Salle des conférences'),
                            ]),

                        Forms\Components\Section::make('Image d\'illustration')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Image principale')
                                    ->image()
                                    ->directory('actualites'),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image'),

                Tables\Columns\TextColumn::make('titre_fr')
                    ->label('Titre (FR)')
                    ->searchable()
                    ->limit(35),

                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'actualite' => 'info',
                        'evenement' => 'warning',
                        'annonce' => 'danger',
                    }),

                Tables\Columns\IconColumn::make('featured')
                    ->label('À la une')
                    ->boolean(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'publie' => 'success',
                        'brouillon' => 'gray',
                        'archive' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('date_publication')
                    ->label('Publié le')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'actualite' => 'Actualité',
                        'evenement' => 'Événement',
                        'annonce' => 'Annonce',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'brouillon' => 'Brouillon',
                        'publie' => 'Publié',
                        'archive' => 'Archivé',
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
            'index' => Pages\ListActualites::route('/'),
            'create' => Pages\CreateActualite::route('/create'),
            'edit' => Pages\EditActualite::route('/{record}/edit'),
        ];
    }
}
