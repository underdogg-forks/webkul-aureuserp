# Testing Guidelines

- All test method names must start with `it_` and be descriptive.
- Follow Arrange, Act, Assert with explicit phpdoc block comments for each phase:
  /* Arrange */
  /* Act */
  /* Assert */
- Prefer meaningful assertions over generic status checks. Assert database state and component behavior with real data.
- Use Livewire testing helpers for Filament resources:
  - Creating:
    /* Act */
    $component = Livewire::actingAs($this->user)
        ->test(ListProducts::class)
        ->mountAction('create')
        ->fillForm($payload)
        ->callMountedAction();

  - Updating:
    /* Act */
    $component = Livewire::actingAs($this->user)
        ->test(ListProducts::class)
        ->mountAction(TestAction::make('edit')->table($product), $payload)
        ->fillForm($payload)
        ->callMountedAction();

  - Deleting:
    /* Act */
    $component = Livewire::actingAs($this->user)
        ->test(ListProducts::class)
        ->mountAction(TestAction::make('delete')->table($product))
        ->callMountedAction();

- Group CRUD smoke tests with `@group smoke`.
- Where possible, reuse module DataProviders or factories to avoid duplication.
- Keep fixtures realistic, using factories for related models when needed.



Additional repository conventions (scaffolding & priorities)

- Priorities for migration/testing work: B) Core-focused modules first (accounts, employees, fields, full-calendar, plugin-manager, security, support, table-views, time-off), then C) Sales/Finance (invoices, payments, inventories/products).
- Scaffold all modules’ CRUD tests now, even if a module’s Livewire resource isn’t available yet:
  - If a List page class doesn’t exist, mark the test as skipped with a descriptive message.
  - If factories or table actions are not available yet, mount what’s available and skip the action-specific part with a clear reason.
- Database driver guard: tests should automatically skip when pdo_sqlite is unavailable in the environment (use TestCase::setUp guard).
- Keep using factories and realistic fixtures where relationships exist; when relationships aren’t ready yet, prefer minimal viable payloads and skip assertions you can’t make credibly.
- Modules vs plugins: Prefer using Module shims/namespaces where available, but while migration is in progress it’s acceptable to reference legacy Webkul\* namespaces for resources/models.
- CSS consolidation: For migrated modules only, begin moving plugin CSS into resources/css/{module}.css and import into resources/css/app.css. Leave non‑migrated plugins for a later pass.
