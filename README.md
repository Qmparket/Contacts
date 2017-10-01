<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>


CONFIGURATION
-------------
### Composer
In the project folder run composer install.

### dynamic-form.js
Before running the app:
Replace "./vendor/wbraganca/yii2-dynamicform/src/assets/yii2-dynamic-form.js" with "./yii-dynamic-form.js" !

### Database Configuration

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Yii won't create the database for you, this has to be done manually before you can access it.
- Check and edit the other files in the `config/` directory to customize your application as required.
- Refer to the README in the `tests` directory for information specific to basic application tests.

### XAMPP
Run xampp, start apache and mysql.

### Create tables with migration

php yii migrate up

### Run the app

In the project folder run "php yii serve", the app will run on port : 8080.

**NOTE** 
Contact Update function doesn't work.
