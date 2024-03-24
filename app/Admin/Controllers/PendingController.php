<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\Pending;
use App\Models\DeviceType;
use App\Models\Entity;
use App\Models\General;
use App\Models\AdminUser;


use App\Models\Status;
use OpenAdmin\Admin\Form;
use Illuminate\Http\Request; // Importa la clase Request

use Illuminate\Support\Facades\Auth;


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
                    $form->select('DEVICE_ID['.$i.']', __('Device type'))->options([
                        '1' => 'Meter',
                        '3' => 'Field Tool',
                        '4' => 'RF Antenna',
                        '5' => 'LVC',
                        '6' => 'Probe',
                        '7' => 'Router',
                        '8' => 'Module',
                        '9' => 'Other',
                        '10' => 'Wire',
                        '36' => 'QED',
                    ]);            
                    $form->text('SERIAL_NUMBER['.$i.']', __('Serial Number'));
                    $form->date('RECEPTION_DATE['.$i.']', __('Reception Date'));
                    $form->select('ORIGIN['.$i.']', __('Origin'))->options([
                        '1' =>	'Brazil (Latam)',
                        '2' =>	'Chile (Latam)',
                        '3' =>	'Delgaz (Romania)',
                        '4' =>	'Endesa (Spain)',
                        '5' =>	'GSP (Iberia)',
                        '6'  =>	'GSP (Italy)',
                        '7'  =>	'NA',
                        '8'  =>	'Retele (Romania)',
                        '9' =>	'Viesgo (Spain)',
                    ]); 

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
                    //$form->text('OWNER['.$i.']', __('Owner'))->options(Entity::pluck('COMPANY', 'ID'));
                    $form->select('OWNER['.$i.']', __('Owner'))->options([
                        '1' => 'NA',
                        '3' => 'GSP-MOS-DO-EU-TSOP',
                        '4' => 'Endesa',
                        '5' => 'GSP-MOS-DO-EU-TSOP',
                        '6' => 'Italy',
                        '8' => 'Retele',
                     

                    ]);

                    $user = Auth::user();

        // Si el usuario está autenticado, establece automáticamente el usuario en el campo MODIFIED_BY
        if ($user) {
            $form->hidden('MODIFIED_BY['.$i.']', __('MODIFIED BY'))->default($user->id);
        }
            
        if ($user) {
            $form->hidden('INSERTED_BY['.$i.']', __('INSERTED BY'))->default($user->id);
        } 

        if ($user) {
            $form->text('RECIPIENT['.$i.']', __('RECEIVER'))->default($user->id);
        } 
                    //$form->text('INSERTED_BY['.$i.']', __('Inserted By'));
                    //$form->text('MODIFIED_BY['.$i.']', __('Modified By'));
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
                    $general->DEVICE_ID = $form->input('DEVICE_ID.' . $i)[0]; // Obtener el primer elemento de la matriz
                    $general->NAME = $form->input('NAME.' . $i);
                    $general->SERIAL_NUMBER = $form->input('SERIAL_NUMBER.' . $i);
                    $general->RECEPTION_DATE = $form->input('RECEPTION_DATE.' . $i);
                    $general->ORIGIN = $form->input('ORIGIN.' . $i)[0]; // Obtener el primer elemento de la matriz
                    $general->RECIPIENT = $form->input('RECIPIENT.' . $i);
                    $general->STATE_ID = $form->input('STATE_ID.' . $i)[0]; // Obtener el primer elemento de la matriz
                    $general->LOCATION = $form->input('LOCATION.' . $i);
                    $general->OWNER = $form->input('OWNER.' . $i)[0]; // Obtener el primer elemento de la matriz
                    $general->INSERTED_BY = $form->input('INSERTED_BY.' . $i);
                    $general->MODIFIED_BY = $form->input('MODIFIED_BY.' . $i);
                    $general->VERSION = $form->input('VERSION.' . $i);
                    $general->VISIBLE = $form->input('VISIBLE.' . $i);
                    $general->url = $form->input('url.' . $i);
            
                    // Guardar la instancia de General
                    $general->save();
                }



                return redirect('/admin/pending');



            });
            
    
            return $form;
        });
    
        return $form;
    }
    


}
