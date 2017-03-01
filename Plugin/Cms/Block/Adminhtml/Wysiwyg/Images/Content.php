<?php

namespace Dlambauer\WidgetImageUpload\Plugin\Cms\Block\Adminhtml\Wysiwyg\Images;

class Content
{
    /**
     * @mod: After plugin to param on file browser setup object. This gets called when having loaded in the content
     * for the modal and is used for the setup of the media browser. This param is used within mediabrowser.js to send
     * to the OnInsert action the param. Which then uses it to decide whether or not to return a directive or media path.
     *
     * @param $subject
     * @param $result
     * @return mixed|string|void
     */
    public function afterGetFilebrowserSetupObject($subject, $result)
    {
        $newResult = json_decode($result);
        $newResult->media_path_only = (bool)$subject->getRequest()->getParam('media_path_only', false);
        return json_encode($newResult);
    }
}