<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DemandeAssistanceResource\Pages;
use App\Models\DemandeAssistance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class DemandeAssistanceResource extends Resource
{
    protected static ?string $model = DemandeAssistance::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    protected static ?string $navigationGroup = 'Interactions Bénéficiaires';

    protected static ?string $modelLabel = 'Demande d\'assistance';

    protected static ?string $pluralModelLabel = 'Demandes d\'assistance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations de la Demande')
                    ->schema([
                        Forms\Components\TextInput::make('numero_suivi')
                            ->label('N° de Suivi')
                            ->disabled(),

                        Forms\Components\Select::make('service_id')
                            ->label('Service Concerné')
                            ->relationship('service', 'titre_fr')
                            ->disabled(),

                        Forms\Components\TextInput::make('nom_complet')
                            ->label('Nom Complet')
                            ->required(),

                        Forms\Components\TextInput::make('cin')
                            ->label('N° CIN')
                            ->required(),

                        Forms\Components\TextInput::make('telephone')
                            ->label('Téléphone')
                            ->tel()
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->label('Adresse E-mail')
                            ->email(),

                        Forms\Components\Textarea::make('description')
                            ->label('Description du besoin')
                            ->columnSpanFull()
                            ->rows(4),

                        Forms\Components\Select::make('statut')
                            ->label('Statut de la demande')
                            ->options([
                                'en_attente' => 'En attente',
                                'en_cours' => 'En cours de traitement',
                                'traitee' => 'Traitée / Validée',
                                'rejetee' => 'Rejetée',
                            ])
                            ->required()
                            ->native(false),
                    ])->columns(2),

                Forms\Components\Section::make('Documents Joints')
                    ->schema([
                        Forms\Components\FileUpload::make('pieces_justificatives')
                            ->label('Pièces justificatives téléversées')
                            ->directory('pieces_justificatives')
                            ->multiple() // Gère automatiquement le tableau JSON
                            ->downloadable()
                            ->openable()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero_suivi')
                    ->label('N° Suivi')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('nom_complet')
                    ->label('Nom')
                    ->searchable(),

                Tables\Columns\TextColumn::make('cin')
                    ->label('CIN')
                    ->searchable(),

                Tables\Columns\TextColumn::make('service.titre_fr')
                    ->label('Service')
                    ->sortable(),

                Tables\Columns\TextColumn::make('statut')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'en_attente' => 'warning',
                        'en_cours' => 'info',
                        'traitee' => 'success',
                        'rejetee' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date de soumission')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('statut')
                    ->options([
                        'en_attente' => 'En attente',
                        'en_cours' => 'En cours',
                        'traitee' => 'Traitée',
                        'rejetee' => 'Rejetée',
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
            'index' => Pages\ListDemandeAssistances::route('/'),
            'create' => Pages\CreateDemandeAssistance::route('/create'),
            'edit' => Pages\EditDemandeAssistance::route('/{record}/edit'),
        ];
    }
}
