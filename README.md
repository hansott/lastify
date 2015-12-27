# Lastify

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Lastify is a PHP library that syncs your top tracks on last.fm to a Spotify playlist. The library is fully unit tested.

## Install

Via Composer

``` bash
$ composer require hansott/lastify
```

## Usage

1. Generate a spotify access token: [Spotify Api Console](https://developer.spotify.com/web-api/console/get-current-user/) (OAuth Scope: playlist-read-private, playlist-modify-public & playlist-modify-private)
2. Find your spotify user id: [Get Current User's Profile](https://developer.spotify.com/web-api/console/get-current-user/)
3. Create a last.fm API account and copy the api key and api secret: [Create API account](http://www.last.fm/api/account/create) (Note: You cannot view your API account after creating.)

``` php
<?php

require_once __DIR__.'/../vendor/autoload.php';

use HansOtt\Lastify\Manager;
use HansOtt\Lastify\LastFm\LastFmConnection;
use HansOtt\Lastify\Spotify\SpotifyConnection;

$lastFmConnection = LastFmConnection::connect(
    'your last.fm username',
    'your last.fm api key',
    'your last.fm api secret'
);

$spotifyConnection = SpotifyConnection::connect(
    'your spotify user id',
    'your spotify access token'
);

$manager = new Manager($spotifyConnection, $lastFmConnection);
$manager->syncTopTracksToPlaylist('Top Tracks', 30);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email hansott@hotmail.be instead of using the issue tracker.

## Credits

- [Hans Ott][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/hansott/lastify.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/hansott/lastify/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/hansott/lastify.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/hansott/lastify.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/hansott/lastify.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/hansott/lastify
[link-travis]: https://travis-ci.org/hansott/lastify
[link-scrutinizer]: https://scrutinizer-ci.com/g/hansott/lastify/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/hansott/lastify
[link-downloads]: https://packagist.org/packages/hansott/lastify
[link-author]: https://github.com/hansott
[link-contributors]: ../../contributors
