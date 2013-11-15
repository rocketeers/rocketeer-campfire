# Campfire for Rocketeer

Sends a basic deployment message : **Just deployed branch {branch} on {stage}@{server}** to a Campfire room.

To setup to `composer require anahkiasen/rocketeer-campfire:dev-master`. Then you'll need to set it up, so do `artisan config:publish anahkiasen/rocketeer-campfire` and complete the configuration in `app/packages/anahkiasen/rocketeer-campfire/config.php`.

Once that's done add the following to your providers array in `app/config/app.php` :

```php
'Rocketeer\Plugins\RocketeerCampfireServiceProvider',
```

And that's pretty much it.