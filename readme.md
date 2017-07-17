# Subscribed by ![flagrow logo](https://avatars0.githubusercontent.com/u/16413865?v=3&s=15) [flagrow](https://discuss.flarum.org/d/1832-flagrow-extension-developer-group)

[![Support on patreon](https://img.shields.io/badge/support%20on-patreon-orange.svg)](https://patreon.com/flagrow) [![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](https://raw.githubusercontent.com/flagrow/subscribed/license.md) [![Latest Stable Version](https://img.shields.io/packagist/v/flagrow/subscribed.svg)](https://github.com/flagrow/subscribed) [![Total Downloads](https://img.shields.io/packagist/dt/flagrow/subscribed.svg)](https://github.com/flagrow/subscribed)

Adds additional subscriptions to specific events and allows enforcing them.

### installation

```bash
composer require flagrow/subscribed
```

### updating

```bash
composer update flagrow/subscribed
php flarum cache:clear
```

### configuration

Enable the extension. Visit the subscribed tab in the admin to configure subscriptions. 

### links

- [changelog](https://github.com/flagrow/subscribed/blob/master/changelog.md)
- [on github](https://github.com/flagrow/subscribed)
- [on packagist](http://packagist.com/packages/flagrow/subscribed)
- [issues](https://github.com/flagrow/subscribed/issues)


An extension by [Flagrow](https://flagrow.io), a project of [Gravure](https://gravure.io).

### faq

- In case you've used [the solution by anthonyrossbach](https://discuss.flarum.org/d/5179-enable-all-email-notifications-upon-registration/6), you have to undo
the added trigger:
```sql
DROP TRIGGER `users_insert`;
```
