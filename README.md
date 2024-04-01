[![Packagist](https://img.shields.io/packagist/v/eboost/module-menu?style=for-the-badge)](https://packagist.org/packages/eboost/module-menu)
[![Packagist](https://img.shields.io/packagist/dt/eboost/module-menu?style=for-the-badge)](https://packagist.org/packages/eboost/module-menu)
[![Packagist](https://img.shields.io/packagist/dm/eboost/module-menu?style=for-the-badge)](https://packagist.org/packages/eboost/module-menu)

# Magento 2 Menu
Provides powerful menu editor to replace category based menus in Magento 2.

## Setup
1. Create new menu in the admin area `Content > Elements > Menus`.
2. Add new block to the layout, using the same ID as in the admin area.
```xml
<block name="block-name" class="EBoost\Menu\Block\Menu">
   <arguments>
      <argument name="menu" xsi:type="string">menu-id</argument>
   </arguments>
</block>
```
3. Use created block in the template
```php
<?= $block->getChildHtml('block-name') ?>
```

### This module doesn't provide ready to use UI
Out of the box this module is not compatible with any theme, but in the same time you can use it with any theme, although you need to take care of the styling on your own.
