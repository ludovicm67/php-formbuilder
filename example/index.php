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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="https://github.com/ludovicm67" target="_blank">ludovicm67</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar"
        aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item active">
            <a class="nav-link" href="#">FormBuilder example</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://github.com/ludovicm67/php-formbuilder" target="_blank">GitHub repository</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://github.com/ludovicm67" target="_blank">The author @ludovicm67</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">

    <div class="starter-template">
      <h1>Quick example</h1>
      <p class="lead">Use this class to generate forms quickly !</p>
    </div>

    <h2>Example 1: Forms will automatically display what's you've submitted before</h2>
    <p><em>All? No! Not the passwords fields and other inputs where you have overwritten the value</em></p>
    <form action="" method="post">
      <?= FormBuilder::text('example1-text'); ?>
      <?= FormBuilder::password('example1-password'); ?>
      <?= FormBuilder::submit(); ?>
    </form>

    <h2>Example 2: Custom some attributes like id, class, placeholder...</h2>
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

    <h2>Example 3: Disable or autoselect in select fields</h2>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
