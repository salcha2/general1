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
use App\Models\Concentrator;
use App\Models\Company;


use Illuminate\Support\Facades\Auth;



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


    
    // Resto de las columnas...

    $grid->column('ORIGIN', __('Origin'))->display(function ($originId) {
        // Busca la entidad en la tabla Entity usando el ID de ORIGIN
        $entity = Entity::find($originId);
        
        // Verifica si se encontró una entidad con el ID dado
        if ($entity) {
            // Si se encontró, devuelve el valor de ENTITY
            return $entity->ENTITY;
        } else {
            // Si no se encontró, devuelve un mensaje indicando que no se pudo obtener la compañía
            return 'Unknown Company';
        }
    });

 // Busca la entidad en la tabla Entity usando el ID de OWNER


    $grid->column('OWNER', __('Owner'))->display(function ($ownerId) {
        // Busca la entidad en la tabla Entity usando el ID de ORIGIN
        $entity = Company::find($ownerId);
        
        // Verifica si se encontró una entidad con el ID dado
        if ($entity) {
            // Si se encontró, devuelve el valor de COMPANY
            return $entity->COMPANY;
        } else {
            // Si no se encontró, devuelve un mensaje indicando que no se pudo obtener la entidad
            return 'Unknown Entity';
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
    
    $grid->model()->whereNotIn('STATE_ID', [8, 1])->with('device');



    

    $grid->model()->with('device');

    // Resto de las columnas...

    $grid->column('recipientAdminUser.name', __('Receiver'));
    $grid->column('insertedByAdminUser.name', __('Inserted by'));
    $grid->column('modifiedByAdminUser.name', __('Modified by'));



    $grid->column('NAME', __('Name'));
    $grid->column('SERIAL_NUMBER', __('Serial number'));
    $grid->column('RECEPTION_DATE', __('Reception date'));
    $grid->column('LOCATION', __('Location'));
    //$grid->column('QUANTITY', __('Quantity'));
    $grid->column('NOTES', __('Notes'));
    $grid->column('created_at', __('Insertion date'))->display(function ($createdAt) {
        return (new \DateTime($createdAt))->format('Y-m-d H:i:s');
    });
    $grid->column('updated_at', __('Modification date'))->display(function ($updated_at) {
        return (new \DateTime($updated_at))->format('Y-m-d H:i:s');
    });
    
    //$grid->column('updated_at', __('Modification Date'));
    $grid->column('VERSION', __('Version'));
$grid->column('url', __('Sharepoint url'))->display(function ($url) {
    return "<a href=\"$url\" target=\"_blank\">$url</a>";
});








    
$grid->filter(function($filter) {
    $filter->where(function ($query) {
        $query->whereHas('device', function ($query) {
            $query->where('DEVICE_TYPE', 'like', "%{$this->input}%");
        })->orWhere('SERIAL_NUMBER', 'like', "%{$this->input}%")
          ->orWhere('NAME', 'like', "%{$this->input}%")
          ->orWhere('LOCATION', 'like', "%{$this->input}%")
          ->orWhere('VERSION', 'like', "%{$this->input}%");
    }, 'Search ');



    $filter->disableIdFilter();


});



        
//$grid->expandFilter();

    
    $grid->model()->whereNotIn('STATE_ID', [11]);
       

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
        //$form->select('DEVICE_ID', __('Device Type'))->options(DeviceType::pluck('DEVICE_TYPE', 'ID'));
        $form->select('DEVICE_ID', __('Device type'))->options([
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
        ])->rules('required')->when('1', function (Form $form) {
            // Define los campos específicos del medidor (Meter)
            $form->text('profile.ACA', __('ADCE'))->help('Enter ADCE value here');
            $form->select('profile.DEVICE_FAMILY_ID', __('Device family'))->options(DeviceType::pluck('FAMILY_SM', 'ID'))->help('Select device family');
            $form->text('profile.KW_CE', __('KW CE'))->help('Enter KW CE value here');
            $form->text('profile.KR_CE', __('KR CE'))->help('Enter KR CE value here');
            $form->text('profile.COMMUNICATION_ENC_RF_KEY', __('COMMUNICATION ENC RF KEY'))->help('Enter communication ENC RF key here');
            $form->text('profile.COMMISSIONING_ENC_RF_KEY', __('COMMISSIONING ENC RF KEY'))->help('Enter commissioning ENC RF key here');
            $form->text('profile.COMMUNICATION_AUTH_RF_KEY', __('COMMUNICATION AUTH RF KEY'))->help('Enter communication AUTH RF key here');
            $form->text('profile.COMMISSIONING_AUTH_RF_KEY', __('COMMISSIONING AUTH RF KEY'))->help('Enter commissioning AUTH RF key here');
            $form->text('profile.RF_MASTER_KEY', __('RF MASTER KEY'))->help('Enter RF master key here');
            $form->html('<link rel="stylesheet" href="'.asset('css/style.css').'">');
        })->when('5', function (Form $form) {
            // Define los campos específicos del tipo LVC
            $form->text('smart.ACA', __('ACA'));
            $form->select('smart.DEVICE_FAMILY_ID', __('Device family'))->options(DeviceType::pluck('FAMILY_LVC', 'ID'));
            $form->text('smart.PPP_USERNAME', __('PPP username'));
            $form->text('smart.PPP_PWD', __('PPP pass'));
            $form->text('smart.LVC_MAA_USERNAME', __('LVC MAA USERNAME'));
            $form->text('smart.LVC_MAA_PWD', __('LVC MAA PWD'));
            $form->text('smart.ETH_RIGHT', __('ETH RIGHT'));
            $form->text('smart.MAC_ETH_RIGHT', __('MAC ETH RIGHT'));
            $form->text('smart.ETH_LEFT', __('ETH LEFT'));
            $form->text('smart.MAC_ETH_LEFT', __('MAC ETH LEFT'));
        })->when('36', function (Form $form) {
            // Define los campos específicos del tipo LVC
            $form->text('smart.ACA', __('ACA'));
            $form->select('smart.DEVICE_FAMILY_ID', __('Device family'))->options(DeviceType::pluck('FAMILY_LVC', 'ID'));
            $form->text('smart.PPP_USERNAME', __('PPP username'));
            $form->text('smart.PPP_PWD', __('PPP pass'));
            $form->text('smart.LVC_MAA_USERNAME', __('LVC MAA USERNAME'));
            $form->text('smart.LVC_MAA_PWD', __('LVC MAA PWD'));
            $form->text('smart.ETH_RIGHT', __('ETH RIGHT'));
            $form->text('smart.MAC_ETH_RIGHT', __('MAC ETH RIGHT'));
            $form->text('smart.ETH_LEFT', __('ETH LEFT'));
            $form->text('smart.MAC_ETH_LEFT', __('MAC ETH LEFT'));
        });
        
        

       
        
        
//         $options = DeviceType::pluck('APPLICATION_PROTOCOL', 'ID')->unique();
// $form->select(
//     'generales.APPLICATION_PROTOCOL',
//     __('APPLICATION PROTOCOL')
// )->options($options);

        
        
        
        
        

        

        $form->text('NAME', __('Name'));

        $form->text('SERIAL_NUMBER', __('Serial number'))->rules('required|min:3');
        $form->date('RECEPTION_DATE', __('Reception date'))->rules('required|min:3');
        $form->select('ORIGIN', __('Origin'))->options(Entity::pluck('ENTITY', 'ID'))->rules('required');

        // Sección de perfil
    // $form->fieldset('Profile', function ($form) {
    //     $form->text('profile.ACA')->help('Enter ACA value here');
    //     $form->select('profile.DEVICE_FAMILY_ID', __('DEVICE FAMILY ID'))->options(DeviceType::pluck('FAMILY_SM', 'ID'))->help('Select device family');
    //     $form->text('profile.KW_CE', __('KW CE'))->help('Enter KW CE value here');
    //     $form->text('profile.KR_CE', __('KR CE'))->help('Enter KR CE value here');
    //     $form->text('profile.COMMUNICATION_ENC_RF_KEY', __('COMMUNICATION ENC RF KEY'))->help('Enter communication ENC RF key here');
    //     $form->text('profile.COMMISSIONING_ENC_RF_KEY', __('COMMISSIONING ENC RF KEY'))->help('Enter commissioning ENC RF key here');
    //     $form->text('profile.COMMUNICATION_AUTH_RF_KEY', __('COMMUNICATION AUTH RF KEY'))->help('Enter communication AUTH RF key here');
    //     $form->text('profile.COMMISSIONING_AUTH_RF_KEY', __('COMMISSIONING AUTH RF KEY'))->help('Enter commissioning AUTH RF key here');
    //     $form->text('profile.RF_MASTER_KEY', __('RF MASTER KEY'))->help('Enter RF master key here');
    //     $form->html('<link rel="stylesheet" href="'.asset('css/style.css').'">');

    // });
    


        $form->select('RECIPIENT', __('Receiver'))->options(AdminUser::pluck('NAME', 'id'))->rules('required');         
        //$form->select('STATE_ID', __('State'))->options(Status::pluck('STATE', 'ID'));
        $form->select('STATE_ID', __('State'))->options([
            '1' => 'Installed',
            '2' => 'Lent',
            '3' => 'Not Installed',
            '4' => 'Unknown',
            '8' => 'Panel 1 Borbolla',
            '9' => 'Panel 1 Cartuja',
            '10' => 'Panel 2 Cartuja',
            '11' => 'Pending',
            
        ])->rules('required')->when('11', function (Form $form) {
            $form->text('QUANTITY', __('Quantity'));
        });
        $form->text('LOCATION', __('Location'));
        $form->select('OWNER', __('Owner'))->options(Company::pluck('COMPANY', 'ID'));
        //$form->number('QUANTITY', __('Quantity'));
        $form->text('NOTES', __('Notes'));
        //$form->date('INSERTION_DATE', __('Insertion Date'));
               
        //$form->date('MODIFICATION_DATE', __('Modification Date'));
        $user = Auth::user();

        // Si el usuario está autenticado, establece automáticamente el usuario en el campo MODIFIED_BY

        $form->select('MODIFIED_BY', __('MODIFIED BY'))->options(AdminUser::pluck('NAME', 'id'))->rules('required');         
        $form->select('INSERTED_BY', __('INSERTED BY'))->options(AdminUser::pluck('NAME', 'id'))->rules('required');         



        // if ($user) {
        //     $form->hidden('MODIFIED_BY', __('MODIFIED BY'))->default($user->id);
        // }
            
        // if ($user) {
        //     $form->hidden('INSERTED_BY', __('INSERTED BY'))->default($user->id);
        // } 






        $form->text('url', __('Sharepoint url'));
        $form->text('VERSION', __('Version'));

        //$form->switch('VISIBLE', __('Visible'));
        
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
        //$show->field('QUANTITY', __('Quantity'));
        $show->field('NOTES', __('Notes'));
        $show->field('recipientAdminUser.name', __('Receiver'));
        $show->field('insertedByAdminUser.name', __('Inserted by'));
        $show->field('modifiedByAdminUser.name', __('Modified by'));


        //$general = General::with('device')->find($deviceId);


        // $show->field('DEVICE_ID', __('Device Type'))->display(function ($deviceId) {
        //     // Busca el dispositivo en la tabla DeviceType usando el ID
        //     $deviceType = DeviceType::find($deviceId);
        
        //     // Verifica si se encontró un dispositivo con el ID dado
        //     if ($deviceType) {
        //         $general = General::with('device')->find($deviceId);

        //         // Si se encontró, devuelve el DEVICE_TYPE
        //         return $general -> device ->DEVICE_TYPE;
        //     } else {
        //         // Si no se encontró, devuelve un mensaje indicando que no hay tipo de dispositivo
        //         return 'No Device Type';
        //     }
        // });


        //$show->field('stado.STATE', __('State'));
        //$show->field('INSERTION_DATE', __('Insertion Date'));
        //$show->field('MODIFICATION_DATE', __('Modification Date'));
        $show->field('VERSION', __('Version'));
        //$show->field('VISIBLE', __('Visible'));

        $show->field('created_at', __('Insertion date'))->display(function ($createdAt) {
            return (new \DateTime($createdAt))->format('Y-m-d H:i:s');
        });
        $show->field('updated_at', __('Modification date'))->display(function ($updated_at) {
            return (new \DateTime($updated_at))->format('Y-m-d H:i:s');
        });

        
        

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
