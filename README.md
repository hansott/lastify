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
2. Create a last.fm API account and copy the api key: [Create API account](http://www.last.fm/api/account/create) (Note: You cannot view your API account after creating.)

``` php
<?php

error_reporting(-1);
ini_set('display_errors', 'On');

require_once __DIR__.'/../vendor/autoload.php';

use HansOtt\Lastify\Services\LastFm;
use HansOtt\Lastify\Services\Spotify;
use HansOtt\Lastify\Synchronizer;
use HansOtt\Lastify\TrackInfo;

$lastFm = LastFm::connect('41678989bddf3a05eef72c583c0f8bd1');
$spotify = Spotify::connect('BQDhjl-V4_qx1OKKasWU85DrJ23s0pLPvQbRPXLYuJV-JikIBBEc_qo-PW4zHQbcc9QfEe770RDuDp4Yy5vthX93VbGUc-LZ-41voO5uMNsqlgvOD5KVbQuX6yKutZ0YbrFZQIQ0EotBw37tjIhxHi0PiervtgZWlNkBH6po2p89W3SJtIbImOtUoZPyb9BRbPIIJ7i1kZcKUOI7IOLav4sqUQtWQ9t3pfSwjqdjLHfhslYr-aQVxEwss_keVNyBCjBl-s929dPnF3RGie-VoHB2p0tDDuxqEdVlGQNtbE0U2w');

$synchronizer = new Synchronizer($spotify);
$topTracks = $lastFm->getTopTracks('hansott', 20);

$onUpdate = function($current, $total, TrackInfo $track) {
    echo sprintf("[%s/%s] Syncing %s \n", $current, $total, $track->toString());
};

$synchronizer->syncToPlaylist('Top Tracks', $topTracks, $onUpdate);
```

```sh
~/Code/lastify master $ php examples/syncTopTracks.php
[1/20] Syncing This Is the Life - Amy Macdonald
[2/20] Syncing Banquet - Bloc Party
[3/20] Syncing The Passenger - Iggy Pop
[4/20] Syncing A Forest - The Cure
[5/20] Syncing Not Alone - Time
[6/20] Syncing Somebody Told Me - The Killers
[7/20] Syncing This Modern Love - Bloc Party
[8/20] Syncing Ex's & Oh's - Elle King
[9/20] Syncing Octopus - Bloc Party
[10/20] Syncing Ratchet - Bloc Party
[11/20] Syncing Comptine d'un autre été, l'après-midi - Yann Tiersen
[12/20] Syncing Soft Spoken Words - Trixie Whitley
[13/20] Syncing Back to Black - Amy Winehouse
[14/20] Syncing Pocket Piano - DJ Mehdi
[15/20] Syncing Lucky Boy - DJ Mehdi
[16/20] Syncing Starblazer - Deetron
[17/20] Syncing Wappy Flirt - Original Mix - Hi-Lo
[18/20] Syncing Signatune (Thomas Bangalter edit) - DJ Mehdi
[19/20] Syncing Slowly - Festival Mix - Dropout
[20/20] Syncing The Aviating - Alec Troniq
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
