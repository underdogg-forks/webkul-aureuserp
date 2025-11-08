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

## Additional Enum Opportunities

### Completed Refactoring
- **ActivityType** ✅ - Added proper enum casts for all enum properties:
  - `delay_unit` → `ActivityDelayUnit` enum
  - `delay_from` → `ActivityDelayFrom` enum
  - `decoration_type` → `ActivityDecorationType` enum
  - `chaining_type` → `ActivityChainingType` enum
  - `category` → `ActivityTypeAction` enum
  - Applied to both Core and Invoices modules

- **OperationType** ✅ - Already properly configured with enums:
  - `type` → `OperationType` enum
  - `reservation_method` → `ReservationMethod` enum
  - `create_backorder` → `CreateBackorder` enum
  - `move_type` → `MoveType` enum

### Not Being Refactored
The following were initially identified but are NOT being refactored per project standards:
- **Degree** (Graduate, Master, Bachelor, Doctoral) - User-configurable per installation
- **DepartureReason** (Fired, Resigned, Retired) - User-configurable per installation
- **SkillType** - User-configurable per installation

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

### Required Tests

- ✅ Test creating new projects with different stages
- ✅ Test creating new tasks with different stages
- ✅ Test creating new partners with different titles
- ✅ Test filtering and grouping by stage/title in Filament tables
- ✅ Test factory-generated test data uses valid enum values
- ✅ Verify enum values display correctly with proper labels, colors, and icons
- ✅ Test ActivityType creation and property casting
- ✅ Verify OperationType enum properties work correctly

### Verification Steps

1. **Project/Task Stage Tests:**
   ```php
   $project = Project::create(['stage' => ProjectStage::TO_DO]);
   $task = Task::create(['stage' => TaskStage::IN_PROGRESS]);
   
   // Verify enum methods work
   echo $project->stage->getLabel();  // "To Do"
   echo $project->stage->getColor();  // "gray"
   ```

2. **Partner Title Tests:**
   ```php
   $partner = Partner::create(['title' => Title::DR]);
   echo $partner->title->getLabel();  // "Doctor"
   echo $partner->title->getShortName();  // "Dr."
   ```

3. **ActivityType Enum Tests:**
   ```php
   $activityType = ActivityType::create([
       'delay_unit' => ActivityDelayUnit::DAYS,
       'delay_from' => ActivityDelayFrom::CURRENT_DATE,
       'category' => ActivityTypeAction::MEETING,
   ]);
   
   // Verify enums are cast properly
   assertTrue($activityType->delay_unit instanceof ActivityDelayUnit);
   ```

4. **Factory Tests:**
   ```php
   $project = Project::factory()->create();
   assertContains($project->stage, ProjectStage::cases());
   ```

5. **Filament Resource Tests:**
   - Navigate to Projects list and verify stage filtering works
   - Navigate to Tasks list and verify stage grouping works
   - Navigate to Partners list and verify title filtering works
   - Verify select dropdowns show proper enum labels

