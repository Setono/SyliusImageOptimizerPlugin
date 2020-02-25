# Sylius Image Optimizer Plugin

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Quality Score][ico-code-quality]][link-code-quality]

Optimize the images in your Sylius store! Works only with [kraken.io](https://kraken.io) at the moment, but will work with other vendors in the future.

Have you seen this message from Google page speed tools: ["Serve images in next-gen formats"](https://web.dev/uses-webp-images/), this is the plugin to use.

It will **both** optimize your jpegs, but also convert them to webp and serve the webp images to browsers that [support webp](https://developers.google.com/speed/webp/faq#which_web_browsers_natively_support_webp) (i.e. Chrome).

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

Make sure you add it before `SyliusGridBundle`, otherwise you'll get
`You have requested a non-existent parameter "setono_sylius_image_optimizer.model.savings.class".` exception.

```php
<?php
# config/bundles.php

return [
    // ...
    Setono\SyliusImageOptimizerPlugin\SetonoSyliusImageOptimizerPlugin::class => ['all' => true],
    Sylius\Bundle\GridBundle\SyliusGridBundle::class => ['all' => true],
    // ...
];

```

### Step 3: Configure the plugin

Add the resources (image resources) that should be optimized. In the example below a product image is optimized and the
filter sets that are optimized are the default frontend filter sets for products.

This is also the step where you need your API key and secret from [kraken.io](https://kraken.io).

```text
# .env.local
KRAKEN_API_KEY=YOUR API KEY
KRAKEN_API_SECRET=YOUR API SECRET
```

```yaml
# config/packages/setono_kraken_io.yaml
setono_kraken_io:
    api_key: "%env(resolve:KRAKEN_API_KEY)%"
    api_secret: "%env(resolve:KRAKEN_API_SECRET)%"
```

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
        kraken:
            key: "%env(resolve:KRAKEN_API_KEY)%"
            secret: "%env(resolve:KRAKEN_API_SECRET)%"
```

```yaml
# config/routes/setono_sylius_image_optimizer.yaml
setono_sylius_image_optimizer:
    resource: "@SetonoSyliusImageOptimizerPlugin/Resources/config/routes.yaml"
```

### Step 4: Configure Symfony Messenger

If you haven't used [Symfony Messenger](https://symfony.com/doc/current/messenger.html) before, you need to specify a default bus like so:

```yaml
# config/packages/messenger.yaml

framework:
    messenger:
        default_bus: setono_sylius_image_optimizer.command_bus
```

#### Step 4.1: Using asynchronous transport (optional, but recommended)
               
All commands in this plugin will extend the [CommandInterface](src/Message/Command/CommandInterface.php).
Therefore you can route all commands easily by adding this to your [Messenger config](https://symfony.com/doc/current/messenger.html#routing-messages-to-a-transport):

```yaml
# config/packages/messenger.yaml
framework:
   messenger:
       routing:
           # Route all command messages to the async transport
           # This presumes that you have already set up an 'async' transport
           'Setono\SyliusImageOptimizerPlugin\Message\Command\CommandInterface': async
```

### Step 5: Extend image resources

The following example is for the product images. You should follow this procedure for all image resources you want to optimize.

```php
<?php
// src/Entity/Product/ProductImage.php
declare(strict_types=1);

namespace App\Entity\Product;

use Doctrine\ORM\Mapping as ORM;
use Setono\SyliusImageOptimizerPlugin\Model\OptimizableInterface;
use Setono\SyliusImageOptimizerPlugin\Model\OptimizableTrait;
use Sylius\Component\Core\Model\ProductImage as BaseProductImage;

/**
 * @ORM\Table(name="sylius_product_image")
 * @ORM\Entity()
 */
final class ProductImage extends BaseProductImage implements OptimizableInterface
{
    use OptimizableTrait;
}
```

```yaml
# config/packages/_sylius.yaml

sylius_core:
    resources:
        product_image:
            classes:
                model: App\Entity\Product\ProductImage
```

### Step 6: Update database

Last step is to create a diff for your current database schema and migrate that schema.

```
$ php bin/console doctrine:migrations:diff
$ php bin/console doctrine:migrations:migrate
```

## Usage

Now run this command to optimize your images:

```
$ php bin/console setono:sylius-image-optimizer:optimize
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
[ico-code-quality]: https://img.shields.io/scrutinizer/g/Setono/SyliusImageOptimizerPlugin.svg

[link-packagist]: https://packagist.org/packages/setono/sylius-image-optimizer-plugin
[link-github-actions]: https://github.com/Setono/SyliusImageOptimizerPlugin/actions
[link-code-quality]: https://scrutinizer-ci.com/g/Setono/SyliusImageOptimizerPlugin
