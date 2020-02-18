# Sylius Image Optimizer Plugin

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

Optimize the images in your Sylius store!

## Installation

### Step 1: Download the plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this plugin:

```bash
$ composer require setono/sylius-image-optimizer-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.


### Step 2: Enable the plugin

Then, enable the plugin by adding it to the list of registered plugins/bundles
in the `app/AppKernel.php` file of your project:

```php
<?php
// app/AppKernel.php

use Sylius\Bundle\CoreBundle\Application\Kernel;

final class AppKernel extends Kernel
{
    public function registerBundles(): array
    {
        return array_merge(parent::registerBundles(), [
            // ...
            new \Setono\SyliusImageOptimizerPlugin\SetonoSyliusImageOptimizerPlugin(),
            // ...
        ]);
    }
    
    // ...
}
```

### Step 4: Configure the plugin (optional)

By default, this plugin will optimize all images which are resources implementing the `Sylius\Component\Core\Model\ImageInterface`.

You can limit both the resources and the filter sets optimized:

```yaml
# config/packages/setono_sylius_image_optimizer.yaml

setono_sylius_image_optimizer:
    image_resources:
        sylius.product_image:
            - sylius_shop_product_large_thumbnail
            - sylius_shop_product_thumbnail
            - sylius_shop_product_small_thumbnail
            - sylius_shop_product_tiny_thumbnail
            - sylius_shop_product_original
```

### Step 5: Configure Symfony Messenger

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

[ico-version]: https://img.shields.io/packagist/v/setono/sylius-optimize-images-plugin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Setono/SyliusOptimizeImagesPlugin/master.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/SyliusOptimizeImagesPlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/sylius-optimize-images-plugin
[link-travis]: https://travis-ci.org/Setono/SyliusOptimizeImagesPlugin
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/SyliusOptimizeImagesPlugin
