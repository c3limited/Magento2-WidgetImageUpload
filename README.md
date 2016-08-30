# Magento2-Widget-ImageUpload

## Introduction
This module provides a simple Image Uploader for Widgets based on the Gist from [@cedricblondeau](https://gist.github.com/cedricblondeau/6174911fb4bba6cb4943). 

![alt text](/doc/images/20150825_widget_imageUploader.png "Screenshot of the Image Upload")


## Installation

`composer require dlambauer/magento2-module-backend-widget-imageupload`

## Add an Image
To add an Image, you have to add a parameter like this in your widget.xml: 

```xml
<parameter name="insert_a_meaningfull_name" xsi:type="block" required="true" visible="true" sort_order="10">
    <label translate="true">Insert a Label here</label>
    <description translate="true">Add a great Description</description>
    
    <block class="Dlambauer\WidgetImageUpload\Block\Adminhtml\Widget\ImageChooser">
        <data>
            <item name="button" xsi:type="array">
                <item name="open" xsi:type="string">Choose Image...</item>
            </item>
        </data>
    </block>
</parameter>
```

## ToDo

* Add Unit and Integration Tests
* Require the JS Component more pretty, so we can remove the plain html script-tag from the block

## Requirements

- PHP >= 5.5.0

## Support
If you encounter any problems or bugs, please create an issue on [GitHub](https://github.com/firegento/firegento-magesetup2/issues).

## Contribution
Any contribution to the development of this Module is highly welcome. The best possibility to provide any code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

## Licence

[GNU General Public License, version 3 (GPLv3)](http://opensource.org/licenses/gpl-3.0)

Copyright
---------
(c) 2015 David Lambauer
