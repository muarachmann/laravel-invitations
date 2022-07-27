# Laravel Invitations

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![CI](https://github.com/muarachmann/laravel-invitations/actions/workflows/run-tests.yml/badge.svg?branch=master)](https://github.com/muarachmann/laravel-invitations/actions/workflows/run-tests.yml)

This is where your description should go. Take a look at [contributing.md](contributing.md) to see a to do list.

## Installation

Via Composer

``` bash
$ composer require muarachmann/laravel-invitations
```

## Usage

After installing the laravel Invite Codes package, register the service provider in your `config/app.php` file:

> Optional in Laravel 5.5 or above

```php
'providers' => [
    MuaRachmann\Invitations\InvitationServiceProvider::class,
    MuaRachmann\Invitations\InvitationEventServiceProvider::class,
];
```

### Configuring the package

You can publish the config file with:
This is the contents of the file that will be published at config/laravel-invitations.php:

```bash
php artisan vendor:publish --provider="MuaRachmann\Invitations\InvitationServiceProvider" --tag="laravel-invitations-config"
```


Run migrations required for this package. If you need to customize the tables, you can [configure them](#configuring-the-package) with:

```bash
php artisan vendor:publish --provider="MuaRachmann\Invitations\InvitationServiceProvider" --tag="laravel-invitations-migrations"
```

### Events

***Laravel Invitations*** comes with several events [events](https://laravel.com/docs/master/events) by default

*  MuaRachmann\Invitations\Events\InvitationAccepted
*  MuaRachmann\Invitations\Events\InvitationDeclined
*  MuaRachmann\Invitations\Events\InvitationExpired
*  MuaRachmann\Invitations\Events\InvitationSent

These events have the `invitation` model so you can listen to these events and take approriate actions e.g send welcome email.

include listener in `EventServiceProvider.php`

```php
use MuaRachmann\Invitations\Events\InvitationAccepted;
use App\Listeners\SendWelcomeEmail;

protected $listen = [
    InvitationAccepted::class => [
        SendWelcomeEmail::class,
    ],
];
```
`SendWelcomeEmail.php`

```php
public function handle($invitation)
{
    // send welcome email to user
}
```


## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email muarachmann@gmail.com instead of using the issue tracker.

## Credits

- [Mua Rachmann][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/muarachmann/laravel-invitations.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/muarachmann/laravel-invitations.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/muarachmann/laravel-invitations/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/muarachmann/laravel-invitations
[link-downloads]: https://packagist.org/packages/muarachmann/laravel-invitations
[link-travis]: https://travis-ci.org/muarachmann/laravel-invitations
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/muarachmann
[link-contributors]: ../../contributors
