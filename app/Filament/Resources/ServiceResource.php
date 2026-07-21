<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceResource\Pages;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Gestion des Services';

    protected static ?string $modelLabel = 'Service';

    protected static ?string $pluralModelLabel = 'Services';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informations Principales')
                            ->schema([
                                Forms\Components\Select::make('groupe_service_id')
                                    ->label('Groupe de service')
                                    ->relationship('groupeService', 'titre_fr')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('titre_fr')
                                    ->label('Titre (Français)')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('titre_ar')
                                    ->label('Titre (Arabe)')
                                    ->required(),

                                Forms\Components\TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('type_service')
                                    ->label('Type de service')
                                    ->placeholder('ex: Assistance financière, Soins, etc.')
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Forms\Components\Section::make('Descriptions')
                            ->schema([
                                Forms\Components\RichEditor::make('description_fr')
                                    ->label('Description (Français)'),

                                Forms\Components\RichEditor::make('description_ar')
                                    ->label('Description (Arabe)'),

                                Forms\Components\RichEditor::make('documents_requis_fr')
                                    ->label('Documents Requis (Français)'),

                                Forms\Components\RichEditor::make('documents_requis_ar')
                                    ->label('Documents Requis (Arabe)'),
                            ])->columns(2),
                    ])->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Publication & Statut')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Statut')
                                    ->options([
                                        'actif' => 'Actif',
                                        'inactif' => 'Inactif',
                                    ])
                                    ->default('actif')
                                    ->required(),

                                Forms\Components\Toggle::make('featured')
                                    ->label('Mettre à la une (Featured)')
                                    ->default(false),

                                Forms\Components\DateTimePicker::make('date_publication')
                                    ->label('Date de publication')
                                    ->default(now()),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('groupeService.titre_fr')
                    ->label('Groupe')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('titre_fr')
                    ->label('Titre (FR)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('titre_ar')
                    ->label('Titre (AR)')
                    ->searchable(),

                Tables\Columns\IconColumn::make('featured')
                    ->label('A la une')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'actif' => 'success',
                        'inactif' => 'danger',
                    }),

                Tables\Columns\TextColumn::make('date_publication')
                    ->label('Publié le')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('groupe_service_id')
                    ->label('Groupe de service')
                    ->relationship('groupeService', 'titre_fr'),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'actif' => 'Actif',
                        'inactif' => 'Inactif',
                    ]),

                Tables\Filters\TernaryFilter::make('featured')
                    ->label('Mise en avant'),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
