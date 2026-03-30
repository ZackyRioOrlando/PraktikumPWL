<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // KIRI (2/3) - Field utama post
                Section::make('Post Details')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        Group::make([
                            TextInput::make('title')
                                ->rules('required|min:5')
                                ->maxLength(255)
                                ->validationMessages([
                                    'required' => 'Judul wajib diisi.',
                                    'min' => 'Judul minimal 5 karakter.',
                                ]),
                            TextInput::make('slug')
                                ->rules('required|min:3')
                                ->unique()
                                ->validationMessages([
                                    'unique' => 'Slug must be uniqe'
                                ]),

                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->options(Category::all()->pluck('name', 'id'))
                                ->required()
                                // ->preload()
                                ->searchable(),

                            ColorPicker::make('color'),
                        ])->columns(2),

                        MarkdownEditor::make('body')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2), // mengambil 2 dari 3 kolom (2/3 layout)

                // KANAN (1/3) - Sidebar meta dan gambar
                Group::make([

                    Section::make('Image Upload')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('image')
                                ->required()
                                ->disk('public')
                                ->directory('posts'),
                        ]),

                    Section::make('Meta Information')
                        ->icon('heroicon-o-cog-6-tooth')
                        ->schema([
                            // TagsInput::make('tags'),
                            Select::make('tags')
                                ->relationship('tags', 'name')
                                ->multiple()
                                ->preload(),
                            Checkbox::make('published'),
                            DatePicker::make('published_at'),
                        ]),

                ])->columnSpan(1), // mengambil 1 dari 3 kolom (1/3 layout)

            ])
            ->columns(3); // grid utama 3 kolom
    }
}