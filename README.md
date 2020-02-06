# Laravel Scope Checks

Automatically convert your Eloquent scopes to boolean check methods.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/beyondcode/laravel-scope-checks.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-scope-checks)
[![Build Status](https://img.shields.io/travis/beyondcode/laravel-scope-checks/master.svg?style=flat-square)](https://travis-ci.org/beyondcode/laravel-scope-checks)
[![Quality Score](https://img.shields.io/scrutinizer/g/beyondcode/laravel-scope-checks.svg?style=flat-square)](https://scrutinizer-ci.com/g/beyondcode/laravel-scope-checks)
[![Total Downloads](https://img.shields.io/packagist/dt/beyondcode/laravel-scope-checks.svg?style=flat-square)](https://packagist.org/packages/beyondcode/laravel-scope-checks)

This package allows you to automatically call all your eloquent model scope methods as checks.

```php
class User extends Model
{
    use HasScopeChecks;
    
    public function scopeActive($query)
    {
        $query->where('active', true);
    }
    
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}

// Now you can call your scope check using:
$user->isActive();
```

## Installation

You can install the package via composer:

```bash
composer require beyondcode/laravel-scope-checks
```

## Usage

All you need to do to be able to call your scopes as check methods is add the `HasScopeChecks` trait to your eloquent model.

```php
use \BeyondCode\LaravelScopeChecks\HasScopeChecks;

class Post {
    use HasScopeChecks;
    
    public function scopePublished($query)
    {
        return $query->where('active', 1);
    }
    
    public function scopeMinimumRating($query, $rating = 5)
    {
        return $query->where('rating', '>=', $rating);
    }
}
```

You can either call your check methods using the `is` or the `has` naming prefix on your model instances. For example:

```php
$post->isPublished();
$post->hasMinimumRating();
```

When you make use of dynamic scopes (like the `scopeRating` method), you can also pass the additional scope parameters to the check methods:

```php
$post->isMinimumRating(1);
$post->hasMinimumRating(1);
```
 

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email marcel@beyondco.de instead of using the issue tracker.

## Credits

- [Marcel Pociot](https://github.com/mpociot)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
