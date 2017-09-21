# Subscribed by ![Flagrow logo](https://avatars0.githubusercontent.com/u/16413865?v=3&s=20) [Flagrow](https://discuss.flarum.org/d/1832-flagrow-extension-developer-group), a project of [Gravure](https://gravure.io/)

[![MIT license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/flagrow/subscribed/blob/master/LICENSE.md) [![Latest Stable Version](https://img.shields.io/packagist/v/flagrow/subscribed.svg)](https://packagist.org/packages/flagrow/subscribed) [![Total Downloads](https://img.shields.io/packagist/dt/flagrow/subscribed.svg)](https://packagist.org/packages/flagrow/subscribed) [![Donate](https://img.shields.io/badge/patreon-support-yellow.svg)](https://www.patreon.com/flagrow) [![Join our Discord server](https://discordapp.com/api/guilds/240489109041315840/embed.png)](https://flagrow.io/join-discord)

Adds additional subscriptions to specific events.

## Installation

Use [Bazaar](https://discuss.flarum.org/d/5151-flagrow-bazaar-the-extension-marketplace) or install manually:

```bash
composer require flagrow/subscribed --prefer-dist --no-dev -o
```

## Updating

```bash
composer update flagrow/subscribed --prefer-dist --no-dev -o
php flarum cache:clear
```

## Configuration

Enable the extension. Visit the permissions tab in the admin to configure who can enable subscriptions to specific
events. 

## Support our work

We prefer to keep our work available to everyone.
In order to do so we rely on voluntary contributions on [Patreon](https://www.patreon.com/flagrow).

## Security

If you discover a security vulnerability within Subscribed, please send an email to the Gravure team at security@gravure.io. All security vulnerabilities will be promptly addressed.

Please include as many details as possible. You can use `php flarum info` to get the PHP, Flarum and extension versions installed.

## Links

- [Flarum Discuss post](https://discuss.flarum.org/d/6460-flagrow-subscribed-additional-event-subscriptions)
- [Source code on GitHub](https://github.com/flagrow/subscribed)
- [Changelog](https://github.com/flagrow/subscribed/blob/master/CHANGELOG.md)
- [Report an issue](https://github.com/flagrow/subscribed/issues)
- [Download via Packagist](https://packagist.org/packages/flagrow/subscribed)

An extension by [Flagrow](https://flagrow.io/), a project of [Gravure](https://gravure.io/).
