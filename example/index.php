<?php
include('../src/ludovicm67/FormBuilder.php');
use ludovicm67\FormBuilder;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <title>ludovicm67/php-formbuilder example</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 75px;
            padding-bottom: 150px;
        }
        h2 {
            margin-top: 50px;
        }
        input, select, textarea {
            margin-bottom: 5px;
        }
        textarea {
            min-height: 75px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
     <div class="container">
       <div class="navbar-header">
         <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
           <span class="sr-only">Toggle navigation</span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="https://github.com/ludovicm67" target="_blank">ludovicm67</a>
       </div>
       <div id="navbar" class="collapse navbar-collapse">
         <ul class="nav navbar-nav">
           <li class="active"><a href="#">FormBuilder example</a></li>
           <li><a href="https://github.com/ludovicm67/php-formbuilder" target="_blank">GitHub repository</a></li>
           <li><a href="https://github.com/ludovicm67" target="_blank">The author @ludovicm67</a></li>
         </ul>
       </div><!--/.nav-collapse -->
     </div>
   </nav>

   <div class="container">

     <div class="starter-template">
       <h1>Quick example</h1>
       <p class="lead">Use this class to generate forms quickly !</p>
     </div>

    <h2>Example 1 : Forms will automatically display what's you've submitted before</h2>
    <p><em>All ? No ! Not the passwords fields and other inputs where you have overwritten the value</em></p>
     <form action="" method="post">
         <?= FormBuilder::text('example1-text'); ?>
         <?= FormBuilder::password('example1-password'); ?>
         <?= FormBuilder::submit(); ?>
     </form>

    <h2>Example 2 : Custom some attributes like id, class, placeholder...</h2>
    <p><em>It's very useful when you are using Bootstrap for example :p</em></p>
     <form action="" method="post">
         <?= FormBuilder::text('example2-input', ['id' => 'mySuperId', 'class' => 'form-control', 'placeholder' => 'First input !']); ?>
         <?= FormBuilder::text('example2-input2', ['placeholder' => 'Haha :D', 'id' => 'mySuperId2', 'class' => 'form-control']); ?>
         <?= FormBuilder::password('example2-password', ['placeholder' => 'A password field ! :O', 'class' => 'form-control']); ?>
         <?= FormBuilder::hidden('example2-hidden', 'hiddenValue'); ?>
         <?= FormBuilder::selectDay('example2-dayselect', ['class' => 'form-control']); ?>
         <?= FormBuilder::selectMonth('example2-monthselect', ['class' => 'form-control']); ?>
         <?= FormBuilder::selectMonthName('example2-monthnameselect', ['class' => 'form-control']); ?>
         <?= FormBuilder::selectMonthNameFR('example2-monthnameselect-french', ['class' => 'form-control']); ?>
         <?= FormBuilder::selectYear('example2-yearselect', ['class' => 'form-control']); ?>
         <?= FormBuilder::textarea('example2-textaera', ['class' => 'form-control']); ?>
         <?= FormBuilder::submit('Submit this beautiful form !', ['class' => 'btn btn-primary']); ?>
     </form>

     <h2>Example 3 : Disable or autoselect in select fields</h2>
     <p>Use : <code>value --disabled</code> to diable a specific option</p>
     <p>Use : <code>value --selected</code> to select automatically an option</p>
     <?= FormBuilder::select('example3-select', [
        'item1' => 'value1',
        'item2' => 'hey i\'m disabled --disabled',
        'item3' => 'i was automatically selected --selected'
     ], ['class' => 'form-control']); ?>
     <?= FormBuilder::select('example3-select2', [
        'value1', 'hey i\'m disabled --disabled', 'i was automatically selected --selected'
     ], ['class' => 'form-control']); ?>

   </div><!-- /.container -->
</body>
</html>