# Boring Avatars

![License](https://img.shields.io/badge/license-MIT-blue.svg) [![Latest Stable Version](https://img.shields.io/packagist/v/ianm/boring-avatars.svg)](https://packagist.org/packages/ianm/boring-avatars) [![Total Downloads](https://img.shields.io/packagist/dt/ianm/boring-avatars.svg)](https://packagist.org/packages/ianm/boring-avatars)

A [Flarum](http://flarum.org) extension. Replace default Flarum avatars with Boring Avatars.

## About

Utilize generated "Boring Avatars" on your Flarum forum, without compromising your user privacy. It is a PHP port of the [React based Boring Avatars](https://github.com/boringdesigners/boring-avatars)

## Features

- Choose from 6 themes + plus an exclusive animated version of the "ring" theme
- Customize the color palette used
- Completely self contained, no external calls are required
- Multiple identifier configuration (Select from ID, username or email address to generate unique avatars)
- SVG avatars, which are directly included in the user object - no additional network requests to retrieve avatars
- Automatically updates the avatar if the identifier changes
- Supports GDPR export, anonymization, deletion

## Screenshots

### Bauhaus
![bauhaus](https://github.com/imorland/flarum-ext-boring-avatars/assets/16573496/36db7a2a-43f8-4e54-85c6-0d983e40a3e6)

### Beam
![beam](https://github.com/imorland/flarum-ext-boring-avatars/assets/16573496/a2716645-2230-426d-af77-6f492485b626)

### Marble
![marble](https://github.com/imorland/flarum-ext-boring-avatars/assets/16573496/00268553-37e0-4b3a-9e80-e9a40ea5681d)

### Pixel
![pixel](https://github.com/imorland/flarum-ext-boring-avatars/assets/16573496/042bb78d-50fd-4500-a4a7-fcb1e721133e)

### Ring
![ring](https://github.com/imorland/flarum-ext-boring-avatars/assets/16573496/4840353d-204b-46fc-b6dd-27df2b47d9dc)

### Sunset
![sunset](https://github.com/imorland/flarum-ext-boring-avatars/assets/16573496/4554b185-ecc2-4185-93cf-75c426baad5f)

### Settings
![settings](https://github.com/imorland/flarum-ext-boring-avatars/assets/16573496/05b70f55-31f0-4aee-852a-6344ae37630f)

## Usage

When first enabled, a background task will be dispatched which will begin generating avatars for all of your users. Needless to say, if you have 100's of thousands of users, this could take a few minutes!

Want to make changes to the generation settings? No problem, once the settings are changed, another background task will run to update the avatars.

This extension is best used alongside a queue, especially when the forum has a large number of users.

An API endpoint is also available to directly retrieve the avatar for a user:

```
/api/users/[id]/boring-avatar
```

this will return the SVG image file for the given user.

## Installation

Install with composer:

```sh
composer require ianm/boring-avatars:"*"
```

## Updating

```sh
composer update ianm/boring-avatars:"*"
php flarum migrate
php flarum cache:clear
```

## Links

- [Packagist](https://packagist.org/packages/ianm/boring-avatars)
- [GitHub](https://github.com/ianm/boring-avatars)
- [Discuss](https://discuss.flarum.org/d/33989)
- [Extension Icon](https://source.boringavatars.com/beam/30/Flarum%20Boring%20Avatar?square)

## Support

Please consider supporting my extension development and maintenance work.

[![Buy Me A Coffee](https://cdn.buymeacoffee.com/buttons/default-orange.png)](https://www.buymeacoffee.com/ianm1)
