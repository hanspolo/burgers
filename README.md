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
Coming soon...

## Support and License

### License
Burgers is licensed under GPL v.3
