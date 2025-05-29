# FormBuilder: a PHP class that helps you building forms

## How to install it

You can install this package quickly with composer: `composer require ludovicm67/php-formbuilder`

## How to use it?

Just see these examples:

```php
<?php
include('src/ludovicm67/FormBuilder.php');
use ludovicm67\FormBuilder;

/*Display a basic input with type text*/
//Result: <input type="text">
echo FormBuilder::input();

/* Display a basic input with a name attribute */
// Result: <input type="text" name="myName">
echo FormBuilder::input("text", "myName1");

/* Display a basic input with other custom attributes */
// Result: <input type="text" name="myName" id="myId" class="myClass" placeholder="Fill this beautiful field !">
echo FormBuilder::input("text", "myName2", $attrs = [
    "id"            =>  "myId",
    "class"         =>  "myClass",
    "placeholder"   =>  "Fill this beautiful field !"
]);

/* Display a input[type=hidden] */
echo FormBuilder::hidden("myName3", "myValue");


/* Don't want to specify always the type as the first argument? The following is for you : */
// Display a input of type text :
echo FormBuilder::text("myName4");

// Display a input of type password :
echo FormBuilder::password("myName5");

// Display a input of type email :
echo FormBuilder::email("myName6");

/* You can also pass custom attributes */
echo FormBuilder::text("myName7", ["id" => "myId1", "class" => "myClass"]);
echo FormBuilder::password("myName8", ["id" => "myId2", "class" => "myClass"]);
echo FormBuilder::email("myName9", ["id" => "myId3", "class" => "myClass"]);


/* Display a select field : */
// Will display a select field with 4 options, the 3rd one will be disabled
echo FormBuilder::select("mySelect1",
    ['item1', 'item2', 'item3 --disabled', 'item4'],
    ["id" => "myIdSelect1", "class" => "myClass"]);

// Will display a select field with 4 options with value and title, the 3rd one will be disabled
echo FormBuilder::select("mySelect2", [
        'valueItem1'    =>  'titleItem1',
        'valueItem2'    =>  'titleItem2',
        'valueItem3'    =>  'titleItem3 --disabled',
        'valueItem4'    =>  'titleItem4'
    ], ["id" => "myIdSelect1", "class" => "myClass"]);
?>
```

And some more in the `example` folder :wink:

## Register this component in Laravel

After doing a composer require command, you will just have to add register the form builder by adding `'FormBuilder' => ludovicm67\FormBuilder::class,` in your aliases, in the `config/app.php` file.

## Contribute

You find a bug? You want to add some stuff? Just open an issue!
