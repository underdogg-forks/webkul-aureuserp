# Model-to-Enum Refactoring Documentation

## Overview

This refactoring converts certain database-backed models with fixed predefined values into PHP enums. This improves code maintainability, type safety, and performance by eliminating unnecessary database queries for static data.

## Refactored Models

### 1. ProjectStage (Projects Module)

**Previous Implementation:**
- Database table: `projects_project_stages`
- Model: `Modules\Projects\Models\ProjectStage`
- Foreign key: `stage_id` in `projects_projects` table

**New Implementation:**
- Enum: `Modules\Projects\Enums\ProjectStage`
- Column: `stage` (string) in `projects_projects` table
- Values: `to_do`, `in_progress`, `done`, `cancelled`

**Migration:**
- File: `Modules/Projects/database/migrations/2025_11_07_180000_convert_project_stage_to_enum.php`
- Converts existing `stage_id` foreign keys to enum string values
- Reversible migration for rollback

### 2. Title (CRM Module)

**Previous Implementation:**
- Database table: `partners_titles`
- Model: `Modules\Crm\Models\Title`
- Foreign key: `title_id` in `partners_partners` table

**New Implementation:**
- Enum: `Modules\Crm\Enums\Title`
- Column: `title` (string) in `partners_partners` table
- Values: `mr`, `mrs`, `miss`, `dr`, `prof`

**Migration:**
- File: `Modules/Crm/database/migrations/2025_11_07_180000_convert_title_to_enum.php`
- Converts existing `title_id` foreign keys to enum string values
- Reversible migration for rollback

## Updated Components

### Models

1. **Project Model** (`Modules/Projects/src/Models/Project.php`)
   - Added `stage` cast to `ProjectStage::class`
   - Removed `stage()` relationship method
   - Updated `$logAttributes` to reference `stage` directly

2. **Partner Model** (`Modules/Crm/src/Models/Partner.php`)
   - Added `title` cast to `Title::class`
   - Removed `title()` relationship method

### Filament Resources

1. **ProjectResource** (`Modules/Projects/src/Filament/Resources/ProjectResource.php`)
   - Changed `stage_id` to `stage` in form
   - Updated to use `ProjectStage::options()` instead of database query
   - Changed table filters from `RelationshipConstraint` to `SelectConstraint`
   - Updated grouping from `stage.name` to `stage`

2. **PartnerResource** (`Modules/Crm/src/Filament/Resources/PartnerResource.php`)
   - Changed `title_id` to `title` in form
   - Updated to use `Title::options()` instead of relationship
   - Changed table filters from `RelationshipConstraint` to `SelectConstraint`
   - Updated grouping from `title.name` to `title`

3. **Deprecated Resources**
   - `ProjectStageResource` - marked as not discovered (`isDiscovered()` returns `false`)
   - `TitleResource` - marked as not discovered (`isDiscovered()` returns `false`)

### Factories

1. **ProjectFactory** - Updated to use random enum value: `fake()->randomElement(ProjectStage::cases())->value`
2. **PartnerFactory** - Updated to use random enum value: `fake()->randomElement(Title::cases())->value`

### Seeders

1. **ProjectStageSeeder** - Deprecated (seeder method emptied with documentation note)
2. **TitleSeeder** - Deprecated (seeder method emptied with documentation note)

### Translation Files

Added enum translation files:
- `Modules/Projects/resources/lang/en/enums/project-stage.php`
- `Modules/Crm/resources/lang/en/enums/title.php`

## Benefits

1. **Type Safety**: PHP enums provide compile-time type checking
2. **Performance**: No database queries needed for static values
3. **Maintainability**: Centralized definition of values
4. **IDE Support**: Better autocomplete and refactoring
5. **Reduced Database Load**: Fewer tables and foreign key constraints

## Models NOT Refactored (and why)

### TaskStage
**Reason**: User-configurable per project (has `project_id` foreign key). Each project can have custom task stages.

### Industry
**Reason**: Contains complex data (descriptions, `is_active` flags) that may vary per installation. Users may add custom industries.

### PackageType & OperationType
**Reason**: Complex configuration models with dimensions, weights, settings, and relationships. Not suitable for static enums.

## Migration Instructions

1. Back up your database before running migrations
2. Run migrations: `php artisan migrate`
3. If rollback is needed: `php artisan migrate:rollback`
4. Clear all caches: `php artisan optimize:clear`

## Testing Considerations

- Test creating new projects with different stages
- Test creating new partners with different titles
- Test filtering and grouping by stage/title in Filament
- Test factory-generated test data
- Verify migrations work in both directions (up and down)
