<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Layout\Content;

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

use Illuminate\Http\Request; // Asegúrate de importar Illuminate\Http\Request


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
    // Consulta para cargar la relación 'device'
    // Consulta para cargar la relación 'device' y obtener el DEVICE_TYPE


    $grid->column('DEVICE_ID', __('DECICE TYPE'))->display(function ($deviceId) {
        // Busca el dispositivo en la tabla DeviceType usando el ID
        $deviceType = DeviceType::find($deviceId);
    
        // Verifica si se encontró un dispositivo con el ID dado
        if ($deviceType) {
            // Si se encontró, devuelve el DEVICE_TYPE
            return $deviceType->DEVICE_TYPE;
        } else {
            // Si no se encontró, devuelve un mensaje indicando que no hay tipo de dispositivo
            return 'No Device Type';
        }
    });


    
    // Resto de las columnas...

    $grid->column('ORIGIN', __('Origin'))->display(function ($originId) {
        // Busca la entidad en la tabla Entity usando el ID de ORIGIN
        $entity = Entity::find($originId);
        
        // Verifica si se encontró una entidad con el ID dado
        if ($entity) {
            // Si se encontró, devuelve el valor de COMPANY
            return $entity->COMPANY;
        } else {
            // Si no se encontró, devuelve un mensaje indicando que no se pudo obtener la compañía
            return 'Unknown Company';
        }
    });



    $grid->column('OWNER', __('Owner'))->display(function ($ownerId) {
        // Busca la entidad en la tabla Entity usando el ID de OWNER
        $entity = Entity::find($ownerId);
        
        // Verifica si se encontró una entidad con el ID dado
        if ($entity) {
            // Si se encontró, devuelve el valor de ENTITY
            return $entity->ENTITY;
        } else {
            // Si no se encontró, devuelve un mensaje indicando que no se pudo obtener la entidad
            return 'Unknown Entity';
        }
    });


    $grid->column('device.TYPOLOGY', __('TYPOLOGY'));

    

    $grid->model()->with('device');

    // Resto de las columnas...

    $grid->column('recipientAdminUser.username', __('RECEIVER'));
    $grid->column('ownerEntity.COMPANY', __('COMPANY'));

    $grid->column('NAME', __('Name'));
    $grid->column('SERIAL_NUMBER', __('Serial Number'));
    $grid->column('RECEPTION_DATE', __('Reception Date'));
    $grid->column('LOCATION', __('Location'));
    $grid->column('QUANTITY', __('Quantity'));
    $grid->column('NOTES', __('Notes'));
    $grid->column('INSERTION_DATE', __('Insertion Date'));
    $grid->column('MODIFICATION_DATE', __('Modification Date'));
    $grid->column('VERSION', __('Version'));
    $grid->column('VISIBLE', __('Visible'));

    return $grid;
}

    /**
     * Make a form builder.
     * @param mixed $id
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new General());
      
        $form->number('ID', __('ID'))->readonly(); // Hacer que el campo de ID sea de solo lectura
        $form->select('DEVICE_ID', __('Device Type'))->options(DeviceType::pluck('DEVICE_TYPE', 'ID'));
        $form->text('NAME', __('Name'));
        $form->text('SERIAL_NUMBER', __('Serial Number'));
        $form->date('RECEPTION_DATE', __('Reception Date'));
        $form->select('ORIGIN', __('Origin'))->options(Entity::pluck('ENTITY', 'ID'));
        $form->select('RECIPIENT', __('Receiver'))->options(AdminUser::pluck('NAME', 'id'));         
        $form->select('STATE_ID', __('State'))->options(Status::pluck('STATE', 'ID'));
        $form->text('LOCATION', __('Location'));
        $form->select('OWNER', __('Owner'))->options(Entity::pluck('COMPANY', 'ID'));
        $form->number('QUANTITY', __('Quantity'));
        $form->text('NOTES', __('Notes'));
        $form->date('INSERTION_DATE', __('Insertion Date'));
        $form->select('INSERTED_BY', __('INSERTED BY'))->options(AdminUser::pluck('NAME', 'id'));         
        $form->date('MODIFICATION_DATE', __('Modification Date'));
        $form->select('MODIFIED_BY', __('MODIFIED BY'))->options(AdminUser::pluck('NAME', 'id'));         
        $form->text('VERSION', __('Version'));
        $form->select('DEVICE_ID', __('TYPOLOGY'))->options(DeviceType::pluck('TYPOLOGY', 'ID'));

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
        $show = new Show(General::findOrFail($id));

        $show->field('ID', __('ID'));
        $show->field('NAME', __('Name'));
        $show->field('SERIAL_NUMBER', __('Serial Number'));
        $show->field('RECEPTION_DATE', __('Reception Date'));
        $show->field('entity', __('Origin'));
        $show->field('LOCATION', __('Location'));
        $show->field('company', __('Owner'));
        $show->field('QUANTITY', __('Quantity'));
        $show->field('NOTES', __('Notes'));
        $show->field('INSERTION_DATE', __('Insertion Date'));
        $show->field('MODIFICATION_DATE', __('Modification Date'));
        $show->field('VERSION', __('Version'));
        $show->field('VISIBLE', __('Visible'));

        return $show;
    }
}
