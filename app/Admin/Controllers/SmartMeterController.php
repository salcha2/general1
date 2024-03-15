<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\SmartMeter;
use App\Models\General;
use App\Models\DeviceType;

class SmartMeterController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'SmartMeter';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SmartMeter());

        $grid->column('ID', __('ID'));
        $grid->column('GENERAL_ID', __('GENERAL ID'))->display(function ($generalId) {
            return $generalId;
        });
        $grid->column('ACA', __('ACA'));
        $grid->column('FAMILY_SM', __('DEVICE FAMILY ID'))->display(function ($familySm) {
            return $familySm;
        });
        $grid->column('KW_CE', __('KW CE'));
        $grid->column('KR_CE', __('KR CE'));
        $grid->column('COMMUNICATION_ENC_RF_KEY', __('COMMUNICATION ENC RF KEY'));
        $grid->column('COMMISSIONING_ENC_RF_KEY', __('COMMISSIONING ENC RF KEY'));
        $grid->column('COMMUNICATION_AUTH_RF_KEY', __('COMMUNICATION AUTH RF KEY'));
        $grid->column('COMMISSIONING_AUTH_RF_KEY', __('COMMISSIONING AUTH RF KEY'));
        $grid->column('RF_MASTER_KEY', __('RF MASTER KEY'));

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
        $show = new Show(SmartMeter::findOrFail($id));

        $show->field('ID', __('ID'));
        $show->field('GENERAL_ID', __('GENERAL ID'));
        $show->field('ACA', __('ACA'));
        $show->field('FAMILY_SM', __('DEVICE FAMILY ID'));
        $show->field('KW_CE', __('KW CE'));
        $show->field('KR_CE', __('KR CE'));
        $show->field('COMMUNICATION_ENC_RF_KEY', __('COMMUNICATION ENC RF KEY'));
        $show->field('COMMISSIONING_ENC_RF_KEY', __('COMMISSIONING ENC RF KEY'));
        $show->field('COMMUNICATION_AUTH_RF_KEY', __('COMMUNICATION AUTH RF KEY'));
        $show->field('COMMISSIONING_AUTH_RF_KEY', __('COMMISSIONING AUTH RF KEY'));
        $show->field('RF_MASTER_KEY', __('RF MASTER KEY'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new SmartMeter());

        $form->number('GENERAL_ID', __('GENERAL ID'))->options(General::pluck('ID', 'id'));
        $form->text('ACA', __('ACA'));
        $form->select('FAMILY_SM', __('DEVICE FAMILY ID'))->options(DeviceType::pluck('FAMILY_SM', 'ID'));
        $form->text('KW_CE', __('KW CE'));
        $form->text('KR_CE', __('KR CE'));
        $form->text('COMMUNICATION_ENC_RF_KEY', __('COMMUNICATION ENC RF KEY'));
        $form->text('COMMISSIONING_ENC_RF_KEY', __('COMMISSIONING ENC RF KEY'));
        $form->text('COMMUNICATION_AUTH_RF_KEY', __('COMMUNICATION AUTH RF KEY'));
        $form->text('COMMISSIONING_AUTH_RF_KEY', __('COMMISSIONING AUTH RF KEY'));
        $form->text('RF_MASTER_KEY', __('RF MASTER KEY'));

        return $form;
    }
}
