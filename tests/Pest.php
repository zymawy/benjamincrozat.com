<?php

use Tests\TestCase;
use PHPUnit\Framework\Assert;
use Illuminate\Support\Stringable;
use Illuminate\Support\Facades\Http;
use App\CommonMark\MarxdownConverter;
use App\Http\Middleware\TrackPageView;
use function Pest\Laravel\withoutVite;
use NunoMaduro\LaravelMojito\ViewAssertion;
use Torchlight\Middleware\RenderTorchlight;
use function Pest\Laravel\withoutMiddleware;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

uses(TestCase::class, LazilyRefreshDatabase::class)
    ->beforeEach(function () {
        Http::preventStrayRequests();

        Stringable::macro(
            'marxdown',
            fn () => (new MarxdownConverter(torchlight: false))->convert($this->value)
        );

        ViewAssertion::macro('doesNotContain', function (string $string) {
            Assert::assertStringNotContainsString(
                (string) $string,
                $this->html,
                "Failed asserting that the text `{$string}` exists within `{$this->html}`."
            );

            return $this;
        });

        withoutMiddleware([
            RenderTorchlight::class,
            TrackPageView::class,
        ]);

        withoutVite();
    })
    ->in('Feature');
