<?php

namespace Jargoud\LaravelBackpackExport\Http\Controllers\Operations;

use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\Route;
use Jargoud\LaravelBackpackExport\Excel\Excel;
use Jargoud\LaravelBackpackExport\Excel\Writer;
use Jargoud\LaravelBackpackExport\Exportable;
use Jargoud\LaravelBackpackExport\Providers\LaravelBackpackExportServiceProvider as ServiceProviderAlias;
use Maatwebsite\Excel\Files\Filesystem;
use Maatwebsite\Excel\QueuedWriter;
use Maatwebsite\Excel\Reader;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait ExportOperation
{
    /**
     * @return StreamedResponse
     * @throws BindingResolutionException
     */
    public function export(): StreamedResponse
    {
        $app = app();

        $excel = new Excel(
            $app->make(Writer::class),
            $app->make(QueuedWriter::class),
            $app->make(Reader::class),
            $app->make(Filesystem::class)
        );

        return $excel->download(
            $this->getExportClass(),
            $this->getExportName(),
            $this->getExportType()
        );
    }

    abstract protected function getExportClass();

    protected function getExportName(): string
    {
        return sprintf(
            '%s-%s.csv',
            now()->format('YmdHis'),
            CRUD::getModel()->getTable()
        );
    }

    protected function getExportType(): ?string
    {
        return null;
    }

    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupOperationRoutes(string $segment, string $routeName, string $controller): void
    {
        Route::get($segment . '/export', [
            'as' => $routeName . '.export',
            'uses' => $controller . '@export',
            'operation' => 'export',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupExportDefaults(): void
    {
        CRUD::allowAccess('export');

        CRUD::operation('export', function (): void {
            CRUD::loadDefaultOperationSettingsFromConfig();
        });
    }

    protected function addExportButton(string $stack = 'top'): self
    {
        CRUD::addButton($stack, 'export', 'view', ServiceProviderAlias::NAMESPACE . '::buttons.export');

        return $this;
    }
}
