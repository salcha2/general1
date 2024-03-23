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
use Illuminate\Http\Request; // Importa la clase Request



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
            // Obtener el modelo General usando el ID de la URL
            $id = request()->segment(3);
            $general = General::findOrFail($id);
    
            // Obtener la cantidad del modelo General
            $quantity = $general->QUANTITY ?? 1;
    
            for ($i = 0; $i < $quantity; $i++) {
                // Crear un subformulario para cada iteración
                $form->fieldset('Basic info ' . ($i + 1), function ($form) use ($i) {
                    $form->text('NAME['.$i.']', __('Name'));
                    $form->text('DEVICE_ID['.$i.']', __('Device id'));
                    $form->text('SERIAL_NUMBER['.$i.']', __('Serial Number'));
                    $form->text('RECEPTION_DATE['.$i.']', __('Reception Date'));
                    $form->text('ORIGIN['.$i.']', __('Origin'));
                    $form->text('RECIPIENT['.$i.']', __('Recipient'));
                    $form->select('STATE_ID['.$i.']', __('State ID'))->options([
                        '1' => 'Installed',
                        '2' => 'Lent',
                        '3' => 'Not Installed',
                        '4' => 'Unknown',
                        '8' => 'Panel 1 Borbolla',
                        '9' => 'Panel 1 Cartuja',
                        '10' => 'Panel 2 Cartuja',
                        '11' => 'Pending',
                    ]);
                    $form->text('LOCATION['.$i.']', __('Location'));
                    $form->text('OWNER['.$i.']', __('Owner'));
                    $form->text('INSERTED_BY['.$i.']', __('Inserted By'));
                    $form->text('MODIFIED_BY['.$i.']', __('Modified By'));
                    $form->text('VERSION['.$i.']', __('Version'));
                    $form->text('VISIBLE['.$i.']', __('Visible'));
                    $form->text('url['.$i.']', __('URL'));
                });
            }
    
            $form->saving(function (Form $form) use ($quantity) {
                // Guardar múltiples registros dependiendo de la cantidad especificada
                for ($i = 0; $i < $quantity; $i++) {
                    // Crear una nueva instancia de General para cada iteración
                    $general = new General();
            
                    // Asignar los datos específicos del formulario a la instancia de General
                    $general->DEVICE_ID = $form->input('DEVICE_ID.' . $i);
                    $general->NAME = $form->input('NAME.' . $i);
                    $general->SERIAL_NUMBER = $form->input('SERIAL_NUMBER.' . $i);
                    $general->RECEPTION_DATE = $form->input('RECEPTION_DATE.' . $i);
                    $general->ORIGIN = $form->input('ORIGIN.' . $i);
                    $general->RECIPIENT = $form->input('RECIPIENT.' . $i);
                    $general->STATE_ID = $form->input('STATE_ID.' . $i);
                    $general->LOCATION = $form->input('LOCATION.' . $i);
                    $general->OWNER = $form->input('OWNER.' . $i);
                    $general->INSERTED_BY = $form->input('INSERTED_BY.' . $i);
                    $general->MODIFIED_BY = $form->input('MODIFIED_BY.' . $i);
                    $general->VERSION = $form->input('VERSION.' . $i);
                    $general->VISIBLE = $form->input('VISIBLE.' . $i);
                    $general->url = $form->input('url.' . $i);
            
                    // Guardar la instancia de General
                    $general->save();
                }
            });
            
    
            return $form;
        });
    
        return $form;
    }
    


}
