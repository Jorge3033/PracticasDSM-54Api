<?php
//tenemos los modelos ña carpeta seeder y la base de datos
use App\User;
use App\Product;
use App\Category;
use App\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Desactivamos la relación de las llaves foraneas de nuestras tablas, porque no coinsidiran las llaves, ya que factory genera aleatoriamente estas
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');
//El metodo truncate vamos a parara o truncar los datos de user category, product,transaction
        User::truncate();
        Category::truncate();
        Product::truncate();
        Transaction::truncate();
// cate_pro es relacion muchos a muchos
        DB::table('category_product')->truncate();

        User::flushEventListeners();
        Category::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();
//Aqui definimos los usuarios que se llamaran
        $cantidadUsuarios = 100;
        $cantidadCategorias = 30;
        $cantidadProductos = 100;
        $cantidadTransacciones = 100;

//Mandamos a traer guardandolos con el metodo create segun se haya definido antes
        factory(User::class, $cantidadUsuarios)->create();
        factory(Category::class, $cantidadCategorias)->create();

//Asociamos el producto con un factory y creamos el registro con un each(ciclo), se inserta una funcion que solo obtiene el id del producto con el metodo pluck
		factory(Product::class, $cantidadTransacciones)->create()->each(
			function ($producto) {
				$categorias = Category::all()->random(mt_rand(1, 5))->pluck('id');
//con el metodo attach vamos a realizar un comando para ejecutarlo: php artisan migrate_seed y php artisan db:seed
				$producto->categories()->attach($categorias);
			}
		);

        factory(Transaction::class, $cantidadTransacciones)->create();
    }
}
