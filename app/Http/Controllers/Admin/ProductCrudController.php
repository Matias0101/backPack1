<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
        crud::addFilter(
            [
                'type' => 'simple',
                'name' => 'draft',
                'label' => 'Display only draft products',
            ],
             false,
            function ($query) {
                if (is_callable([$query, 'where'])) {
                    $query->where('status', 'DRAFT');
                } else {
                    // Manejo de error o registro para debug
                    \Log::error('El parámetro de filtro no es un objeto de consulta');
                }
            }
        );

        //filtros

        //exportar
        CRUD::enableExportButtons();
        CRUD::enableDetailsRow();

        crud::addFilter(
            [
                'type' => 'select2',
                'name' => 'category',
                'label' => 'By category',
            ],
            Category::all()->pluck('name', 'id')->toArray(),
            function ($value) {
                CRUD::addClause('where', 'category_id', $value);
            }
        );


        crud::column('id')->type('my_custom_column'); //agregamos la columna id y la persanalizamos!
        crud::column('price')->prefix('US$')->suffix('!!!');


        crud::column('image')->type('image');
        crud::column('name');
        crud::column('description');
        crud::column('category')->wrapper([
            'href' => function ($crud, $column, $entry) {
                return backpack_url('category/' . $entry->category_id . '/show');
            },
        ]);
        crud::column('status')->wrapper([
            'class' => function ($crud, $column, $entry) {
                // return match ($entry->status) 
                // {
                //     'DRAFT' => 'badge bg-warning',
                //     default => 'badge bg-success',
                // if ($entry->status === 'DRAFT') {
                //     return 'badge bg-warning';
                // }
                // return 'badge bg-success';
                // };
                switch ($entry->status) {
                    case 'DRAFT':
                        return 'badge bg-warning';
                    default:
                        return 'badge bg-success';
                }
            },
        ]);
    }
    public function showDetailsRow($id)
    {
       // return 'this product was created' . CRUD::getCurrentEntry()->create_at->diffForHumans() .'.';
       $entry = CRUD::getCurrentEntry();
    
       if ($entry && $entry->created_at) {
           return 'This product was created ' . $entry->created_at->diffForHumans() . '.';
       } else {
           return 'Creation date for this product is not available.';
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
        CRUD::setValidation(ProductRequest::class);
        //CRUD::setFromDb(); // set fields from db columns.
        CRUD::field('name');
    CRUD::field('price');
    CRUD::field('description');
    
    // Agrega el campo select para la categoría
    CRUD::field('category_id')->type('select')
        ->label('Category')
        ->entity('category')  // Nombre del método en el modelo Product que define la relación
        ->model(Category::class)  // El modelo que contiene las categorías
        ->attribute('name')  // El atributo del modelo Category que se mostrará en el select
        ->default(1);  // Opcional: establece una categoría por defecto

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
        // Define the fields manually
        // Define the fields manually

    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
