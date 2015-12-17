<?php

namespace Concrete\Package\CommunityCkeditor\Controller\SinglePage\Dashboard\System\Basics\Editor;

use Concrete\Core\Page\Controller\DashboardPageController;
use Concrete\Package\CommunityCkeditor\Src\Utility\BackwardsCompatibilityUtility;

class CkeditorStyles extends DashboardPageController
{

    public function view($currentValue = null)
    {
        if ($currentValue !== null) {
            $this->set('styles', $currentValue);
        } else {
            $editor = \Core::make('editor');
            $this->set('styles', $editor->getStylesJson());
        }
    }

    public function saved()
    {
        $this->set('success', t('Styles saved successfully.'));
        $this->view();
    }

    public function submit()
    {
        $styles = $this->request->get('styles');
        if ($this->token->validate('submit')) {
            if ($this->validateStyles($styles, $this->error)) {
                \Package::getByHandle('community_ckeditor')->getConfig()->save('editor.styles', $styles);
                $this->redirect('/dashboard/system/basics/editor/ckeditor_styles', 'saved');
            }
        } else {
            $this->error->add($this->token->getErrorMessage());
        }
        $this->view($styles);
    }

    /**
     * @param string $styles
     * @param \Concrete\Core\Error\Error $error The error object for error messages to be added to
     * @return bool
     */
    protected function validateStyles($styles, &$error)
    {
        $startingCount = count($error->getList());
        $styles = json_decode($styles, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $error->add(
                t(
                    'You must save your styles in a valid JSON format: %s',
                    BackwardsCompatibilityUtility::json_last_error_msg()
                )
            );
            return false;
        }

        foreach ($styles as $style) {
            if (isset($style['name'])) {
                if (!isset($style['element']) && !isset($style['type']) && !isset($style['widget'])) {
                    $error->add(t('The following is not a valid style: %s', json_encode($style)));
                } elseif (isset($style['type']) && strtolower($style['type']) == 'widget') {
                    if (!isset($style['widget'])) {
                        $error->add(t('You must specify a "widget" attribute for %s', json_encode($style)));
                    }
                } elseif (isset($style['widget'])) {
                    if (!isset($style['type'])) {
                        $error->add(t('You must specify a "type" attribute for %s', json_encode($style)));
                    }
                }
            } else {
                $error->add(t('You must specify a "name" attribute for %s', json_encode($style)));
            }
        }

        return $startingCount === count($error->getList());
    }
}
