<?php

namespace App\Nova;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\URL;
use Laravel\Nova\Fields\Line;
use Laravel\Nova\Fields\Slug;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Stack;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Markdown;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Affiliate extends Resource
{
    public static $model = \App\Models\Affiliate::class;

    public static $title = 'name';

    public static $search = [
        'id', 'name', 'slug', 'link', 'take', 'rating', 'pricing', 'annual_discount', 'guarantee', 'content', 'key_features', 'pros', 'cons', 'highlight_title', 'highlight_text', 'ad_title', 'ad_content',
    ];

    public function fields(NovaRequest $request) : array
    {
        return [
            ID::make()->sortable(),

            Panel::make('Basic Information', [
                Text::make(
                    'Icon',
                    fn () => $this->icon
                        ? '<img src="' . $this->icon . '" width="50" height="50" />'
                        : '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 127 127" width="50" height="50"><path fill="none" stroke="currentColor" d="M.5.5h126v126H.5z"/></svg>'
                )
                    ->asHtml()
                    ->onlyOnIndex(),

                URL::make('Icon')
                    ->displayUsing(fn () => '<img src="' . $this->icon . '" width="50" height="50" />')
                    ->asHtml()
                    ->hideFromIndex(),

                URL::make('Screenshot')
                    ->rules('nullable', 'max:255')
                    ->displayUsing(fn () => "<img src=\"$this->screenshot\" />")
                    ->asHtml()
                    ->hideFromIndex(),

                Text::make('Name')
                    ->rules('required', 'max:255')
                    ->hideFromIndex(),

                Stack::make('Details', [
                    Line::make('Name'),
                    Line::make('Slug')->extraClasses('opacity-75 text-xs'),
                ])
                    ->onlyOnIndex(),

                Slug::make('Slug')
                    ->from('Name')
                    ->rules('required', 'max:255')
                    ->sortable()
                    ->hideFromIndex(),

                URL::make('Link')
                    ->displayUsing(function () {
                        return strlen($this->link) > 50
                            ? substr($this->link, 0, 50) . '…'
                            : $this->link;
                    })
                    ->rules('nullable')
                    ->textAlign('left'),
            ]),

            Panel::make('Review', [
                Markdown::make('Take')
                    ->rules('nullable')
                    ->help('Your personal take on this affiliate.'),

                Number::make('Rating')
                    ->rules('nullable', 'min:0', 'max:10')
                    ->hideFromIndex()
                    ->help('Your rating for this affiliate, from 0 to 10.'),

                Text::make('Pricing')
                    ->rules('nullable', 'max:255')
                    ->hideFromIndex(),

                Text::make('Annual discount')
                    ->rules('nullable', 'max:255')
                    ->hideFromIndex()
                    ->help('Whether or not this affiliate offers annual discounts when billed annually.'),

                Text::make('Guarantee')
                    ->rules('nullable', 'max:255')
                    ->hideFromIndex()
                    ->help('Which guarantee this affiliate offers. Money-back, free months, etc.'),

                Markdown::make('Content')
                    ->rules('nullable')
                    ->help('A general overview of the affiliate.'),

                Markdown::make('Key features')
                    ->rules('nullable'),

                Markdown::make('Pros')
                    ->rules('nullable'),

                Markdown::make('Cons')
                    ->rules('nullable'),
            ]),

            Panel::make('Highlight', [
                Text::make('Highlight title')
                    ->rules('nullable', 'max:255')
                    ->hideFromIndex()
                    ->help('When this affiliate is highlighted at the top of a post, this title will be shown.'),

                Markdown::make('Highlight text')
                    ->rules('nullable')
                    ->help('When this affiliate is highlighted at the top of a post, this text will be shown.'),
            ]),

            BelongsToMany::make('Posts')
                ->fields(function () {
                    return [
                        Number::make('Position')
                            ->rules('nullable', 'min:1'),

                        Boolean::make('Highlight'),

                        Text::make('Highlight title')
                            ->rules('nullable', 'max:255')
                            ->help('When this affiliate is highlighted at the top of a post, this title will be shown.'),

                        Markdown::make('Highlight text')
                            ->rules('nullable', 'max:255')
                            ->help('When this affiliate is highlighted at the top of a post, this text will be shown.'),
                    ];
                })
                ->searchable(),
        ];
    }

    public function subtitle() : string
    {
        return $this->link;
    }

    public function cards(NovaRequest $request) : array
    {
        return [];
    }

    public function filters(NovaRequest $request) : array
    {
        return [];
    }

    public function lenses(NovaRequest $request) : array
    {
        return [];
    }

    public function actions(NovaRequest $request) : array
    {
        return [];
    }
}
