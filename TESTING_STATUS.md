# Filament Resources Testing Status

## Completed Tests (21 resources)

✅ **Payment** - `tests/Feature/Modules/Payments/PaymentCrudTest.php`
- Covers: Modules/Core/src/Filament/Resources/PaymentsResource.php
- Table: accounts_account_payments

✅ **Product** - `tests/Feature/Modules/Products/ProductCrudTest.php` (existing)
- Covers: Modules/Products/src/Filament/Resources/ProductResource.php
- Table: products_products

✅ **Customer/Partner** - `tests/Feature/Modules/Invoices/CustomerCrudTest.php`
- Covers: Modules/Invoices/src/Filament/Clusters/Orders/Resources/CustomerResource.php
- Table: partners_partners (sub_type='customer')

✅ **Invoice** - `tests/Feature/Modules/Core/InvoiceCrudTest.php`
- Covers: Modules/Core/src/Filament/Resources/InvoiceResource.php
- Table: accounts_account_moves (move_type=OUT_INVOICE)

✅ **Bill** - `tests/Feature/Modules/Core/BillCrudTest.php`
- Covers: Modules/Core/src/Filament/Resources/BillResource.php
- Table: accounts_account_moves (move_type=IN_INVOICE)

✅ **CreditNote** - `tests/Feature/Modules/Core/CreditNoteCrudTest.php`
- Covers: Modules/Core/src/Filament/Resources/CreditNoteResource.php
- Table: accounts_account_moves (move_type=OUT_REFUND)

✅ **Refund** - `tests/Feature/Modules/Core/RefundCrudTest.php`
- Covers: Modules/Core/src/Filament/Resources/RefundResource.php
- Table: accounts_account_moves (move_type=IN_REFUND)

✅ **Company** - `tests/Feature/Modules/Core/CompanyCrudTest.php`
- Covers: Modules/Core/src/Filament/Resources/CompanyResource.php
- Table: companies

✅ **User** - `tests/Feature/Modules/Core/UserCrudTest.php`
- Covers: Modules/Core/src/Filament/Resources/UserResource.php
- Table: users

✅ **Employee** - `tests/Feature/Modules/Core/EmployeeCrudTest.php`
- Covers: Modules/Core/src/Filament/Resources/EmployeeResource.php
- Table: employees_employees

✅ **Team** - `tests/Feature/Modules/Core/TeamCrudTest.php`
- Covers: Modules/Core/src/Filament/Resources/TeamResource.php
- Table: teams

✅ **Account** - `tests/Feature/Modules/Core/AccountCrudTest.php`
- Covers: Modules/Core/src/Filament/Resources/AccountResource.php
- Table: accounts_accounts

✅ **Journal** - `tests/Feature/Modules/Core/JournalCrudTest.php`
- Covers: Modules/Core/src/Filament/Resources/JournalResource.php
- Table: accounts_journals

✅ **Vendor** - `tests/Feature/Modules/Expenses/VendorCrudTest.php`
- Covers: Modules/Expenses/src/Filament/Admin/Clusters/Orders/Resources/VendorResource.php
- Table: partners_partners (sub_type='vendor')

✅ **CRM Partner** - `tests/Feature/Modules/Crm/PartnerCrudTest.php`
- Covers: Modules/Crm/src/Filament/Resources/PartnerResource.php
- Table: partners_partners

✅ **Bank** - `tests/Feature/Modules/Crm/BankCrudTest.php`
- Covers: Modules/Crm/src/Filament/Resources/BankResource.php
- Table: banks

✅ **BankAccount** - `tests/Feature/Modules/Crm/BankAccountCrudTest.php`
- Covers: Modules/Crm/src/Filament/Resources/BankAccountResource.php
- Table: partners_bank_accounts

✅ **Quotation** - `tests/Feature/Modules/Invoices/QuotationCrudTest.php`
- Covers: Modules/Invoices/src/Filament/Clusters/Orders/Resources/QuotationResource.php
- Table: sales_orders (state=DRAFT or SENT)

✅ **SalesOrder** - `tests/Feature/Modules/Invoices/SalesOrderCrudTest.php`
- Covers: Modules/Invoices/src/Filament/Clusters/Orders/Resources/OrderResource.php
- Table: sales_orders

✅ **PurchaseOrder** - `tests/Feature/Modules/Expenses/PurchaseOrderCrudTest.php`
- Covers: Modules/Expenses/src/Filament/Admin/Clusters/Orders/Resources/PurchaseOrderResource.php
- Table: purchases_orders

✅ **PurchaseAgreement** - `tests/Feature/Modules/Expenses/PurchaseAgreementCrudTest.php`
- Covers: Modules/Expenses/src/Filament/Admin/Clusters/Orders/Resources/PurchaseAgreementResource.php
- Table: purchases_requisitions (type=AGREEMENT)

## High-Priority Resources Needing Tests

### Core Module (Financial/Critical)
- [x] **Bill** - `Modules/Core/src/Filament/Resources/BillResource.php` ✅
- [x] **CreditNote** - `Modules/Core/src/Filament/Resources/CreditNoteResource.php` ✅
- [x] **Refund** - `Modules/Core/src/Filament/Resources/RefundResource.php` ✅
- [x] **Account** - `Modules/Core/src/Filament/Resources/AccountResource.php` ✅
- [x] **Journal** - `Modules/Core/src/Filament/Resources/JournalResource.php` ✅

### Core Module (Business Critical)
- [x] **Company** - `Modules/Core/src/Filament/Resources/CompanyResource.php` ✅
- [x] **User** - `Modules/Core/src/Filament/Resources/UserResource.php` ✅
- [x] **Employee** - `Modules/Core/src/Filament/Resources/EmployeeResource.php` ✅
- [ ] **Department** - `Modules/Core/src/Filament/Resources/DepartmentResource.php` (already has test)
- [x] **Team** - `Modules/Core/src/Filament/Resources/TeamResource.php` ✅
- [ ] **Role** - `Modules/Core/src/Filament/Resources/RoleResource.php`

### Invoices Module
- [x] **Quotation** - `Modules/Invoices/src/Filament/Clusters/Orders/Resources/QuotationResource.php` ✅
- [ ] **OrderToInvoice** - `Modules/Invoices/src/Filament/Clusters/ToInvoice/Resources/OrderToInvoiceResource.php`
- [ ] **OrderToUpsell** - `Modules/Invoices/src/Filament/Clusters/ToInvoice/Resources/OrderToUpsellResource.php`

### Expenses Module
- [ ] **Order** - `Modules/Expenses/src/Filament/Admin/Clusters/Orders/Resources/OrderResource.php`
- [ ] **Quotation** - `Modules/Expenses/src/Filament/Admin/Clusters/Orders/Resources/QuotationResource.php`
- [x] **PurchaseAgreement** - `Modules/Expenses/src/Filament/Admin/Clusters/Orders/Resources/PurchaseAgreementResource.php` ✅
- [x] **Vendor** - `Modules/Expenses/src/Filament/Admin/Clusters/Orders/Resources/VendorResource.php` ✅

### CRM Module
- [x] **Partner** - `Modules/Crm/src/Filament/Resources/PartnerResource.php` ✅
- [x] **Bank** - `Modules/Crm/src/Filament/Resources/BankResource.php` ✅
- [x] **BankAccount** - `Modules/Crm/src/Filament/Resources/BankAccountResource.php` ✅
- [ ] **Address** - `Modules/Crm/src/Filament/Resources/AddressResource.php` (managed via Partner)

### Projects Module
- [ ] **Project** - `Modules/Projects/src/Filament/Resources/ProjectResource.php` (has existing test)
- [ ] **Task** - `Modules/Projects/src/Filament/Resources/TaskResource.php`
- [ ] **Timesheet** - `Modules/Projects/src/Filament/Resources/TimesheetResource.php`

### Products Module (Operations)
- [ ] **Lot** - `Modules/Products/src/Filament/Clusters/Products/Resources/LotResource.php`
- [ ] **Package** - `Modules/Products/src/Filament/Clusters/Products/Resources/PackageResource.php`
- [ ] **Operation** - `Modules/Products/src/Filament/Clusters/Operations/Resources/OperationResource.php`
- [ ] **Receipt** - `Modules/Products/src/Filament/Clusters/Operations/Resources/ReceiptResource.php`
- [ ] **Delivery** - `Modules/Products/src/Filament/Clusters/Operations/Resources/DeliveryResource.php`
- [ ] **Internal** - `Modules/Products/src/Filament/Clusters/Operations/Resources/InternalResource.php`
- [ ] **Scrap** - `Modules/Products/src/Filament/Clusters/Operations/Resources/ScrapResource.php`
- [ ] **Replenishment** - `Modules/Products/src/Filament/Clusters/Operations/Resources/ReplenishmentResource.php`
- [ ] **Warehouse** - `Modules/Products/src/Filament/Clusters/Configurations/Resources/WarehouseResource.php`
- [ ] **Location** - `Modules/Products/src/Filament/Clusters/Configurations/Resources/LocationResource.php`

## Configuration Resources (Lower Priority)

### Tax & Fiscal
- [ ] **Tax** - `Modules/Core/src/Filament/Resources/TaxResource.php`
- [ ] **TaxGroup** - `Modules/Core/src/Filament/Resources/TaxGroupResource.php`
- [ ] **FiscalPosition** - `Modules/Core/src/Filament/Resources/FiscalPositionResource.php`
- [ ] **IncoTerm** - `Modules/Core/src/Filament/Resources/IncoTermResource.php`
- [ ] **PaymentTerm** - `Modules/Core/src/Filament/Resources/PaymentTermResource.php`

### Product Configuration
- [ ] **Category** - `Modules/Core/src/Filament/Resources/CategoryResource.php` (has existing test)
- [ ] **Attribute** - `Modules/Core/src/Filament/Resources/AttributeResource.php`
- [ ] **Packaging** - `Modules/Core/src/Filament/Resources/PackagingResource.php`
- [ ] **PriceList** - `Modules/Core/src/Filament/Resources/PriceListResource.php`
- [ ] **CashRounding** - `Modules/Core/src/Filament/Resources/CashRoundingResource.php`

### HR Configuration
- [ ] **JobPosition** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/JobPositionResource.php`
- [ ] **EmployeeCategory** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/EmployeeCategoryResource.php`
- [ ] **EmploymentType** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/EmploymentTypeResource.php`
- [ ] **LeaveType** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/LeaveTypeResource.php`
- [ ] **WorkLocation** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/WorkLocationResource.php`
- [ ] **PublicHoliday** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/PublicHolidayResource.php`
- [ ] **Calendar** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/CalendarResource.php`

### Recruitment
- [ ] **Applicant** - `Modules/Core/src/Filament/Clusters/Applications/Resources/ApplicantResource.php`
- [ ] **Candidate** - `Modules/Core/src/Filament/Clusters/Applications/Resources/CandidateResource.php`
- [ ] **JobByPosition** - `Modules/Core/src/Filament/Clusters/Applications/Resources/JobByPositionResource.php`
- [ ] **ApplicantCategory** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/ApplicantCategoryResource.php`
- [ ] **Stage** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/StageResource.php`
- [ ] **RefuseReason** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/RefuseReasonResource.php`

### Time Management
- [ ] **Allocation** - `Modules/Core/src/Filament/Clusters/Management/Resources/AllocationResource.php`
- [ ] **TimeOff** - `Modules/Core/src/Filament/Clusters/Management/Resources/TimeOffResource.php`
- [ ] **MyAllocation** - `Modules/Core/src/Filament/Clusters/MyTime/Resources/MyAllocationResource.php`
- [ ] **MyTimeOff** - `Modules/Core/src/Filament/Clusters/MyTime/Resources/MyTimeOffResource.php`

### CRM Configuration
- [ ] **Industry** - `Modules/Crm/src/Filament/Clusters/Configurations/Resources/IndustryResource.php`
- [ ] **Title** - `Modules/Crm/src/Filament/Clusters/Configurations/Resources/TitleResource.php`
- [ ] **Tag** - `Modules/Crm/src/Filament/Clusters/Configurations/Resources/TagResource.php`

### Marketing
- [ ] **UTMSource** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/UTMSourceResource.php`
- [ ] **UTMMedium** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/UTMMediumResource.php`
- [ ] **ActivityType** - `Modules/Core/src/Filament/Resources/ActivityTypeResource.php`
- [ ] **ActivityPlan** - `Modules/Core/src/Filament/Clusters/Configurations/Resources/ActivityPlanResource.php`

### Products Configuration
- [ ] **ProductAttribute** (various modules)
- [ ] **ProductCategory** (various modules)
- [ ] **OperationType** - `Modules/Products/src/Filament/Clusters/Configurations/Resources/OperationTypeResource.php`
- [ ] **PackageType** - `Modules/Products/src/Filament/Clusters/Configurations/Resources/PackageTypeResource.php`
- [ ] **Route** - `Modules/Products/src/Filament/Clusters/Configurations/Resources/RouteResource.php`
- [ ] **Rule** - `Modules/Products/src/Filament/Clusters/Configurations/Resources/RuleResource.php`
- [ ] **StorageCategory** - `Modules/Products/src/Filament/Clusters/Configurations/Resources/StorageCategoryResource.php`

### Projects Configuration
- [ ] **Milestone** - `Modules/Projects/src/Filament/Clusters/Configurations/Resources/MilestoneResource.php`
- [ ] **ProjectStage** - `Modules/Projects/src/Filament/Clusters/Configurations/Resources/ProjectStageResource.php`
- [ ] **TaskStage** - `Modules/Projects/src/Filament/Clusters/Configurations/Resources/TaskStageResource.php`
- [ ] **ActivityPlan** - `Modules/Projects/src/Filament/Clusters/Configurations/Resources/ActivityPlanResource.php`

### System/Admin
- [ ] **Plugin** - `Modules/Core/src/Filament/Resources/PluginResource.php`
- [ ] **Field** - `Modules/Core/src/Filament/Resources/FieldResource.php`
- [ ] **AccountTag** - `Modules/Core/src/Filament/Resources/AccountTagResource.php`
- [ ] **Post** - `Modules/Core/src/Filament/Admin/Resources/PostResource.php`

## Notes for AI Agents

When implementing tests for the remaining resources, follow these patterns:

1. **Setup Method**: Create necessary dependencies (User, Company, Currency, etc.)
2. **List Test**: Verify records appear in the table, test filtering if applicable
3. **Create Test**: Test modal form submission with required fields
4. **Update Test**: Test editing via table action
5. **Delete Test**: Test deletion (soft delete where applicable)

### Common Dependencies
Most resources require:
- User with `resource_permission = 'global'`
- Company with currency
- Module-specific models (Partner, Product, etc.)

### Table Names Pattern
- Partners: `partners_partners`
- Products: `products_products`
- Orders: `sales_orders` or `purchases_orders`
- Moves/Invoices: `accounts_moves`
- Payments: `accounts_account_payments`

### Resource Priority for Testing
1. **Financial**: Bill, CreditNote, Refund, Account, Journal
2. **Core Business**: Company, User, Employee, Team
3. **Sales/Purchase**: Quotation, Vendor, related orders
4. **CRM**: Partner management, Addresses, Banks
5. **Operations**: Warehouse, Delivery, Receipt, Operations
6. **Configuration**: Lower priority, but important for data integrity

### Test Execution
Run tests with:
```bash
php artisan test --filter=PaymentCrudTest
php artisan test --group=smoke
```
