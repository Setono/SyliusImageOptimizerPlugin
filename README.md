# Sylius Image Optimizer Plugin

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Quality Score][ico-code-quality]][link-code-quality]

Optimize the images in your Sylius store! Works only with [kraken.io](https://kraken.io) at the moment, but will work with other vendors in the future.

## Installation

### Step 1: Download the plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this plugin:

```bash
$ composer require setono/sylius-image-optimizer-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.


### Step 2: Enable the plugin

Then, enable the plugin by adding it to the list of registered plugins/bundles
in the `config/bundles.php` file of your project:

```php
<?php
# config/bundles.php

return [
    // ...
    Setono\SyliusImageOptimizerPlugin\SetonoSyliusImageOptimizerPlugin::class => ['all' => true],
    // ...
];

```

### Step 3: Configure the plugin

Add the resources (image resources) that should be optimized. In the example below a product image is optimized and the
filter sets that are optimized are the default frontend filter sets for products.

```yaml
# config/packages/setono_sylius_image_optimizer.yaml
imports:
    - { resource: "@SetonoSyliusPickupPointPlugin/Resources/config/app/config.yaml" }

setono_sylius_image_optimizer:
    image_resources:
        sylius.product_image:
            - sylius_shop_product_large_thumbnail
            - sylius_shop_product_thumbnail
            - sylius_shop_product_small_thumbnail
            - sylius_shop_product_tiny_thumbnail
            - sylius_shop_product_original
```

### Step 4: Configure Symfony Messenger

If you haven't used [Symfony Messenger](https://symfony.com/doc/current/messenger.html) before, you need to specify a default bus like so:

```yaml
# config/packages/messenger.yaml

framework:
    messenger:
        default_bus: setono_sylius_image_optimizer.command_bus
```

## Testing

If you want to test this plugin you can setup [ngrok](https://ngrok.com) to tunnel requests to your localhost:

1. [Download and install](https://ngrok.com/download) ngrok
2. Run your local web server: `symfony serve --allow-http` (the `allow-http` is important since ngrok always tunnels to the non secure localhost)
3. Run ngrok: `ngrok http 8000`

[ico-version]: https://poser.pugx.org/setono/sylius-image-optimizer-plugin/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/sylius-image-optimizer-plugin/v/unstable
[ico-license]: https://poser.pugx.org/setono/sylius-image-optimizer-plugin/license
[ico-github-actions]: https://github.com/Setono/SyliusImageOptimizerPlugin/workflows/build/badge.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/SyliusImageOptimizerPlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/sylius-image-optimizer-plugin
[link-github-actions]: https://github.com/Setono/SyliusImageOptimizerPlugin/actions
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/SyliusImageOptimizerPlugin
