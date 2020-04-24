<?php
//Aquí se añaden todos los modelos de los que se haran uso.

use App\Category;
use App\Product;
use App\Seller;
use App\Transaction;
use App\User;
use Illuminate\Support\Str;
//faker es una libreria que genera datos añeatorios o falsos
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
// Static pass es una contraseña que no cambia, el return solicita los campos señalados
$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        //bycrypt encripta la pass
        'password' => $password ?: $password = bcrypt('secret'),
//La libreria Str da el numero de caracteres que el usuario pondra para que sea verficado

        'remember_token' => Str::random(10),
        //definimos la verificaicon de cada modelo  factorys usa faker es una libreria para php que facilita el nombre de de datos falsos y generaremos datos falsos o aleatoreos
        'verified' => $verificado = $faker->randomElement([User::USUARIO_VERIFICADO, User::USUARIO_NO_VERIFICADO]),
        //generamos el token de verificacion esto se genera si el usuario esta o no verificado.
        'verification_token' => $verificado == User::USUARIO_VERIFICADO ? null : User::generarVerificationToken(),
        'admin' => $faker->randomElement([User::USUARIO_ADMINISTRADOR, User::USUARIO_REGULAR]),
        //verifica el tipo de usuario
    ];
});

$factory->define(Category::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
    ];
});

$factory->define(Product::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->paragraph(1),
        'quantity' => $faker->numberBetween(1, 10),
        'status' => $faker->randomElement([Product::PRODUCTO_DISPONIBLE, Product::PRODUCTO_NO_DISPONIBLE]),
        'image' => $faker->randomElement(['1.jpg', '2.jpg', '3.jpg']),
        // 'seller_id' => User::inRandomOrder()->first()->id,
        'seller_id' => User::all()->random()->id,
    ];
});

$factory->define(Transaction::class, function (Faker\Generator $faker) {
    $vendedor = Seller::has('products')->get()->random();
    $comprador = User::all()->except($vendedor->id)->random();

    return [
        'quantity' => $faker->numberBetween(1, 3),
        'buyer_id' => $comprador->id,
        'product_id' => $vendedor->products->random()->id,
    ];
});
