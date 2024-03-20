<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\SmartMeter;
use App\Models\General;
use App\Models\DeviceType;
use App\Models\Entity;
use App\Models\Status;
use App\Models\AdminUser;




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
        $grid->column('general.NAME', __('General Name')); // Accede al atributo 'name' de la tabla 'General'

        $grid->column('GENERAL_ID', __('GENERAL ID'))->display(function ($generalId) {
            return $generalId;
        });
        $grid->column('ACA', __('ACA'));
        $grid->column('general.VERSION', __('VERSION')); 
        //$grid->column('general.OWNER', __('OWNER')); 

        $grid->column('general.OWNER', __('OWNER'))->display(function ($stateId) {
            // Busca el estado en la tabla Status usando el STATE_ID
            $status = Entity::find($stateId);
            
            // Verifica si se encontró un estado con el STATE_ID dado
            if ($status) {
                // Si se encontró, devuelve el estado
                return $status->ENTITY;
            } else {
                // Si no se encontró, devuelve un mensaje indicando que no se encontró el estado
                return 'No State Found';
            }
        });
        //$grid->column('general.STATE_ID', __('STATE')); 

        $grid->column('general.STATE_ID', __('STATE'))->display(function ($stateId) {
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

       //$grid->model()->where('ID', 1);


        $grid->column('general.RECEPTION_DATE', __('RECEPTION_DATE')); 
        //$grid->column('general.RECIPIENT', __('RECEIVER')); 
        //$grid->column('general.DEVICE_ID', __('DEVICE ID')); 

        $grid->column('general.RECIPIENT', __('RECEIVER'))->display(function ($stateId) {
            // Busca el estado en la tabla Status usando el STATE_ID
            $status = AdminUser::find($stateId);
            
            // Verifica si se encontró un estado con el STATE_ID dado
            if ($status) {
                // Si se encontró, devuelve el estado
                return $status->name;
            } else {
                // Si no se encontró, devuelve un mensaje indicando que no se encontró el estado
                return 'No State Found';
            }
        });


        $grid->column('general.DEVICE_ID', __('APPLICATION_PROTOCOL'))->display(function ($deviceId) {
            // Busca el dispositivo en la tabla DeviceType usando el ID
            $deviceType = DeviceType::find($deviceId);
        
            // Verifica si se encontró un dispositivo con el ID dado
            if ($deviceType) {
                // Si se encontró, devuelve el DEVICE_TYPE
                return $deviceType->APPLICATION_PROTOCOL;
            } else {
                // Si no se encontró, devuelve un mensaje indicando que no hay tipo de dispositivo
                return 'No Device Type';
            }
        });

        $grid->column('TYPOLOGY_ID', __('PHYSICAL_PROTOCOL'))->display(function ($deviceId) {
            // Busca el dispositivo en la tabla DeviceType usando el ID
            $deviceType = DeviceType::find($deviceId);
        
            // Verifica si se encontró un dispositivo con el ID dado
            if ($deviceType) {
                // Si se encontró, devuelve el DEVICE_TYPE
                return $deviceType->PHYSICAL_PROTOCOL;
            } else {
                // Si no se encontró, devuelve un mensaje indicando que no hay tipo de dispositivo
                return 'No Device Type';
            }
        });
        

        $grid->column('DEVICE_FAMILY_ID', __('DECICE FAMILY'))->display(function ($deviceId) {
            // Busca el dispositivo en la tabla DeviceType usando el ID
            $deviceType = DeviceType::find($deviceId);
        
            // Verifica si se encontró un dispositivo con el ID dado
            if ($deviceType) {
                // Si se encontró, devuelve el DEVICE_TYPE
                return $deviceType->FAMILY_SM;
            } else {
                // Si no se encontró, devuelve un mensaje indicando que no hay tipo de dispositivo
                return 'No Device Type';
            }
        });


        


        $grid->column('KW_CE', __('KW CE'));
        $grid->column('KR_CE', __('KR CE'));
        $grid->column('COMMUNICATION_ENC_RF_KEY', __('COMMUNICATION ENC RF KEY'));
        $grid->column('COMMISSIONING_ENC_RF_KEY', __('COMMISSIONING ENC RF KEY'));
        $grid->column('COMMUNICATION_AUTH_RF_KEY', __('COMMUNICATION AUTH RF KEY'));
        $grid->column('COMMISSIONING_AUTH_RF_KEY', __('COMMISSIONING AUTH RF KEY'));
        $grid->column('RF_MASTER_KEY', __('RF MASTER KEY'));
        $grid->column('SERIAL_NUMBER', __('SERIAL NUMBER'));

        $grid->column('general.url', __('SHAREPOINT URL'));


        $grid->filter(function ($filter) {
            $filter->disableIdFilter(); // Deshabilita el filtro para el campo de ID
            // Filtrar por nombre
            $filter->like('general.NAME', __('Name'))->placeholder(__('Search Name'));
            // Filtrar por número de serie
            $filter->like('general.SERIAL_NUMBER', __('Serial Number'))->placeholder(__('Search Serial Number'));
            // Filtrar por fecha de recepción
            // Filtrar por origen
            $filter->equal('general.ORIGIN', __('Origin'))->select(function () {
                // Obtener las entidades y filtrar las que no tienen valores numéricos en el campo COMPANY
                $entities = Entity::get()->filter(function ($entity) {
                    return !is_numeric($entity->COMPANY);
                })->pluck('general.COMPANY', 'ID')->prepend(__('Select Origin'), '');
                
                return $entities;
            });
            // Filtrar por receptor
            $filter->equal('general.RECIPIENT', __('Recipient'))->select(function () {
                return AdminUser::pluck('name', 'id')->prepend(__('Select Recipient'), '');
            });
            // Filtrar por estado
            $filter->equal('general.STATE_ID', __('State'))->select(function () {
                return Status::pluck('STATE', 'ID')->prepend(__('Select State'), '');
            });
            // Filtrar por ubicación
            $filter->like('general.LOCATION', __('Location'))->placeholder(__('Search Location'));
            // Filtrar por propietario
            $filter->equal('general.OWNER', __('Owner'))->select(function () {
                return Entity::pluck('ENTITY', 'ID')->prepend(__('Select Owner'), '');
            });
            // Filtrar por notas
            $filter->like('general.NOTES', __('Notes'))->placeholder(__('Search Notes'));
            // Filtrar por fecha de inserción
            // Filtrar por usuario que insertó
            $filter->equal('general.INSERTED_BY', __('Inserted By'))->select(function () {
                return AdminUser::pluck('name', 'id')->prepend(__('Select Inserted By'), '');
            });
            // Filtrar por fecha de modificación
            // Filtrar por usuario que modificó
            $filter->equal('general.MODIFIED_BY', __('Modified By'))->select(function () {
                return AdminUser::pluck('name', 'id')->prepend(__('Select Modified By'), '');
            });
            
            
            
            // Filtrar por versión
            $filter->like('general.VERSION', __('Version'))->placeholder(__('Search Version'));
            // Filtrar por visibilidad
            // Agrega más filtros según sea necesario
        });
        $grid->model()->whereHas('general', function ($query) {
            $query->where('STATE_ID', 1)->where('DEVICE_ID', 1);
        });
    


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
        $show->field('DEVICE_FADMILY_ID', __('DEVICE FAMILY ID'));
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
        $form->select('DEVICE_FAMILY_ID', __('DEVICE FAMILY ID'))->options(DeviceType::pluck('FAMILY_SM', 'ID'));
        $form->text('KW_CE', __('KW CE'));
        $form->text('KR_CE', __('KR CE'));
        $form->text('COMMUNICATION_ENC_RF_KEY', __('COMMUNICATION ENC RF KEY'));
        $form->text('COMMISSIONING_ENC_RF_KEY', __('COMMISSIONING ENC RF KEY'));
        $form->text('COMMUNICATION_AUTH_RF_KEY', __('COMMUNICATION AUTH RF KEY'));
        $form->text('COMMISSIONING_AUTH_RF_KEY', __('COMMISSIONING AUTH RF KEY'));
        $form->text('RF_MASTER_KEY', __('RF MASTER KEY'));
        $form->text('SERIAL_NUMBER', __('SERIAL NUMBER'));
        $form->number('TYPOLOGY_ID', __('TYPOLOGY ID'))->options(General::pluck('ID', 'id'));



        return $form;
    }
}