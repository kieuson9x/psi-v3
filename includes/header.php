<?php require_once 'php_action/core.php'; ?>

<!DOCTYPE html>
<html>

<head>

  <title>PSI</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PSI</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" type="text/css" />
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.18.2/dist/bootstrap-table.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/Talv/x-editable@develop/dist/bootstrap4-editable/css/bootstrap-editable.css">

  <!-- Bootstrap select css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

  <!-- font css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">

  <!-- Toastr css -->
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css" />

  <!-- Select 2 css -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

  <!-- custom css -->
  <link rel="stylesheet" href="custom/css/custom.css">

  <!-- jquery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-deparam/0.5.1/jquery-deparam.min.js"></script>
  <style>
    table.dataTable tbody th,
    table.dataTable tbody td {
      border: 1px solid !important;
      text-align: center;
    }

    table.dataTable thead th,
    table.dataTable thead td {
      border: 1px solid !important;
      text-align: center;
    }
  </style>
</head>

<body>
  <input type="hidden" id="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
  <input type="hidden" id="level_id" value="<?php echo $_SESSION['level_id']; ?>" />
  <input type="hidden" id="employee_level" value="<?php echo $_SESSION['employee_level']; ?>" />
  <input type="hidden" id="channel_id" value="<?php echo $_SESSION['channel_id']; ?>" />
  <input type="hidden" id="business_unit_id" value="<?php echo $_SESSION['business_unit_id']; ?>" />
  <input type="hidden" id="industry_id" value="<?php echo $_SESSION['industry_id']; ?>" />
  <input type="hidden" id="channel_name" value="<?php echo $_SESSION['channel_name']; ?>" />
  
  <div class="" style="padding:15px;" id="main">