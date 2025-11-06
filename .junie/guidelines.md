Testing guidelines for this repository

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
