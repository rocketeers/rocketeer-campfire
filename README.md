# Campfire for Rocketeer

Sends a basic deployment message to a Campfire room :

![Campfire](http://i.imgur.com/iIzpvyr.png)

## Installation

```shell
rocketeer plugin:install anahkiasen/rocketeer-campfire
```

Then add this to the `plugins.loaded` array in your configuration:

```php
<?php
'loaded' => [
    'Rocketeer\Plugins\Campfire\RocketeerCampfire',
],
```

## Usage

To export the configuration, simply run `rocketeer plugin:config` then edit `.rocketeer/config/plugins/rocketeer-campfire`.