
##### Generate code using following commands.

* [`php artisan generate:all`](#generate-all)
* [`php artisan generate:migration`](#generate-migration)
* [`php artisan generate:model`](#generate-model)
* [`php artisan generate:contract`](#generate-contract)
* [`php artisan generate:request`](#generate-request)
* [`php artisan generate:exception`](#generate-exception)
* [`php artisan generate:service`](#generate-service)
* [`php artisan generate:transformer`](#generate-transformer)
* [`php artisan generate:controller`](#generate-controller)
* [`php artisan generate:factory`](#generate-factory)
* [`php artisan generate:seeder`](#generate-seeder)

### Installation
Require this package with composer using the following command:

```bash
composer require devslane/generator
```

### Publish
Publish the GeneratorServiceProvider.

```bash
php artisan vendor:publish --provider="Devslane\Generator\Providers\GeneratorServiceProvider"
```

### Generate All

_generate:all {tables*}_

```bash
php artisan generate:all users
```

### Generate Migration
Run this command to generate the migration file providing the table name and column details.

_generate:migration {table : Name of the table} {--columns= : Columns of the table}_

Not providing any columns will generate the migration containing only the Primary Key as 
_Illuminate\Database\Schema\Blueprint bigIncrements_. and the Timestamps.

```php
$table->bigIncrements('id');
$table->timestamps();
```

``` php
php artisan generate:migration users --columns=first_name:string,last_name:string,age:integer
```

```php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id'); 
			$table->string('first_name');
			$table->string('last_name');
			$table->integer('age');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
```

Foreign Key constraint on a column can also be provided with the command as:

```bash
php artisan create:migration test --columns=user_id:fk=users 
```
__create:migration {table : Name of the table} {--columns= : **columnName:fk=relatedTableName**}_

Foreign key constraint is always applied on the Primary Id of the Related table provided.

### Generate Model
Provide the name of the database tables with the command generates the Eloquent Model.

_generate:model {tables*}_

```bash
php artisan generate:model users
```
Generates: **User**
```php
namespace App;
use Devslane\Generator\Models\BaseModel;

/**
 * Class User
 * 
 * @package App
 */
class User extends BaseModel
{
    
}
```

### Generate Contract
This command generates all the CRUD operation Request Contracts which the requests will implement.

_generate:contract {tables*}_

```bash
php artisan generate:contract users
```

Generates the following:
* Create**User**Contract
* List**User**Contract
* Update**User**Contract

These classes contain the most essential functions and creates a basic structure of the contracts which can be expanded according to needs.
The _Delete**User**Contract_ is not created. It can always be added if requirement arises.

```php
namespace App\Services\Contract;

interface ListUserContract
{

}
```

```php
namespace App\Services\Contract;

interface CreateUserContract
{
    public function getFirstName();

    public function getLastName();

    public function getAge();

    public function getCreatedAt();

    public function getUpdatedAt();
}
```

```php
namespace App\Services\Contract;

interface UpdateUserContract
{
	public function getFirstName();

	public function hasFirstName();

	public function getLastName();

	public function hasLastName();

	public function getAge();

	public function hasAge();

	public function getCreatedAt();

	public function hasCreatedAt();

	public function getUpdatedAt();

	public function hasUpdatedAt();
}

```

### Generate Request
This command generates all the CRUD operation Request Contracts which the requests will implement.

_generate:request {tables*}_

```bash
php artisan generate:request users
```

Running this for the very first time generates _ListRequest_ Class which is then extended by all the ListRequest Classes.
* ListRequest
```php
namespace App\Api\V1\Requests;

use Devslane\Generator\Requests\BaseRequest;

/**
 * Class ListTesttableRequest
 * @package App\Api\V1\Requests
 */
class ListRequest extends BaseRequest
{
    const LIMIT        = 'limit';
    const ORDER        = 'order';
    const ORDER_BY     = 'order_by';
    const SEARCH_QUERY = 'search_query';


    public function getLimit() {
        return $this->input(self::LIMIT);
    }

    public function getOrder() {
        return $this->input(self::ORDER);
    }

    public function getOrderBy() {
        return $this->input(self::ORDER_BY);
    }

    public function getSearchQuery() {
        return $this->input(self::SEARCH_QUERY);
    }
}
```

Generates the following:
* Create**User**Request
* List**User**Request
* Update**User**Request

These classes implement the corresponding contracts generated by the previous command and also contain the implementation
of the functions of the Contracts.
The _Delete**User**Request_ is not created. It can always be added if requirement arises.

```php
namespace App\Api\V1\Requests;

use App\Services\Contract\ListUserContract as Contract;

/**
 * Class ListUserRequest
 * @package App\Api\V1\Requests
 */
class ListUserRequest extends ListRequest implements Contract
{

}
```

```php
namespace App\Api\V1\Requests;

use App\Services\Contract\CreateUserContract as Contract;

/**
 * Class CreateUserRequest
 * @package App\Api\V1\Requests
 */
class CreateUserRequest extends ListRequest implements Contract
{
    const FIRST_NAME = 'first_name';
    const LAST_NAME  = 'last_name';
    const AGE        = 'age';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public function getFirstName() {
        return $this->input(self::FIRST_NAME);
    }

    public function getLastName() {
        return $this->input(self::LAST_NAME);
    }

    public function getAge() {
        return $this->input(self::AGE);
    }

    public function getCreatedAt() {
        return $this->input(self::CREATED_AT);
    }

    public function getUpdatedAt() {
        return $this->input(self::UPDATED_AT);
    }
}
```

```php
namespace App\Api\V1\Requests;

use App\Services\Contract\UpdateUserContract as Contract;

/**
 * Class UpdateUserRequest
 * @package App\Api\V1\Requests
 */
class UpdateUserRequest extends ListRequest implements Contract
{
    const FIRST_NAME = 'first_name';
    const LAST_NAME  = 'last_name';
    const AGE        = 'age';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public function getFirstName() {
        return $this->input(self::FIRST_NAME);
    }

    public function hasFirstName() {
        return $this->has(self::FIRST_NAME);
    }

    public function getLastName() {
        return $this->input(self::LAST_NAME);
    }

    public function hasLastName() {
        return $this->has(self::LAST_NAME);
    }

    public function getAge() {
        return $this->input(self::AGE);
    }

    public function hasAge() {
        return $this->has(self::AGE);
    }

    public function getCreatedAt() {
        return $this->input(self::CREATED_AT);
    }

    public function hasCreatedAt() {
        return $this->has(self::CREATED_AT);
    }

    public function getUpdatedAt() {
        return $this->input(self::UPDATED_AT);
    }

    public function hasUpdatedAt() {
        return $this->has(self::UPDATED_AT);
    }
}
```

### Generate Exception
This generates the _NotFoundExceptions_ related to the tables provided with the command.

_generate:exception {tables*}_
 
```bash
php artisan generate:exception users
```
Generates: **User**NotFoundException
```php
namespace App\Api\V1\Exceptions;

use Devslane\Generator\Exceptions\HttpException;

/**
 * Class UserNotFoundException
 * @package App\Api\V1\Exceptions
 */
class UserNotFoundException extends HttpException
{
    const ERROR_MESSAGE = 'User not Found';

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE, self::ERROR_NOT_FOUND, 404);
    }
}
```

### Generate Service
This command generates Services for the given tables containing CRUD operations in the service. These services are used by
the Controllers to execute CRUD operations on the Database.

_generate:service {tables*}_

```bash
php artisan generate:service users
```
Generates: **User**Service
```php
namespace App\Services;


use App\Api\V1\Exceptions\UserNotFoundException;
use App\User;
use App\Services\Contract\CreateUserContract;
use App\Services\Contract\UpdateUserContract;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{

    /**
     * @param $userId
     * @return User
     */
    public static function find($userId) {
        $user = User::find($userId);
        if (!$user) {
            throw new UserNotFoundException();
        }
        return $user;
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index() {
        return User::all();
    }

    /**
     * @param $userId
     * @return User
     */
    public function show($userId) {
        return self::find($userId);
    }

    /**
     * @param CreateUserContract $contract
     * @return User
     */
    public function store(CreateUserContract $contract) {
        $user = new User();
                $user->first_name = $contract->getFirstName();
        $user->last_name = $contract->getLastName();
        $user->age = $contract->getAge();

        $user->save();
        return $user;
    }

    /**
     * @param $userId
     * @param UpdateUserContract $contract
     * @return User
     */
    public function update($userId, UpdateUserContract $contract) {
        $user = self::find($userId);
                if ($contract->hasFirstName()) {
            $user->first_name = $contract->getFirstName();
        }
        if ($contract->hasLastName()) {
            $user->last_name = $contract->getLastName();
        }
        if ($contract->hasAge()) {
            $user->age = $contract->getAge();
        }

        $user->save();
        return $user;
    }

    /**
     * @param $userId
     */
    public function delete($userId) {
        $user = $this->find($userId);
        try {
            $user->delete();
        } catch (\Exception $e) {
        }
    }
}
```

### Generate Transformer
Generates the Transformer for the response that will be generated after any CRUD operation, the Controller exploit these
Transformers to transform the response in the desired format.

_generate:transformer {tables*}_

```bash
php artisan generate:transformer users
```
Generates: **User**Transformer

```php
namespace App\Transformers;


use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform(User $user){
        return [
			'id' => $user->id,
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'age' => (int)$user->age,
			'created_at' => $user->created_at,
			'updated_at' => $user->updated_at,
		];
    }
}

```

### Generate Controller
Generates a controller having fundamental CRUD functions, which the routes point to. These controller classes use
the generated Services for the database operations.

Makes use of the Transformer generated for that Database Table.

_generate:controller {tables*}_

```bash
php artisan generate:controller users
```
Generates: **User**Controller

```php
namespace App\Api\V1\Controllers;


use App\Transformers\UserTransformer;
use App\Api\V1\Requests\CreateUserRequest;
use App\Api\V1\Requests\UpdateUserRequest;
use App\Services\UserService;
use Devslane\Generator\Controllers\BaseController;

/**
 * Class UserController
 * @package App\Api\V1\Controllers
 *
 * @property-read UserService $userService
 */
class UserController extends BaseController
{
    protected $userService;

    public function __construct() {
        $this->userService = new UserService();
    }
    
    
    /**
     * @param UserService $service
     * @return \Dingo\Api\Http\Response
     */
    public function index(UserService $service) {
        $users = $service->index();
        return $this->response->collection($users, new UserTransformer());
    }

    /**
     * @param $id
     * @param UserService $service
     * @return \Dingo\Api\Http\Response
     */
    public function show($id, UserService $service) {
        $user = $service->show($id);
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * @param CreateUserRequest $request
     * @param UserService $service
     * @return \Dingo\Api\Http\Response
     */
    public function store(CreateUserRequest $request, UserService $service) {
        $user = $service->store($request);
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @param UserService $service
     * @return \Dingo\Api\Http\Response
     */
    public function update(UpdateUserRequest $request, $id, UserService $service) {
        $user = $service->update($id, $request);
        return $this->response->item($user, new UserTransformer());
    }
    
    /**
     * @param $id
     * @param UserService $service
     */
    public function destroy($id, UserService $service) {
        $service->delete($id);
    }
}

```

### Generate Factory
Generates the Factory class for the tables provided.

_generate:factory {tables*}_

```bash
php artisan generate:facotory users
```
Generates: **User**Factory

```php
use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
		'first_name'=>$faker->firstName,
		'last_name'=>$faker->lastName,
		'age'=>$faker->numberBetween(0,100),
		'created_at'=>$faker->dateTime,
		'updated_at'=>$faker->dateTime,
	];
});
```

### Generate Seeder
Generates the Database seeder for the tables. These seeders use the factories.
By default the number of rows are 10 for the seeders and can be modified by changing it in the _mcs-helper.php_ in config.

```php
return [
.
.
    'seeder'      => [
        'row_count'     => 10,
        'path'          => 'database/seeds',
        'overwrite'     => true,
        'exclude_table' => [
            'password_resets', 'migrations',
        ],
    ]
.
.
]
```

_generate:seeder {tables*}_

```bash
php artisan generate:seeder users
```
Generates: **User**Seeder

```php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {
        $size = (integer)Config::get('mcs-helper.seeder.row_count');
        factory(User::class, $size)->create();
>>>>>>> 7c4c9b323865c5f3a70aa0923ba24dc13b2a6f91
    }
}
```

### Generate Model
Provide the name of the database tables with the command generates the Eloquent Model.

_generate:model {tables*}_

```bash
php artisan generate:model users
```
Generates: **User**
```php
namespace App;
use Devslane\Generator\Models\BaseModel;

/**
 * Class User
 * 
 * @package App
 */
class User extends BaseModel
{
    
}
```

### Generate Contract
This command generates all the CRUD operation Request Contracts which the requests will implement.

_generate:contract {tables*}_

```bash
php artisan generate:contract users
```

Generates the following:
* Create**User**Contract
* List**User**Contract
* Update**User**Contract

These classes contain the most essential functions and creates a basic structure of the contracts which can be expanded according to needs.
The _Delete**User**Contract_ is not created. It can always be added if requirement arises.

```php
namespace App\Services\Contract;

interface ListUserContract
{

}
```

```php
namespace App\Services\Contract;

interface CreateUserContract
{
    public function getFirstName();

    public function getLastName();

    public function getAge();

    public function getCreatedAt();

    public function getUpdatedAt();
}
```

```php
namespace App\Services\Contract;

interface UpdateUserContract
{
	public function getFirstName();

	public function hasFirstName();

	public function getLastName();

	public function hasLastName();

	public function getAge();

	public function hasAge();

	public function getCreatedAt();

	public function hasCreatedAt();

	public function getUpdatedAt();

	public function hasUpdatedAt();
}

```

### Generate Request
This command generates all the CRUD operation Request Contracts which the requests will implement.

_generate:request {tables*}_

```bash
php artisan generate:request users
```

Running this for the very first time generates _ListRequest_ Class which is then extended by all the ListRequest Classes.
* ListRequest
```php
namespace App\Api\V1\Requests;

use Devslane\Generator\Requests\BaseRequest;

/**
 * Class ListTesttableRequest
 * @package App\Api\V1\Requests
 */
class ListRequest extends BaseRequest
{
    const LIMIT        = 'limit';
    const ORDER        = 'order';
    const ORDER_BY     = 'order_by';
    const SEARCH_QUERY = 'search_query';


    public function getLimit() {
        return $this->input(self::LIMIT);
    }

    public function getOrder() {
        return $this->input(self::ORDER);
    }

    public function getOrderBy() {
        return $this->input(self::ORDER_BY);
    }

    public function getSearchQuery() {
        return $this->input(self::SEARCH_QUERY);
    }
}
```

Generates the following:
* Create**User**Request
* List**User**Request
* Update**User**Request

These classes implement the corresponding contracts generated by the previous command and also contain the implementation
of the functions of the Contracts.
The _Delete**User**Request_ is not created. It can always be added if requirement arises.

```php
namespace App\Api\V1\Requests;

use App\Services\Contract\ListUserContract as Contract;

/**
 * Class ListUserRequest
 * @package App\Api\V1\Requests
 */
class ListUserRequest extends ListRequest implements Contract
{

}
```

```php
namespace App\Api\V1\Requests;

use App\Services\Contract\CreateUserContract as Contract;

/**
 * Class CreateUserRequest
 * @package App\Api\V1\Requests
 */
class CreateUserRequest extends ListRequest implements Contract
{
    const FIRST_NAME = 'first_name';
    const LAST_NAME  = 'last_name';
    const AGE        = 'age';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public function getFirstName() {
        return $this->input(self::FIRST_NAME);
    }

    public function getLastName() {
        return $this->input(self::LAST_NAME);
    }

    public function getAge() {
        return $this->input(self::AGE);
    }

    public function getCreatedAt() {
        return $this->input(self::CREATED_AT);
    }

    public function getUpdatedAt() {
        return $this->input(self::UPDATED_AT);
    }
}
```

```php
namespace App\Api\V1\Requests;

use App\Services\Contract\UpdateUserContract as Contract;

/**
 * Class UpdateUserRequest
 * @package App\Api\V1\Requests
 */
class UpdateUserRequest extends ListRequest implements Contract
{
    const FIRST_NAME = 'first_name';
    const LAST_NAME  = 'last_name';
    const AGE        = 'age';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    public function getFirstName() {
        return $this->input(self::FIRST_NAME);
    }

    public function hasFirstName() {
        return $this->has(self::FIRST_NAME);
    }

    public function getLastName() {
        return $this->input(self::LAST_NAME);
    }

    public function hasLastName() {
        return $this->has(self::LAST_NAME);
    }

    public function getAge() {
        return $this->input(self::AGE);
    }

    public function hasAge() {
        return $this->has(self::AGE);
    }

    public function getCreatedAt() {
        return $this->input(self::CREATED_AT);
    }

    public function hasCreatedAt() {
        return $this->has(self::CREATED_AT);
    }

    public function getUpdatedAt() {
        return $this->input(self::UPDATED_AT);
    }

    public function hasUpdatedAt() {
        return $this->has(self::UPDATED_AT);
    }
}
```

### Generate Exception
This generates the _NotFoundExceptions_ related to the tables provided with the command.

_generate:exception {tables*}_
 
```bash
php artisan generate:exception users
```
Generates: **User**NotFoundException
```php
namespace App\Api\V1\Exceptions;

use Devslane\Generator\Exceptions\HttpException;

/**
 * Class UserNotFoundException
 * @package App\Api\V1\Exceptions
 */
class UserNotFoundException extends HttpException
{
    const ERROR_MESSAGE = 'User not Found';

    public function __construct()
    {
        parent::__construct(self::ERROR_MESSAGE, self::ERROR_NOT_FOUND, 404);
    }
}
```

### Generate Service
This command generates Services for the given tables containing CRUD operations in the service. These services are used by
the Controllers to execute CRUD operations on the Database.

_generate:service {tables*}_

```bash
php artisan generate:service users
```
Generates: **User**Service
```php
namespace App\Services;


use App\Api\V1\Exceptions\UserNotFoundException;
use App\User;
use App\Services\Contract\CreateUserContract;
use App\Services\Contract\UpdateUserContract;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{

    /**
     * @param $userId
     * @return User
     */
    public static function find($userId) {
        $user = User::find($userId);
        if (!$user) {
            throw new UserNotFoundException();
        }
        return $user;
    }

    /**
     * @return User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index() {
        return User::all();
    }

    /**
     * @param $userId
     * @return User
     */
    public function show($userId) {
        return self::find($userId);
    }

    /**
     * @param CreateUserContract $contract
     * @return User
     */
    public function store(CreateUserContract $contract) {
        $user = new User();
                $user->first_name = $contract->getFirstName();
        $user->last_name = $contract->getLastName();
        $user->age = $contract->getAge();

        $user->save();
        return $user;
    }

    /**
     * @param $userId
     * @param UpdateUserContract $contract
     * @return User
     */
    public function update($userId, UpdateUserContract $contract) {
        $user = self::find($userId);
                if ($contract->hasFirstName()) {
            $user->first_name = $contract->getFirstName();
        }
        if ($contract->hasLastName()) {
            $user->last_name = $contract->getLastName();
        }
        if ($contract->hasAge()) {
            $user->age = $contract->getAge();
        }

        $user->save();
        return $user;
    }

    /**
     * @param $userId
     */
    public function delete($userId) {
        $user = $this->find($userId);
        try {
            $user->delete();
        } catch (\Exception $e) {
        }
    }
}
```

### Generate Transformer
Generates the Transformer for the response that will be generated after any CRUD operation, the Controller exploit these
Transformers to transform the response in the desired format.

_generate:transformer {tables*}_

```bash
php artisan generate:transformer users
```
Generates: **User**Transformer

```php
namespace App\Transformers;


use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{

    public function transform(User $user){
        return [
			'id' => $user->id,
			'first_name' => $user->first_name,
			'last_name' => $user->last_name,
			'age' => (int)$user->age,
			'created_at' => $user->created_at,
			'updated_at' => $user->updated_at,
		];
    }
}

```

### Generate Controller
Generates a controller having fundamental CRUD functions, which the routes point to. These controller classes use
the generated Services for the database operations.

Makes use of the Transformer generated for that Database Table.

_generate:controller {tables*}_

```bash
php artisan generate:controller users
```
Generates: **User**Controller

```php
namespace App\Api\V1\Controllers;


use App\Transformers\UserTransformer;
use App\Api\V1\Requests\CreateUserRequest;
use App\Api\V1\Requests\UpdateUserRequest;
use App\Services\UserService;
use Devslane\Generator\Controllers\BaseController;

/**
 * Class UserController
 * @package App\Api\V1\Controllers
 *
 * @property-read UserService $userService
 */
class UserController extends BaseController
{
    protected $userService;

    public function __construct() {
        $this->userService = new UserService();
    }
    
    
    /**
     * @param UserService $service
     * @return \Dingo\Api\Http\Response
     */
    public function index(UserService $service) {
        $users = $service->index();
        return $this->response->collection($users, new UserTransformer());
    }

    /**
     * @param $id
     * @param UserService $service
     * @return \Dingo\Api\Http\Response
     */
    public function show($id, UserService $service) {
        $user = $service->show($id);
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * @param CreateUserRequest $request
     * @param UserService $service
     * @return \Dingo\Api\Http\Response
     */
    public function store(CreateUserRequest $request, UserService $service) {
        $user = $service->store($request);
        return $this->response->item($user, new UserTransformer());
    }

    /**
     * @param UpdateUserRequest $request
     * @param $id
     * @param UserService $service
     * @return \Dingo\Api\Http\Response
     */
    public function update(UpdateUserRequest $request, $id, UserService $service) {
        $user = $service->update($id, $request);
        return $this->response->item($user, new UserTransformer());
    }
    
    /**
     * @param $id
     * @param UserService $service
     */
    public function destroy($id, UserService $service) {
        $service->delete($id);
    }
}

```

### Generate Factory
Generates the Factory class for the tables provided.

_generate:factory {tables*}_

```bash
php artisan generate:facotory users
```
Generates: **User**Factory

```php
use App\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [
		'first_name'=>$faker->firstName,
		'last_name'=>$faker->lastName,
		'age'=>$faker->numberBetween(0,100),
		'created_at'=>$faker->dateTime,
		'updated_at'=>$faker->dateTime,
	];
});
```

### Generate Seeder
Generates the Database seeder for the tables. These seeders use the factories.
By default the number of rows are 10 for the seeders and can be modified by changing it in the _mcs-helper.php_ in config.

```php
return [
.
.
    'seeder'      => [
        'row_count'     => 10,
        'path'          => 'database/seeds',
        'overwrite'     => true,
        'exclude_table' => [
            'password_resets', 'migrations',
        ],
    ]
.
.
]
```

_generate:seeder {tables*}_

```bash
php artisan generate:seeder users
```
Generates: **User**Seeder

```php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run() {
        $size = (integer)Config::get('mcs-helper.seeder.row_count');
        factory(User::class, $size)->create();
    }
}
```