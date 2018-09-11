# Sylius Optimize Images Plugin

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-travis]][link-travis]
[![Quality Score][ico-code-quality]][link-code-quality]

Optimize your images using [TinyPNG](https://tinypng.com/).

## Installation

### Step 1: Download TinyPNG bundle

Follow the [installation instructions for the TinyPNG bundle](https://github.com/Setono/TinyPngBundle).

### Step 2: Download the plugin

Open a command console, enter your project directory and execute the following command to download the latest stable version of this plugin:

```bash
$ composer require setono/sylius-optimize-images-plugin
```

This command requires you to have Composer installed globally, as explained in the [installation chapter](https://getcomposer.org/doc/00-intro.md) of the Composer documentation.


### Step 3: Enable the plugin

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
            new \Setono\SyliusOptimizeImagesPlugin\SetonoSyliusOptimizeImagesPlugin(),
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
# app/config/config.yml

setono_sylius_optimize_images:
    resources:
        - sylius.product_image
    filter_sets:
        - sylius_shop_product_large_thumbnail
        - sylius_shop_product_thumbnail
        - sylius_shop_product_small_thumbnail
        - sylius_shop_product_tiny_thumbnail
        - sylius_shop_product_original
```

### Step 5: Enable asynchronously processing (optional)

The default Sylius shop will process images on demand. Using this plugin means that images will be sent to TinyPNG and back on demand. This can take quite some time, therefore it is highly recommended to enable the [async processing of images](https://symfony.com/doc/2.0/bundles/LiipImagineBundle/resolve-cache-images-in-background.html).

If you enable that, all you need to do is run the optimize command:
```bash
$ php bin/console setono:sylius-optimize-images:optimize
```

[ico-version]: https://img.shields.io/packagist/v/setono/sylius-optimize-images-plugin.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/Setono/SyliusOptimizeImagesPlugin/master.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/SyliusOptimizeImagesPlugin.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/setono/sylius-optimize-images-plugin
[link-travis]: https://travis-ci.org/Setono/SyliusOptimizeImagesPlugin
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/SyliusOptimizeImagesPlugin