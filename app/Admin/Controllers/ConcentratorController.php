<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\Concentrator;

class ConcentratorController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Concentrator';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Concentrator());

        $grid->column('ID', __('ID'));
        $grid->column('GENERAL_ID', __('GENERAL ID'));
        $grid->column('ACA', __('ACA'));
        $grid->column('DEVICE_FAMILY_ID', __('DEVICE FAMILY ID'));
        $grid->column('PPP_USERNAME', __('PPP USERNAME'));
        $grid->column('PPP_PWD', __('PPP PWD'));
        $grid->column('LVC_MAA_USERNAME', __('LVC MAA USERNAME'));
        $grid->column('LVC_MAA_PWD', __('LVC MAA PWD'));
        $grid->column('ETH_RIGHT', __('ETH RIGHT'));
        $grid->column('MAC_ETH_RIGHT', __('MAC ETH RIGHT'));
        $grid->column('ETH_LEFT', __('ETH LEFT'));
        $grid->column('MAC_ETH_LEFT', __('MAC ETH LEFT'));
        $grid->column('SERIAL_NUMBER', __('SERIAL NUMBER'));
        $grid->column('TYPOLOGY_ID', __('TYPOLOGY'));


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Concentrator::findOrFail($id));

        $show->field('ID', __('ID'));
        $show->field('GENERAL_ID', __('GENERAL ID'));
        $show->field('ACA', __('ACA'));
        $show->field('DEVICE_FAMILY_ID', __('DEVICE FAMILY ID'));
        $show->field('PPP_USERNAME', __('PPP USERNAME'));
        $show->field('PPP_PWD', __('PPP PWD'));
        $show->field('LVC_MAA_USERNAME', __('LVC MAA USERNAME'));
        $show->field('LVC_MAA_PWD', __('LVC MAA PWD'));
        $show->field('ETH_RIGHT', __('ETH RIGHT'));
        $show->field('MAC_ETH_RIGHT', __('MAC ETH RIGHT'));
        $show->field('ETH_LEFT', __('ETH LEFT'));
        $show->field('MAC_ETH_LEFT', __('MAC ETH LEFT'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Concentrator());

        $form->number('GENERAL_ID', __('GENERAL ID'));
        $form->text('ACA', __('ACA'));
        $form->number('DEVICE_FAMILY_ID', __('DEVICE FAMILY ID'));
        $form->text('PPP_USERNAME', __('PPP USERNAME'));
        $form->text('PPP_PWD', __('PPP PWD'));
        $form->text('LVC_MAA_USERNAME', __('LVC MAA USERNAME'));
        $form->text('LVC_MAA_PWD', __('LVC MAA PWD'));
        $form->text('ETH_RIGHT', __('ETH RIGHT'));
        $form->text('MAC_ETH_RIGHT', __('MAC ETH RIGHT'));
        $form->text('ETH_LEFT', __('ETH LEFT'));
        $form->text('MAC_ETH_LEFT', __('MAC ETH LEFT'));
        $form->text('SERIAL_NUMBER', __('SERIAL NUMBER'));
        $form->number('TYPOLOGY_ID', __('TYPOLOGY ID'))->options(General::pluck('ID', 'id'));

        return $form;
    }
}
