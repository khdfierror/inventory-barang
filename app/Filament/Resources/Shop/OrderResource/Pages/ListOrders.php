<?php

namespace App\Filament\Resources\Shop\OrderResource\Pages;

use App\Filament\Resources\Shop\OrderResource;
use Filament\Actions;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\HtmlString;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
 
class ListOrders extends ListRecords
{

    use ExposesTableToWidgets;

    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),     
            ExportAction::make()
            ->label('Excel')
            ->icon('carbon-document-download')
            ->exports([
                ExcelExport::make()
                    ->fromTable()
                    ->withFilename(fn ($resource) => $resource::getModelLabel() . '-' . date('Y-m-d'))
                    ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
                    ->withColumns([
                        Column::make('updated_at'),
                    ])
            ]),        
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return OrderResource::getWidgets();
    }

    public function getTabs(): array
    {
        return [
            null => ListRecords\Tab::make('All'),
            'new' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'new')),
            'processing' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'processing')),
            'shipped' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'shipped')),
            'delivered' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'delivered')),
            'cancelled' => ListRecords\Tab::make()->query(fn ($query) => $query->where('status', 'cancelled')),
        ];
    }
}
