# Subscribed by FriendsOfFlarum

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/fof/subscribed.svg)](https://packagist.org/packages/fof/subscribed) [![OpenCollective](https://img.shields.io/badge/opencollective-fof-blue.svg)](https://opencollective.com/fof/donate)

A [Flarum](http://flarum.org) extension. Adds additional subscriptions to specific events.

### Available Notifications (User Settings)
- Someone creates a discussion
- Someone authors a new post
- When someone registers
- A created post needs approval

### Available Events
- **New Discussion**
  - {username} created a new discussion
- **New Post**
  - {username} authored a new post
- **New User**
  - {username} had just signed up
- **Post Unapproved**
  - {username} created a post that requires approval

### Available Permissions
- Allowed to receive notification upon new discussion
- Allowed to receive notification upon new post
- Allowed to receive notification upon new user
- Allowed to receive notification upon new unapproved post

### Installation

Install manually with composer:

```sh
composer require fof/subscribed:"*"
```

### Updating

```sh
composer update fof/subscribed
```

### Links

- [Packagist](https://packagist.org/packages/fof/subscribed)
- [GitHub](https://github.com/FriendsOfFlarum/subscribed)

[![OpenCollective](https://img.shields.io/badge/donate-friendsofflarum-44AEE5?style=for-the-badge&logo=open-collective)](https://opencollective.com/fof/donate)

An extension by [FriendsOfFlarum](https://github.com/FriendsOfFlarum).
