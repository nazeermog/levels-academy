<?php

namespace DataSource\Providers;

use Illuminate\Support\ServiceProvider;

class DataSourceServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'DataSource';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'datasource';
    protected $arrayMiggrations = [
        'Course',
        'Instructor',
        'Lesson',
        'Guest',
        'PracticeType',
        'Question',
        'Student',
        'Tag',
        'Taxonomy',
        'User',
        'StudentActivity',
        'ResultPractice',
        'Semester',
        'Inrollment',
        'StudentScore',
        'Parentt',
        'Exercise',
        'Product',
        'CategoryProduct',
        'Order',
        'Blog',
        'Transaction',
        'Organization',
        'Classroom',
        'Absence',
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        foreach ($this->arrayMiggrations as $migrationFolder)
            $this->loadMigrationsFrom(base_path($this->moduleName . '/Database/Migrations/' . $migrationFolder));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            base_path($this->moduleName . '/Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            base_path($this->moduleName . '/Config/config.php'),
            $this->moduleNameLower
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/datasource/' . $this->moduleNameLower);

        $sourcePath = base_path($this->moduleName . '/Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-datasource-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/datasource/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
            $this->loadJsonTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(base_path($this->moduleName . '/Resources/lang'), $this->moduleNameLower);
            $this->loadJsonTranslationsFrom(base_path($this->moduleName . '/Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/datasource/' . $this->moduleNameLower)) {
                $paths[] = $path . '/datasource/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
