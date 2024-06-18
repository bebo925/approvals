# Laravel Approvals

Approval workflow package

## Installation

You can install the package via composer:

```bash
composer require bebo925/approvals
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="approvals-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="approvals-config"
```

This is the contents of the published config file:

```php
return [
];
```

Add `HasApprovals` trait to models that can have approval flows
Add `CanApprove` to the User model

## Usage

Create approval steps for models

```php
ApprovalStep::create([
    "approvable_class" => "App\Models\SomeModelThatWillHaveApprovalFlow"
])
->users()
->sync([$userIds]);
```

Get approval steps with users

```php
   $steps = MyModel::approvalSteps();
```

Generate approval steps with model that has the trait `HasApprovals`

```php
$myModel->generateApprovals();
```

Get approvals with required users for current model

```php
$order->with(["approvals.users"])->get();
```

Approve Step

```php
$approval->approve();
```

Reject Step

```php
$approval->reject();
```

Determine if model is approved

```php
$myModel->isApproved();
```

Determine if model contains a rejected status

```php
$myModel->isRejected();
```

Determined of models have pending approvals

```php
MyModel::withExists("pendingApprovals")->get();
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [Ryan McQuerry](https://github.com/bebo925)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
