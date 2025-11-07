# Factory Tests

This directory contains comprehensive unit tests for all Laravel Eloquent factories in the application.

## Test Structure

### Core Module Tests
- **CompanyFactoryTest**: Tests for company data generation
- **BankFactoryTest**: Tests for bank entity generation
- **ProductFactoryTest**: Tests for product factory with various types
- **EmployeeFactoryTest**: Tests for employee data with complex attributes
- **CategoryFactoryTest**: Tests for category hierarchy
- **PaymentTermFactoryTest**: Tests for payment term configurations
- **LeaveTypeFactoryTest**: Tests for leave type definitions
- **DepartmentFactoryTest**: Tests for department structures
- **CalendarFactoryTest**: Tests for calendar and working hours
- **EmployeeJobPositionFactoryTest**: Tests for job position data
- **UserFactoryTest**: Tests for user authentication data

### Test Categories

#### 1. Instantiation Tests (`FactoryInstantiationTest`)
Smoke tests to ensure all factories can be instantiated without errors.

#### 2. Relationship Tests (`FactoryRelationshipTest`)
Tests that verify factories correctly handle foreign keys and relationships.

#### 3. Data Integrity Tests (`FactoryDataIntegrityTest`)
Tests that ensure generated data follows business logic constraints:
- Valid email formats
- Non-negative prices and costs
- Realistic numeric ranges
- Valid enum values

#### 4. Edge Cases Tests (`FactoryEdgeCasesTest`)
Tests boundary conditions and special cases:
- Zero values
- Null optional fields
- Maximum/minimum values
- Boolean flag combinations

#### 5. Performance Tests (`FactoryPerformanceTest`)
Tests that verify factories can generate bulk data efficiently:
- Large dataset generation
- Data quality maintenance
- Unique identifier generation

## Running Tests

```bash
# Run all factory tests
php artisan test tests/Unit/Database/Factories

# Run specific test class
php artisan test tests/Unit/Database/Factories/Core/CompanyFactoryTest

# Run with coverage
php artisan test --coverage tests/Unit/Database/Factories

# Run specific test method
php artisan test --filter=it_creates_a_valid_company_instance
```

## Test Conventions

1. **Test Naming**: Use descriptive names starting with `it_` or `test_`
2. **Attributes**: Use PHP 8 attributes like `#[Test]` for test methods
3. **Assertions**: Use specific assertions (e.g., `assertIsString` instead of `assertTrue(is_string())`)
4. **Setup**: Use `setUp()` for common test initialization
5. **Data Generation**: Always use `Model::unguard()` to allow mass assignment in tests

## Coverage Goals

- Test all factory methods and states
- Verify all attributes are generated correctly
- Test relationship handling
- Cover edge cases and boundary conditions
- Ensure data integrity constraints