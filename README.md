## About
Burgers exists to make the Fat-Free Framework fat.
That means adding more classes to the Framework to work more comfortable.
This contains classes for users and ACL besides validation of data.

## Usage
To use the behaviour of F3 look at [bcosca/fatfree](https://github.com/bcosca/fatfree) or [fatfreeframework.com](fatfreeframework.com).
Burgers classes are build on top of them.
So many things are contained here.

### ORM and Validation
ORM is nearly identical to F3's.
To learn about this look [here](https://github.com/bcosca/fatfree#databases).

The only thing that differs is the constructor.
A default constructor can look like this:

```php
public function __construct() 
{
  parent::__construct(new DB\SQL("..."), "MyTable");

  $this->properties = array(
    "id" => array(
      "type" => "Integer",
    ),
    "name" => array(
      "type" => "Text",
    ),
    ...
  );
}
```

For every *field* of the database table you can add new properties.
The type is the data the field can contain.
Possible types are:

* Boolean
* Color
* Date
* Email
* Float
* Integer
* IP
* Numeric
* Text

The reason for this is that the data is validated before it is set to the object.

```php
  $mytable->field1 = "foo";
```

This example checks if the string "foo" is valid for field1.
In the case that field1 is a Text, this will match, if it is Integer, it will throw an exception of the type `FieldInvalidException`.
If field1 is not defined in the properties, it will throw a `FieldNotDefinedException`.

To use this features your class has to extend the **SqlMapper** class.
Your class might look like this.

```php
class MyModel extends SqlMapper
{
  public function __construct()
  {
  }
}
```

SqlMapper extends the DB\SQL\Mapper class from F3.

*Warning!* You can't use properties as a field for your model.

### Users and Authorization
User, Group and ACL all extend the SqlMapper class.
So you can use them to create, read, edit and delete them.

#### Users
A User in Burgers has the following members.

* id (int)
* groupId (int)
* name (text)
* email (email)
* password (text)

When creating or updating a User and setting a password, it automatically creates a salt and using bcrypt to store it.

If you want to log a user in, you can use `$user->checkLogin($email, $password)`.
It checks if a user with `$email` exists and `$password` matches the password of the user.

#### Groups
Groups are used to group users by their actions they can do in the application.
Therefore each user can be put in a group by setting their `groupId`.

Groups are very simple constructs.

* id (int)
* name (text)

#### ACL
[Access Control List (ACL)](https://en.wikipedia.org/wiki/Access_control_list) are used to authorize the access to an action or section in the application.
The ACL class has the following members:

* id (int)
* action (text)
* right (int)
* groupId (int)

Use them to add your own rules.

To check if the user can access something, ACL brings you a method called `check($groupId, $action, $right)`.
It returns a boolean that represents the right to access.
If an undefined group or action is passed it throws `ActionNotFoundException`.

### Creating Modules
To create a module that is executed by Burges it just need 2 easy requirements.
First, your class must extend `AbstractModule`.
Second, your class must implement a method named `execute()`.

This is how it looks like.

```php
class MyModule extends AbstractModule
{
  public function execute()
  {
    // do awesome stuff ...
  }
}
```

### Form generation
The form class will give you some easy-to-use tools to get data into the system.
It takes over the creation of the form, the validation of the data sent by this form and saving it into the database.

Here is how to use the form generation:

```php
$form = new Form($object);
```

$object is an instance of the SqlMapper class.

To generate the form you simply use `$form->render()`.
This will give you the html as string and you can print it or add it to your template.

When the form is sent to the backend you will first validate it with `$form->validate($f3->get("POST"))`.
If it fails it returns `FALSE` and adds a description of the failures to `$f3->get("form_errors")`.
If not you can use `$form->save($f3->get("POST"))` to put write it to the database.

### Navbar Generator ###

Built on top of the base [Burgers](https://github.com/hanspolo/burgers) classes, the navbar generator provides an easy way to generate [Bootstrap v3](http://getbootstrap.com/examples/navbar/) navbars with support for primary menu items and drop downs.

![01-navbar](https://cloud.githubusercontent.com/assets/9042878/9215259/7aba9f4a-40eb-11e5-949d-58e979325731.jpg)

**To use Navbars you will also need to ensure that you are using Burger's users and groups.  Navbars also requires an additional table containing the menu items.**

```
CREATE TABLE `menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anchor` varchar(128) DEFAULT NULL,
  `link` varchar(128) DEFAULT NULL,
  `access_level` tinyint(1) DEFAULT '0',
  `parent_id` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) 
```

The `access_level` specifies the minimum `groupId` required to access the menu item.  The `parent_id` is the id of the parent menu item if creating drop down menus.   A user with a groupId of 2 would see menu items with an `access_level` <= 2.

For a menu item to be a top level menu item ensure it has been created with a `parent_id` of 0.

**The table to use for the navbar needs to be set as a config item using the key `MENUTABLE`.  If you are using a `config.ini` this can be added in the file or using `$f3->set('MENUTABLE','menus')` before building or rendering the navbar**.

The navbar generator also requires that the user record returned by the Burgers `\User::checkLogin` be available in the session as user.  ie. `SESSION.user`.

The navbar generator will throw an Exception if needed information is not present.

To display the navbar you should first build the menu items using:

`\Nav::build()`

once the nav bar has been built you can then display it using:

`echo \Nav::render();`

The `\Nav::render()` command supports a first parameter to specify the styling type.  If left blank the navbar will be output as plain old HTML lists.  If set to `bootstrap` the output will be styled with the bootstrap classes.

For example to output using Bootstrap 3 you would use `echo \Nav::render('bootstrap')`.

Currently only Bootstrap 3 is supported.  Other versions, or other frameworks (ie. Foundation) may be added based on requirements.

`\Nav::render('bootstrap')` will only render the menu items themselves.  You will still need to provide the shell of the navbar as per the Bootstrap docs [http://getbootstrap.com/components/#navbar](http://getbootstrap.com/components/#navbar).

```
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Brand</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="main-navbar-collapse-1">

            <?php
                \Nav::build();
                echo \Nav::render('bootstrap');
            ?>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
```

## Support and License

### License
Burgers is licensed under GPL v.3
