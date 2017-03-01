<?php
/**
 * @see LICENCE
 */

namespace Dlambauer\WidgetImageUpload\Block\Adminhtml\Widget;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Widget\Button;
use \Magento\Framework\Data\Form\Element\AbstractElement as Element;
use \Magento\Backend\Block\Template\Context as TemplateContext;
use \Magento\Framework\Data\Form\Element\Factory as FormElementFactory;
use Magento\Framework\Data\Form\Element\Factory;
use Magento\Framework\Data\Form\Element\Text;

/**
 * Class ImageChooser
 * @package Dlambauer\WidgetImageUpload\Block\Adminhtml\Widget
 */
class ImageChooser extends Template
{
    /**
     * @var Factory
     */
    protected $_elementFactory;

    /**
     * @param TemplateContext $context
     * @param FormElementFactory $elementFactory
     * @param array $data
     */
    public function __construct(TemplateContext $context, FormElementFactory $elementFactory, $data = [])
    {
        $this->_elementFactory = $elementFactory;
        parent::__construct($context, $data);
    }

    /**
     * Prepare chooser element HTML
     *
     * @param Element $element
     * @return Element
     */
    public function prepareElementHtml(Element $element)
    {
        $config = $this->_getData('config');
        $sourceUrl = $this->getUrl('cms/wysiwyg_images/index',
            ['target_element_id' => $element->getId(), 'type' => 'file']);


        /**
         * @mod: Pass in media_path_only param.
         */

        /** @var \Magento\Backend\Block\Widget\Button $chooser */
        $chooser = $this->getLayout()->createBlock('Magento\Backend\Block\Widget\Button')
                        ->setType('button')
                        ->setClass('btn-chooser')
                        ->setLabel($config['button']['open'])
                        ->setOnClick('MediabrowserUtility.openDialog(\'' . $sourceUrl . '\', 0, 0, "MediaBrowser", { media_path_only: true })')
                        ->setDisabled($element->getReadonly());

        /** @var \Magento\Framework\Data\Form\Element\Text $input */
        $input = $this->_elementFactory->create("text", ['data' => $element->getData()]);
        $input->setId($element->getId());
        $input->setForm($element->getForm());
        $input->setClass("widget-option input-text admin__control-text");
        if ($element->getRequired()) {
            $input->addClass('required-entry');
        }

        /**
         * @mod: Overridden media browser utility open dialog function to pass new media_path_only param. Changed require
         * param to use our custom media browser which makes use of this param.
         */
        $element->setData('after_element_html', $input->getElementHtml()
            . $chooser->toHtml() . "<script>require(['Dlambauer_WidgetImageUpload/mage/mediabrowser', 'jquery'], function(browser, $) {
                        MediabrowserUtility.openDialog = function(url, width, height, title, options) {
            var windowId = this.windowId,
                content = '<div class=\"popup-window magento-message\" \"id=\"' + windowId + '\"></div>',
                self = this;

            if (this.modal) {
                this.modal.html($(content).html());
                this.modal.modal('option', 'closed', options.closed);
            } else {
                this.modal = $(content).modal($.extend({
                    title:  title || 'Insert File...',
                    modalClass: 'magento',
                    type: 'slide',
                    buttons: []
                }, options));
            }
            this.modal.modal('openModal');
            $.ajax({
                url: url,
                type: 'get',
                context: $(this),
                showLoader: true,
                data: {
                    media_path_only: options.media_path_only || false
                }
            }).done(function(data) {
                self.modal.html(data).trigger('contentUpdated');
            });
        };     
            });</script>");

        return $element;
    }
}