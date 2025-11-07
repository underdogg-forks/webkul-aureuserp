<?php

namespace Modules\Core\Services;

use BezhanSalleh\FilamentShield\Facades\FilamentShield;
use Illuminate\Support\Str;

class PermissionManager
{
    public function managePermissions(): void
    {
        FilamentShield::buildPermissionKeyUsing(function (string $entity, string $affix, string $subject): string {
            $affix = Str::snake($affix);

            if (
                $entity === 'BezhanSalleh\FilamentShield\Resources\Roles\RoleResource'
                || $entity === 'App\Filament\Resources\RoleResource'
            ) {
                return $affix . '_role';
            }

            if (
                class_exists($entity)
                && method_exists($entity, 'getModel')
            ) {
                $resourceIdentifier = Str::of($entity)
                    ->afterLast('Resources\\')
                    ->beforeLast('Resource')
                    ->replace('\\', '')
                    ->snake()
                    ->replace('_', '::')
                    ->toString();

                if (in_array(
                    needle: $entity,
                    haystack: $this->getConflictingResources(),
                    strict: true
                )) {
                    $pluginPrefix = '';

                    if (Str::contains($entity, 'Modules\\')) {
                        $pluginPrefix = Str::of($entity)
                            ->after('Modules\\')
                            ->before('\\')
                            ->snake()
                            ->toString();
                    }

                    if ($pluginPrefix) {
                        return "{$affix}_{$pluginPrefix}_{$resourceIdentifier}";
                    }
                }

                return "{$affix}_{$resourceIdentifier}";
            }

            if (Str::contains($entity, 'Pages\\')) {
                return 'page_' . Str::snake(class_basename($entity));
            }

            if (
                Str::contains($entity, 'Widgets\\')
                || Str::endsWith($entity, 'Widget')
            ) {
                return 'widget_' . Str::snake(class_basename($entity));
            }

            return $affix . '_' . Str::snake($subject);
        });
    }

    protected function getConflictingResources(): array
    {
        return [
            'Modules\Core\Filament\Admin\Clusters\Configurations\Resources\CategoryResource',
            'Modules\Core\Filament\Admin\Clusters\Configurations\Resources\TagResource',
            'Modules\Core\Filament\Clusters\Configurations\Resources\ActivityPlanResource',
            'Modules\Projects\Filament\Clusters\Configurations\Resources\TagResource',
            'Modules\Core\Filament\Clusters\Configurations\Resources\ActivityPlanResource',
            'Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource',
            'Modules\Core\Filament\Clusters\Configurations\Resources\DepartmentResource',
            'Modules\Core\Filament\Clusters\Configurations\Resources\EmploymentTypeResource',
            'Modules\Core\Filament\Clusters\Configurations\Resources\JobPositionResource',
            'Modules\Core\Filament\Clusters\Configurations\Resources\SkillTypeResource',
            'Modules\Invoices\Filament\Clusters\Configuration\Resources\ActivityPlanResource',
            'Modules\Invoices\Filament\Clusters\Configuration\Resources\ActivityTypeResource',
            'Modules\Invoices\Filament\Clusters\Products\Resources\ProductResource',
            'Modules\Invoices\Filament\Clusters\Configuration\Resources\TagResource',
            'Modules\Core\Filament\Clusters\Configurations\Resources\ActivityTypeResource',
            'Modules\Products\Filament\Clusters\Configurations\Resources\ProductCategoryResource',
            'Modules\Products\Filament\Clusters\Products\Resources\ProductResource',
            'Modules\Invoices\Filament\Clusters\Configuration\Resources\ProductCategoryResource',
            'Modules\Expenses\Filament\Admin\Clusters\Configurations\Resources\ProductCategoryResource',
            'Modules\Expenses\Filament\Admin\Clusters\Products\Resources\ProductResource',
            'Modules\Core\Filament\Clusters\Configuration\Resources\ProductCategoryResource',
            'Modules\Core\Filament\Clusters\Configuration\Resources\BankAccountResource',
            'Modules\Core\Filament\Clusters\Vendors\Resources\ProductResource',
        ];
    }
}
