<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\Pending;
use App\Models\DeviceType;
use App\Models\Entity;
use App\Models\General;

use App\Models\Status;
use OpenAdmin\Admin\Form;


class PendingController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Pending';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new General());

        $grid->column('ID', __('ID'));
        $grid->column('ORIGIN', __('ORIGIN'))->display(function ($entityId) {
            // Buscar la entidad en la tabla Entity usando el ENTITY_ID
            $entity = Entity::find($entityId);
            
            // Verificar si se encontró una entidad con el ENTITY_ID dado
            if ($entity) {
                // Si se encontró, devuelve el nombre de la entidad
                return $entity->ENTITY;
            } else {
                // Si no se encontró, devuelve un mensaje indicando que no se encontró la entidad
                return 'No Entity Found';
            }
        });
        $grid->column('DEVICE_ID', __('Device Type'))->display(function ($deviceId) {
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


        $grid->column('STATE_ID', __('State'))->display(function ($stateId) {
            // Busca el estado en la tabla Status usando el STATE_ID
            $status = Status::find($stateId);
            
            // Verifica si se encontró un estado con el STATE_ID dado
            if ($status) {
                // Si se encontró, devuelve el estado
                return $status->STATE;
            } else {
                // Si no se encontró, devuelve un mensaje indicando que no se encontró el estado
                return 'No State Found';
            }
        });

        $grid->column('QUANTITY', __('Quantity'));
        $grid->column('NOTES', __('Details'));


        $grid->model()->where('STATE_ID', 11);


        
        
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
        $show = new Show(Pending::findOrFail($id));

        $show->field('ID', __('ID'));
        $show->field('ENTITY_ID', __('Entity ID'));
        $show->field('TYPE', __('Type'));
        $show->field('QUANTITY', __('Quantity'));
        $show->field('DETAILS', __('Details'));
        $show->field('DSO', __('DSO'));

        return $show;
    }



    protected function form()
{
    $form = new Form(new General());
    $form->select('DEVICE_ID', __('DEVICE TYPE'))->options(DeviceType::pluck('DEVICE_TYPE', 'ID'));
    $form->text('NOTES', __('Notes'));
    $form->text('QUANTITY', __('Quantity'));
    $form->select('ORIGIN', __('Origin'))->options(Entity::pluck('ENTITY', 'ID'));

    //$form->text('smart.NAME', __('NAME'));

    $form->select('STATE_ID', __('Status'))->options([
        '1' => 'Installed',
        '2' => 'Lent',
        '3' => 'Not Installed',
        '4' => 'Unknown',
        '8' => 'Panel 1 Borbolla',
        '9' => 'Panel 1 Cartuja',
        '10' => 'Panel 2 Cartuja',
        '11' => 'Pending',
    ])->when('3', function (Form $form) {
        // Define los campos específicos del medidor (Meter)
        $form->text('NAME', __('Name'));
        $form->select('DEVICE_ID', __('Device id'))->options(DeviceType::pluck('ID', 'ID'));

        //$form->text('smart.DEVICE_ID', __('DEVICE_ID'));

        $form->text('SERIAL_NUMBER', __('Serial Number'));
        $form->text('RECEPTION_DATE', __('Reception Date'));
        $form->text('ORIGIN', __('Origin'));
        $form->text('RECIPIENT', __('Recipient'));
        $form->text('STATE_ID', __('State ID'));
        $form->text('LOCATION', __('Location'));
        $form->text('OWNER', __('Owner'));
        $form->text('INSERTED_BY', __('Inserted By'));
        $form->text('MODIFIED_BY', __('Modified By'));
        $form->text('VERSION', __('Version'));
        $form->text('VISIBLE', __('Visible'));
        $form->text('url', __('URL'));


        $form->hidden('GENERAL_ID'); // Este campo es oculto en el formulario


        
        
        


    });


    //$form->text('smart.NAME', __('Name'));

    return $form;
}
}