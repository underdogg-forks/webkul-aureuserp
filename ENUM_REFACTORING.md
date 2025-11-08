# Model-to-Enum Refactoring Documentation

## Overview

This refactoring converts database-backed models with fixed predefined values into PHP enums. This improves code maintainability, type safety, and performance by eliminating unnecessary database queries for static data.

**Approach**: Modified existing table creation migrations instead of creating new conversion migrations, ensuring clean database schema from the start.

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

**Changes:**
- Modified migration: `2024_12_12_074929_create_projects_projects_table.php`
- Removed migration: `2024_12_12_074920_create_projects_project_stages_table.php`

### 2. TaskStage (Projects Module)

**Previous Implementation:**
- Database table: `projects_task_stages`
- Model: `Modules\Projects\Models\TaskStage`
- Foreign key: `stage_id` in `projects_tasks` table

**New Implementation:**
- Enum: `Modules\Projects\Enums\TaskStage`
- Column: `stage` (string) in `projects_tasks` table
- Values: `to_do`, `in_progress`, `done`, `cancelled`

**Changes:**
- Modified migration: `2024_12_12_101344_create_projects_tasks_table.php`
- Removed migration: `2024_12_12_101340_create_projects_task_stages_table.php`

### 3. Title (CRM Module)

**Previous Implementation:**
- Database table: `partners_titles`
- Model: `Modules\Crm\Models\Title`
- Foreign key: `title_id` in `partners_partners` table

**New Implementation:**
- Enum: `Modules\Crm\Enums\Title`
- Column: `title` (string) in `partners_partners` table
- Values: `mr`, `mrs`, `miss`, `dr`, `prof`

**Changes:**
- Modified migration: `2024_12_11_101220_create_partners_partners_table.php`
- Removed migration: `2024_12_11_101127_create_partners_titles_table.php`

## Updated Components

### Models

1. **Project Model** (`Modules/Projects/src/Models/Project.php`)
   - Added `stage` cast to `ProjectStage::class`
   - Removed `stage()` relationship method
   - Updated `$logAttributes` with label: `'stage' => 'Stage'`

2. **Task Model** (`Modules/Projects/src/Models/Task.php`)
   - Added `stage` cast to `TaskStage::class`
   - Removed `stage()` relationship method
   - Updated `$logAttributes` with label: `'stage' => 'Stage'`

3. **Partner Model** (`Modules/Crm/src/Models/Partner.php`)
   - Added `title` cast to `Title::class`
   - Removed `title()` relationship method

### Filament Resources

1. **ProjectResource** - Updated to use enum select and filters
2. **TaskResource** - Updated to use enum select and filters
3. **PartnerResource** - Updated to use enum select and filters
4. **Deprecated Resources** (marked as not discovered):
   - `ProjectStageResource`
   - `TaskStageResource`
   - `TitleResource`

### Factories

1. **ProjectFactory** - Uses `fake()->randomElement(ProjectStage::cases())->value`
2. **TaskFactory** - Uses `fake()->randomElement(TaskStage::cases())->value`
3. **PartnerFactory** - Uses `fake()->randomElement(Title::cases())->value`

### Seeders

All stage/title seeders deprecated with documentation notes explaining the conversion to enums.

### Translation Files

Added enum translation files:
- `Modules/Projects/resources/lang/en/enums/project-stage.php`
- `Modules/Projects/resources/lang/en/enums/task-stage.php`
- `Modules/Crm/resources/lang/en/enums/title.php`

## Benefits

1. **Type Safety**: PHP enums provide compile-time type checking
2. **Performance**: No database queries needed for static values
3. **Maintainability**: Centralized definition of values
4. **IDE Support**: Better autocomplete and refactoring
5. **Reduced Database Load**: Fewer tables and foreign key constraints
6. **Cleaner Migrations**: No conversion migrations needed - schema is correct from the start

## Additional Enum Opportunities Identified

The following models with predefined values are good candidates for future enum refactoring:

### Core Module
- **Degree** (Graduate, Master, Bachelor, Doctoral)
- **DepartureReason** (Fired, Resigned, Retired)
- **SkillType** (if has fixed values)
- **ActivityType** (if has fixed values)

### Products Module
- **OperationType** properties (some enums already used)

## Migration Instructions

1. **For New Installations**: Simply run migrations as normal
   ```bash
   php artisan migrate
   ```

2. **For Existing Installations**: Manual data migration required
   - Export existing stage/title data
   - Map to enum values
   - Update foreign key columns to enum strings
   - Drop old stage/title tables

3. **Clear Caches**
   ```bash
   php artisan optimize:clear
   ```

## Testing Considerations

- Test creating new projects/tasks with different stages
- Test creating new partners with different titles
- Test filtering and grouping by stage/title in Filament
- Test factory-generated test data
- Verify enum values display correctly with proper labels/colors/icons

