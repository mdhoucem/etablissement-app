<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Communication';

    protected static ?string $modelLabel = 'Message Reçu';

    protected static ?string $pluralModelLabel = 'Messages Reçus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations de l\'expéditeur')
                    ->schema([
                        Forms\Components\TextInput::make('nom')
                            ->label('Nom & Prénom')
                            ->disabled(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->disabled(),

                        Forms\Components\TextInput::make('telephone')
                            ->label('Téléphone')
                            ->disabled(),

                        Forms\Components\TextInput::make('sujet')
                            ->label('Sujet du message')
                            ->disabled()
                            ->columnSpanFull(),
                    ])->columns(3),

                Forms\Components\Section::make('Contenu du message')
                    ->schema([
                        Forms\Components\Textarea::make('message')
                            ->label('Message')
                            ->disabled()
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Gestion Administrative')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Statut du traitement')
                            ->options([
                                'non_lu' => 'Non lu',
                                'lu' => 'Lu',
                                'traite' => 'Traité',
                                'archive' => 'Archivé',
                            ])
                            ->default('non_lu')
                            ->required(),

                        Forms\Components\Textarea::make('notes_interne')
                            ->label('Notes internes / Réponse apportée')
                            ->placeholder('Saisissez ici les actions entreprises suite à ce message...')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->label('Expéditeur')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sujet')
                    ->label('Sujet')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'non_lu' => 'danger',
                        'lu' => 'warning',
                        'traite' => 'success',
                        'archive' => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Reçu le')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'non_lu' => 'Non lu',
                        'lu' => 'Lu',
                        'traite' => 'Traité',
                        'archive' => 'Archivé',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        // Affiche un badge dans le menu latéral avec le nombre de messages non lus
        return static::getModel()::where('status', 'non_lu')->count() ?: null;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
