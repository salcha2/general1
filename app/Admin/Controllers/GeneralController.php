<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\General;
use App\Models\DeviceType;
use App\Models\Entity;
use App\Models\AdminUser;
use App\Models\Status;

class GeneralController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'General';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new General());

        $grid->column('ID', __('ID'));
        $grid->column('device.DEVICE_TYPE', __('Device Type'));
        $grid->column('NAME', __('Name'));
        $grid->column('SERIAL_NUMBER', __('Serial Number'));
        $grid->column('RECEPTION_DATE', __('Reception Date'));
        $grid->column('originEntity.ENTITY', __('Origin'));
        $grid->column('recipientAdminUser.username', __('Recipient'));
        $grid->column('state.STATE', __('State'));
        $grid->column('LOCATION', __('Location'));
        $grid->column('ownerEntity.ENTITY', __('Owner'));
        $grid->column('QUANTITY', __('Quantity'));
        $grid->column('NOTES', __('Notes'));
        $grid->column('INSERTION_DATE', __('Insertion Date'));
        $grid->column('insertedByAdminUser.username', __('Inserted By'));
        $grid->column('MODIFICATION_DATE', __('Modification Date'));
        $grid->column('modifiedByAdminUser.username', __('Modified By'));
        $grid->column('VISIBLE', __('Visible'));

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
        $show = new Show(General::findOrFail($id));

        $show->field('ID', __('ID'));
        $show->field('device.DEVICE_TYPE', __('Device Type'));
        $show->field('NAME', __('Name'));
        $show->field('SERIAL_NUMBER', __('Serial Number'));
        $show->field('RECEPTION_DATE', __('Reception Date'));
        $show->field('originEntity.ENTITY', __('Origin'));
        $show->field('recipientAdminUser.username', __('Recipient'));
        $show->field('state.STATE', __('State'));
        $show->field('LOCATION', __('Location'));
        $show->field('ownerEntity.ENTITY', __('Owner'));
        $show->field('QUANTITY', __('Quantity'));
        $show->field('NOTES', __('Notes'));
        $show->field('INSERTION_DATE', __('Insertion Date'));
        $show->field('insertedByAdminUser.username', __('Inserted By'));
        $show->field('MODIFICATION_DATE', __('Modification Date'));
        $show->field('modifiedByAdminUser.username', __('Modified By'));
        $show->field('VISIBLE', __('Visible'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */

     protected function form()
     {
         $form = new Form(new General());
     
         $form->number('ID', __('ID'));
         $form->select('DEVICE_ID', __('Device Type'))->options(DeviceType::pluck('DEVICE_TYPE', 'ID'));
         $form->text('NAME', __('Name'));
         $form->text('SERIAL_NUMBER', __('Serial Number'));
         $form->date('RECEPTION_DATE', __('Reception Date'))->default(date('Y-m-d'));
         $form->select('ORIGIN', __('Origin'))->options(Entity::pluck('ENTITY', 'ID'));
         $form->select('RECIPIENT', __('Receiver'))->options(AdminUser::pluck('NAME', 'id'));         
         $form->select('STATE_ID', __('State'))->options(Status::pluck('STATE', 'ID'));

         $form->text('LOCATION', __('Location'));
         $form->select('OWNER', __('Owner'))->options(Entity::pluck('COMPANY', 'ID'));
         $form->number('QUANTITY', __('Quantity'));
         $form->text('NOTES', __('Notes'));
         $form->date('INSERTION_DATE', __('Insertion Date'))->default(date('Y-m-d'));
         $form->select('INSERTED_BY', __('INSERTED BY'))->options(AdminUser::pluck('NAME', 'id'));         

         $form->date('MODIFICATION_DATE', __('Modification Date'))->default(date('Y-m-d'));
         $form->select('MODIFIED_BY', __('MODIFIED BY'))->options(AdminUser::pluck('NAME', 'id'));         

         $form->switch('VISIBLE', __('Visible'));
     
         return $form;
     }
     



}
