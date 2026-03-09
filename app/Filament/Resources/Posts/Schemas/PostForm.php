<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Validation\Rules\Unique;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                TextInput::make('title')
                ->minLength(5)
                ->required(),
                TextInput::make('slug')
                ->unique()
                ->required(),
                select::make("category_id")
                ->relationship("category", "name")
                ->preload()
                ->searchable(),
                ColorPicker::make("color"),
                MarkdownEditor::make("body"),
                //RichEditor::make("content"),
                FileUpload::make("image")
                ->disk("public")
                ->directory("posts")
                ->visibility('public')
                ->image(),
                TagsInput::make("tags"),
                Checkbox::make("published"),
                DateTimePicker::make("published_at"),
            ]);
    }
}