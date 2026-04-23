# 📦 Structure: Modules/Admission

```
Admission/
├── Actions
├── DTOs
├── Enums
├── Events
├── Http
│   └── Controllers
│       ├── AdmissionController.php
│       └── Api
│           └── AdmissionController.php
├── Jobs
├── Livewire
│   ├── Admin
│   │   └── Applications
│   │       ├── Form.php
│   │       └── Index.php
│   └── Public
│       └── RegistrationForm.php
├── Models
│   ├── Admission.php
│   ├── AdmissionApplication.php
│   ├── AdmissionCatalog.php
│   └── AdmissionLocation.php
├── Observers
├── Policies
├── Services
│   └── AdmissionService.php
├── config
│   ├── form.php
│   └── module.php
├── database
│   ├── factories
│   ├── migrations
│   │   ├── 2026_04_21_200716_create_locations_table.php
│   │   ├── 2026_04_21_200923_create_applications_table.php
│   │   └── 2026_04_21_202552_create_catalogs_table.php
│   └── seeders
│       ├── AdmissionCatalogSeeder.php
│       ├── AdmissionLocationSeeder.php
│       └── DatabaseSeeder.php
├── resources
│   ├── lang
│   └── views
│       ├── admission.blade.php
│       ├── components
│       │   └── placeholder.blade.php
│       ├── layouts
│       ├── livewire
│       │   ├── admin
│       │   │   └── applications
│       │   │       ├── form.blade.php
│       │   │       └── index.blade.php
│       │   ├── admission
│       │   │   ├── partials
│       │   │   │   ├── actions.blade.php
│       │   │   │   ├── error-summary.blade.php
│       │   │   │   ├── step-1-student.blade.php
│       │   │   │   ├── step-2-address.blade.php
│       │   │   │   ├── step-3-extra.blade.php
│       │   │   │   ├── step-4-parent.blade.php
│       │   │   │   ├── step-5-confirm.blade.php
│       │   │   │   └── stepper.blade.php
│       │   │   └── registration-form.blade.php
│       │   └── placeholder.blade.php
│       ├── pages
│       │   ├── admin
│       │   │   ├── create.blade.php
│       │   │   ├── edit.blade.php
│       │   │   └── index.blade.php
│       │   ├── index.blade.php
│       │   └── public
│       │       └── register.blade.php
│       ├── partials
│       └── pdf
│           └── registration.blade.php
├── routes
│   ├── api.php
│   └── web.php
└── structure.md
```
