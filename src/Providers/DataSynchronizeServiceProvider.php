<?php

namespace BinaLinq\DataSynchronize\Providers;

use BinaLinq\Base\Facades\DashboardMenu;
use BinaLinq\Base\Facades\PanelSectionManager as PanelSectionManagerFacade;
use BinaLinq\Base\Supports\ServiceProvider;
use BinaLinq\Base\Traits\LoadAndPublishDataTrait;
use BinaLinq\DataSynchronize\Commands\ClearChunksCommand;
use BinaLinq\DataSynchronize\Commands\ExportCommand;
use BinaLinq\DataSynchronize\Commands\ExportControllerMakeCommand;
use BinaLinq\DataSynchronize\Commands\ExporterMakeCommand;
use BinaLinq\DataSynchronize\Commands\ImportCommand;
use BinaLinq\DataSynchronize\Commands\ImportControllerMakeCommand;
use BinaLinq\DataSynchronize\Commands\ImporterMakeCommand;
use BinaLinq\DataSynchronize\Commands\TestLargeExportCommand;
use BinaLinq\DataSynchronize\PanelSections\ExportPanelSection;
use BinaLinq\DataSynchronize\PanelSections\ImportPanelSection;
use Illuminate\Console\Scheduling\Schedule;

class DataSynchronizeServiceProvider extends ServiceProvider
{
    use LoadAndPublishDataTrait;

    public function boot(): void
    {
        $this
            ->setNamespace('packages/data-synchronize')
            ->loadAndPublishTranslations()
            ->loadRoutes()
            ->loadAndPublishConfigurations(['data-synchronize'])
            ->loadAndPublishViews()
            ->publishAssets()
            ->registerPanelSection()
            ->registerDashboardMenu();

        if ($this->app->runningInConsole()) {
            $this->commands([
                ImporterMakeCommand::class,
                ExporterMakeCommand::class,
                ImportControllerMakeCommand::class,
                ExportControllerMakeCommand::class,
                ClearChunksCommand::class,
                ExportCommand::class,
                ImportCommand::class,
                TestLargeExportCommand::class,
            ]);

            $this->app->afterResolving(Schedule::class, function (Schedule $schedule) {
                $schedule
                    ->command(ClearChunksCommand::class)
                    ->dailyAt('00:00');
            });
        }
    }

    protected function getPath(?string $path = null): string
    {
        return __DIR__ . '/../..' . ($path ? '/' . ltrim($path, '/') : '');
    }

    protected function registerPanelSection(): self
    {
        PanelSectionManagerFacade::group('data-synchronize')->beforeRendering(function () {
            PanelSectionManagerFacade::default()
                ->register(ExportPanelSection::class)
                ->register(ImportPanelSection::class);
        });

        return $this;
    }

    protected function registerDashboardMenu(): self
    {
        DashboardMenu::default()->beforeRetrieving(function () {
            DashboardMenu::make()
                ->registerItem([
                    'id' => 'cms-packages-data-synchronize',
                    'parent_id' => 'cms-core-tools',
                    'priority' => 9000,
                    'name' => 'packages/data-synchronize::data-synchronize.tools.export_import_data',
                    'icon' => 'ti ti-package-import',
                    'route' => 'tools.data-synchronize',
                ]);
        });

        return $this;
    }
}
