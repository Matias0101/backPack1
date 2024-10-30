<?php

namespace App\Http\Controllers\Admin;



use App\Http\Requests\UserRequest;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use \Backpack\ActivityLog\Http\Controllers\Operations\ModelActivityOperation;
use \Backpack\ActivityLog\Http\Controllers\Operations\EntryActivityOperation;
//use Request;
use Illuminate\Http\Request;


/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ModelActivityOperation;  // Muestra los logs de todas las actividades del modelo
    use EntryActivityOperation;  // Muestra los logs de una entrada específica

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        $user = backpack_user();  // Obtener el usuario actual autenticado

        // Verifica si el usuario tiene el permiso para gestionar usuarios
        // if ($user->can('manage users')) {
        //     CRUD::allowAccess(['list', 'create', 'update', 'delete']);
        // } else {
        // Si el usuario no tiene permiso, puede solo ver y editar su propio perfil
        // CRUD::denyAccess(['list', 'create', 'delete']); // Denegar acceso a listar, crear y borrar usuarios

        // Permitir ver solo su propio perfil
        //     CRUD::addClause('where', 'id', $user->id); // Solo puede ver su propio usuario

        //     CRUD::allowAccess(['update']); // Puede actualizar su propio perfil
        // }
        // if (!backpack_user()->can('manage users')) {
        //     CRUD::denyAccess('create'); // Deniega el acceso a la creación si no tiene el permiso
        // }

        // if ($user->hasRole('admin')) {
        //     CRUD::allowAccess(['list', 'create', 'update', 'delete']);
        // } else {
        //     // Si no es admin, puede solo ver y editar su propio perfil
        //     CRUD::denyAccess(['list', 'create', 'delete']); // Denegar acceso a listar, crear y borrar usuarios

        //     // Permitir ver solo su propio perfil
        //     CRUD::addClause('where', 'id', $user->id); // Solo puede ver su propio usuario

        //     CRUD::allowAccess(['update']); // Puede actualizar su propio perfil
        // }
        // Verifica si el usuario tiene el permiso para gestionar usuarios
        if ($user->can('manage users')) {
            CRUD::allowAccess(['list', 'create', 'update', 'delete']);
        } else {
            // Si el usuario no tiene permiso, puede solo ver y editar su propio perfil
            CRUD::denyAccess(['list', 'create', 'delete']); // Denegar acceso a listar, crear y borrar usuarios

            // Permitir ver solo su propio perfil
            CRUD::addClause('where', 'id', $user->id); // Solo puede ver su propio usuario

            CRUD::allowAccess(['update']); // Puede actualizar su propio perfil
        }

        CRUD::setModel(User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');

         // Opcional: Configurar la visualización de los logs como causer
         //CRUD::set('activity-log.options', \Backpack\ActivityLog\Http\Controllers\Operations\ActivityLogEnum::CAUSER);
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $user = backpack_user();
        // Si el usuario es admin o tiene el permiso 'manage users', puede listar todos los usuarios
        if ($user->can('manage users')) {
            CRUD::setFromDb(); // Mostrar todos los usuarios
        } else {
            // Si no tiene permisos, solo puede ver su propio perfil
            CRUD::addClause('where', 'id', $user->id);
            CRUD::setFromDb(); // Mostrar solo los datos del propio usuario
        }
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        // Solo permitir a los admin o con permisos crear usuarios
        $user = backpack_user();
        if ($user->can('manage users')) {
            CRUD::setValidation(UserRequest::class);
            CRUD::setFromDb(); // Campos definidos desde la base de datos
        } else {
            CRUD::denyAccess('create');
        }
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $user = backpack_user();
        $this->setupCreateOperation();

        // Verificar si el usuario puede actualizar su propio perfil o es admin
        if (!$user->can('manage users')) {
            CRUD::addClause('where', 'id', $user->id); // Solo puede actualizar su propio perfil
        }
    }
    // app/Http/Controllers/Admin/UserCrudController.php

    // public function store(Request $request)
    // {
    //     // Guardar el usuario
    //     $user = User::create($request->all());

    //     // Asignar un rol al usuario
    //     //$user->assignRole('admin');

    //     // Redireccionar o realizar alguna acción después de guardar
    // }

}
