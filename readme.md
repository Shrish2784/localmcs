
##### Generate code using following commands.

* [`php artisan generate:all`]()
* [`php artisan generate:migration`](#generate-migration)
* [`php artisan generate:model`](#generate-model)
* [`php artisan generate:contract`](#generate-contract)
* [`php artisan generate:request`](#generate-request)
* [`php artisan generate:exception`](#generate-exception)
* [`php artisan generate:service`](#generate-service)
* [`php artisan generate:transformer`]()
* [`php artisan generate:controller`]()
* [`php artisan generate:factory`]()
* [`php artisan generate:seeder`]()

### Installation
Require this package with composer using the following command:

```bash
composer require devslane/generator
```

For generation of Models, the package uses _doctrine/dbal_ and install that as well.

```bash
composer require -dev doctrine/dbal
```

### Publish
Publish the GeneratorServiceProvider.

```bash
php artisan vendor:publish --provider="Devslane\Generator\Providers\GeneratorServiceProvider"
```

### Generate Migration
Run this command to generate the migration file providing the table name and column details.

_generate:migration {table : Name of the table} {--columns= : Columns of the table}_


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

```php
namespace App\Api\V1\Requests;

use Devslane\Generator\Parents\BaseRequest;

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
        return $this->get(self::LIMIT);
    }

    public function getOrder() {
        return $this->get(self::ORDER);
    }

    public function getOrderBy() {
        return $this->get(self::ORDER_BY);
    }

    public function getSearchQuery() {
        return $this->get(self::SEARCH_QUERY);
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
        return $this->get(self::FIRST_NAME);
    }

    public function getLastName() {
        return $this->get(self::LAST_NAME);
    }

    public function getAge() {
        return $this->get(self::AGE);
    }

    public function getCreatedAt() {
        return $this->get(self::CREATED_AT);
    }

    public function getUpdatedAt() {
        return $this->get(self::UPDATED_AT);
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
        return $this->get(self::FIRST_NAME);
    }

    public function hasFirstName() {
        return $this->has(self::FIRST_NAME);
    }

    public function getLastName() {
        return $this->get(self::LAST_NAME);
    }

    public function hasLastName() {
        return $this->has(self::LAST_NAME);
    }

    public function getAge() {
        return $this->get(self::AGE);
    }

    public function hasAge() {
        return $this->has(self::AGE);
    }

    public function getCreatedAt() {
        return $this->get(self::CREATED_AT);
    }

    public function hasCreatedAt() {
        return $this->has(self::CREATED_AT);
    }

    public function getUpdatedAt() {
        return $this->get(self::UPDATED_AT);
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

use Devslane\Generator\Parents\HttpException;

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

