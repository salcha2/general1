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
use App\Models\GeneralView;


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
        $grid = new Grid(new GeneralView());

        $grid->column('ID', __('ID'));
         // Consulta para cargar la relación 'device'
        // Consulta para cargar la relación 'device' y obtener el DEVICE_TYPE
        $grid->column('device_type', __('Device Type'));

        $grid->column('NAME', __('Name'));
        $grid->column('SERIAL_NUMBER', __('Serial Number'));
        $grid->column('RECEPTION_DATE', __('Reception Date'));
        $grid->column('entity', __('Origin'));
        $grid->column('reciver', __('Recipient'));
        $grid->column('state', __('State'));
        $grid->column('LOCATION', __('Location'));
        $grid->column('company', __('Owner'));
        $grid->column('QUANTITY', __('Quantity'));
        $grid->column('NOTES', __('Notes'));
        $grid->column('INSERTION_DATE', __('Insertion Date'));
        $grid->column('inserted_B', __('Inserted By'));
        $grid->column('MODIFICATION_DATE', __('Modification Date'));
        $grid->column('modified_B', __('Modified By'));
        $grid->column('VISIBLE', __('Visible'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */

     
    

    /**
     * Make a form builder.
     * @param mixed $id
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
     

      /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
{
    $detail = GeneralView::findOrFail($id);
    return view('vendor.admin.show.general_detail', compact('detail'));

}



//public function edit($id)
//{
   // Encuentra el registro que se va a editar
 //  $general = General::findOrFail($id);

   // Retorna la vista de edición junto con los datos del registro
   //return view('vendor.admin.edit', compact('general'));
//}





}