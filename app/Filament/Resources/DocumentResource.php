<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';

    protected static ?string $navigationGroup = 'Gestion Documentaire';

    protected static ?string $modelLabel = 'Document';

    protected static ?string $pluralModelLabel = 'Documents Téléchargeables';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informations du Document')
                            ->schema([
                                Forms\Components\TextInput::make('titre_fr')
                                    ->label('Titre (Français)')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),

                                Forms\Components\TextInput::make('titre_ar')
                                    ->label('Titre (Arabe)')
                                    ->maxLength(255),

                                Forms\Components\Textarea::make('description_fr')
                                    ->label('Description (FR)')
                                    ->rows(3),

                                Forms\Components\Textarea::make('description_ar')
                                    ->label('Description (AR)')
                                    ->rows(3),
                            ])->columns(2),

                        Forms\Components\Section::make('Fichier à Télécharger')
                            ->schema([
                                Forms\Components\FileUpload::make('fichier')
                                    ->label('Téléverser le fichier')
                                    ->required()
                                    ->directory('documents')
                                    ->preserveFilenames()
                                    ->acceptedFileTypes([
                                        'application/pdf',
                                        'application/msword',
                                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                        'application/vnd.ms-excel',
                                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                                        'application/zip',
                                        'application/x-rar-compressed',
                                    ])
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, $state) {
                                        $file = is_array($state) ? array_first($state) : $state;

                                        if ($file instanceof TemporaryUploadedFile) {
                                            // Extrait l'extension réelle (ex: PDF, DOCX, ZIP)
                                            $ext = strtoupper($file->getClientOriginalExtension());
                                            $set('format', $ext);

                                            // Formate la taille du fichier
                                            $bytes = $file->getSize();
                                            if ($bytes >= 1048576) {
                                                $size = number_format($bytes / 1048576, 2) . ' MB';
                                            } else {
                                                $size = number_format($bytes / 1024, 2) . ' KB';
                                            }
                                            $set('taille', $size);
                                        }
                                    }),
                            ]),
                    ])->columnSpan(2),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Classification & Statut')
                            ->schema([
                                Forms\Components\TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->required()
                                    ->unique(ignoreRecord: true),

                                Forms\Components\Select::make('categorie')
                                    ->label('Catégorie')
                                    ->options([
                                        'administratif' => 'Administratif',
                                        'pedagogique' => 'Pédagogique',
                                        'reglementation' => 'Réglementation',
                                        'procedures' => 'Procédures & Guides',
                                    ])
                                    ->default('administratif')
                                    ->required(),

                                Forms\Components\Select::make('type')
                                    ->label('Nature du document')
                                    ->options([
                                        'formulaire' => 'Formulaire',
                                        'decret_loi' => 'Décret / Loi',
                                        'rapport' => 'Rapport',
                                        'guide' => 'Guide utilisateur',
                                        'autre' => 'Autre',
                                    ])
                                    ->default('formulaire')
                                    ->required(),

                                Forms\Components\TextInput::make('format')
                                    ->label('Format détecté')
                                    ->placeholder('Auto (ex: PDF)')
                                    ->readOnly(),

                                Forms\Components\TextInput::make('taille')
                                    ->label('Taille du fichier')
                                    ->placeholder('Auto (ex: 1.2 MB)')
                                    ->readOnly(),

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

                                Forms\Components\Hidden::make('user_id')
                                    ->default(fn () => Auth::id()),
                            ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titre_fr')
                    ->label('Titre (FR)')
                    ->searchable()
                    ->limit(35),

                Tables\Columns\TextColumn::make('categorie')
                    ->label('Catégorie')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'administratif' => 'Administratif',
                        'pedagogique' => 'Pédagogique',
                        'reglementation' => 'Réglementation',
                        'procedures' => 'Procédures',
                        default => $state,
                    })
                    ->color('primary'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Nature')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'formulaire' => 'Formulaire',
                        'decret_loi' => 'Décret / Loi',
                        'rapport' => 'Rapport',
                        'guide' => 'Guide',
                        'autre' => 'Autre',
                        default => $state,
                    })
                    ->color('gray'),

                Tables\Columns\TextColumn::make('format')
                    ->label('Format')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('taille')
                    ->label('Taille'),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Publié par')
                    ->default('Système'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Statut')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'publie' => 'success',
                        'brouillon' => 'warning',
                        'archive' => 'danger',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categorie')
                    ->options([
                        'administratif' => 'Administratif',
                        'pedagogique' => 'Pédagogique',
                        'reglementation' => 'Réglementation',
                        'procedures' => 'Procédures',
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }
}
