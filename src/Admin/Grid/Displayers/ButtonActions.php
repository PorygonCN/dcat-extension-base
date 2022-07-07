<?php

namespace Porygon\Base\Admin\Grid\Displayers;

use Dcat\Admin\Grid\Displayers\Actions;
use Dcat\Admin\Support\Helper;

class ButtonActions extends Actions
{
    // protected $view = 'admin.grid.button-actions';
    /**
     * @return string
     */
    protected function getViewLabel()
    {
        $label = trans('admin.show');

        return "<button class='btn-sm btn'>{$label}</button>";
    }

    /**
     * @return string
     */
    protected function getEditLabel()
    {
        $label = trans('admin.edit');

        return "<button class='btn-sm btn'>{$label}</button>";
    }

    /**
     * @return string
     */
    protected function getQuickEditLabel()
    {
        $label = trans('admin.quick_edit');

        return "<button class='btn-sm btn'>{$label}</button>";
    }


    /**
     * @return string
     */
    protected function getDeleteLabel()
    {
        $label = trans('admin.delete');

        return "<button class='btn-sm btn'>{$label}</button>";
    }
}
