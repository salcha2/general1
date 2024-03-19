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
use App\Models\SmartMeter;

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

    $grid->column('TYPOLOGY_ID', __('TYPOLOGY'))->display(function ($deviceId) {
        // Busca el dispositivo en la tabla DeviceType usando el ID
        $deviceType = DeviceType::find($deviceId);
    
        // Verifica si se encontró un dispositivo con el ID dado
        if ($deviceType) {
            // Si se encontró, devuelve el DEVICE_TYPE
            return $deviceType->TYPOLOGY;
        } else {
            // Si no se encontró, devuelve un mensaje indicando que no hay tipo de dispositivo
            return 'No Device Type';
        }
    });


    $grid->column('STATE_ID', __('STATE'))->display(function ($stateId) {
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
    



    

    $grid->model()->with('device');

    // Resto de las columnas...

    $grid->column('recipientAdminUser.name', __('RECEIVER'));
    $grid->column('insertedByAdminUser.name', __('INSERTED BY'));
    $grid->column('modifiedByAdminUser.name', __('MODIFIED BY'));



    $grid->column('NAME', __('Name'));
    $grid->column('SERIAL_NUMBER', __('Serial Number'));
    $grid->column('RECEPTION_DATE', __('Reception Date'));
    $grid->column('LOCATION', __('Location'));
    $grid->column('QUANTITY', __('Quantity'));
    $grid->column('NOTES', __('Notes'));
    $grid->column('INSERTION_DATE', __('Insertion Date'));
    $grid->column('MODIFICATION_DATE', __('Modification Date'));
    $grid->column('VERSION', __('Version'));
$grid->column('url')->display(function ($url) {
    return "<a href=\"$url\" target=\"_blank\">$url</a>";
});

    $grid->column('VISIBLE', __('Visible'));

    $grid->filter(function ($filter) {
        $filter->disableIdFilter(); // Deshabilita el filtro para el campo de ID
        // Filtrar por nombre
        $filter->like('NAME', __('Name'))->placeholder(__('Search Name'));
        // Filtrar por número de serie
        $filter->like('SERIAL_NUMBER', __('Serial Number'))->placeholder(__('Search Serial Number'));
        // Filtrar por fecha de recepción
        // Filtrar por origen
        $filter->equal('ORIGIN', __('Origin'))->select(function () {
            // Obtener las entidades y filtrar las que no tienen valores numéricos en el campo COMPANY
            $entities = Entity::get()->filter(function ($entity) {
                return !is_numeric($entity->COMPANY);
            })->pluck('COMPANY', 'ID')->prepend(__('Select Origin'), '');
            
            return $entities;
        });
        // Filtrar por receptor
        $filter->equal('RECIPIENT', __('Recipient'))->select(function () {
            return AdminUser::pluck('name', 'id')->prepend(__('Select Recipient'), '');
        });
        // Filtrar por estado
        $filter->equal('STATE_ID', __('State'))->select(function () {
            return Status::pluck('STATE', 'ID')->prepend(__('Select State'), '');
        });
        // Filtrar por ubicación
        $filter->like('LOCATION', __('Location'))->placeholder(__('Search Location'));
        // Filtrar por propietario
        $filter->equal('OWNER', __('Owner'))->select(function () {
            return Entity::pluck('ENTITY', 'ID')->prepend(__('Select Owner'), '');
        });
        // Filtrar por notas
        $filter->like('NOTES', __('Notes'))->placeholder(__('Search Notes'));
        // Filtrar por fecha de inserción
        // Filtrar por usuario que insertó
        $filter->equal('INSERTED_BY', __('Inserted By'))->select(function () {
            return AdminUser::pluck('name', 'id')->prepend(__('Select Inserted By'), '');
        });
        // Filtrar por fecha de modificación
        // Filtrar por usuario que modificó
        $filter->equal('MODIFIED_BY', __('Modified By'))->select(function () {
            return AdminUser::pluck('name', 'id')->prepend(__('Select Modified By'), '');
        });
        
        
        
        // Filtrar por versión
        $filter->like('VERSION', __('Version'))->placeholder(__('Search Version'));
        // Filtrar por visibilidad
        // Agrega más filtros según sea necesario
    });
    
    

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
        $form->text('profile.ACA');
        $form->select('profile.DEVICE_FAMILY_ID', __('DEVICE FAMILY ID'))->options(DeviceType::pluck('FAMILY_SM', 'ID'));
         $form->text('profile.KW_CE', __('KW CE'));
         $form->text('profile.KR_CE', __('KR CE'));
         $form->text('profile.COMMUNICATION_ENC_RF_KEY', __('COMMUNICATION ENC RF KEY'));
         $form->text('profile.COMMISSIONING_ENC_RF_KEY', __('COMMISSIONING ENC RF KEY'));
         $form->text('profile.COMMUNICATION_AUTH_RF_KEY', __('COMMUNICATION AUTH RF KEY'));
         $form->text('profile.COMMISSIONING_AUTH_RF_KEY', __('COMMISSIONING AUTH RF KEY'));
         $form->text('profile.RF_MASTER_KEY', __('RF MASTER KEY'));

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
        $form->select('TYPOLOGY_ID', __('TYPOLOGY'))->options(DeviceType::pluck('TYPOLOGY', 'ID'));
        $form->text('url', __('URL'));
        $form->text('VERSION', __('Version'));

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



    /**
     * Método para cargar dinámicamente el segundo formulario
     * basado en la selección del primer formulario.
     *
     * @param Form $form
     * @return \Illuminate\Http\JsonResponse
     */
   public function loadSecondForm(Form $form)
   {
       // Obtén el valor seleccionado del primer formulario
       $selectedDeviceId = request('DEVICE_ID');

       // Lógica para cargar dinámicamente el segundo formulario
       $secondForm = $form->select('SECOND_DEVICE_ID', __('Second Device Type'))
           ->options(DeviceType::pluck('DEVICE_TYPE', 'ID'))
           ->where('DEVICE_ID', $selectedDeviceId)
           ->response();

       return response()->json($secondForm);
   }
}
