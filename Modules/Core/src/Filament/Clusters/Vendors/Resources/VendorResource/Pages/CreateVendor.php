<?php

namespace Modules\Core\Filament\Clusters\Vendors\Resources\VendorResource\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Modules\Core\Filament\Clusters\Vendors\Resources\VendorResource;
use Modules\Crm\Filament\Resources\PartnerResource\Pages\CreatePartner as BaseCreateVendor;

class CreateVendor extends BaseCreateVendor
{
    protected static string $resource = VendorResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('invoices::filament/clusters/vendors/resources/vendor/pages/create-vendor.title');
    }

    public function getBreadcrumbs(): array
    {
        $resource = static::getResource();

        $breadcrumbs = [
            $resource::getUrl() => $resource::getBreadcrumb(),
            ...(filled($breadcrumb = $this->getBreadcrumb()) ? [$breadcrumb] : []),
        ];

        $cluster = static::getCluster();

        if (filled($cluster)) {
            return [
                $cluster::getUrl() => $cluster::getClusterBreadcrumb(),
                ...$breadcrumbs,
            ];
        }

        return $breadcrumbs;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['sub_type'] = 'supplier';

        return $data;
    }
}
