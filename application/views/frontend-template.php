<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Welcome to CodeIgniter</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <link rel="stylesheet" href="<?php echo base_url("assets/css/custom.css") ?>">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

</head>

<body>
  <?php
  if (!empty($header)) {
    $this->load->view($header);
  }
  if (!empty($body)) {
    $this->load->view($body);
  }
  ?>
  <script>
    base_url = '<?php echo base_url(); ?>';
  </script>
  
  <script src="<?php echo base_url("assets/js/custom.js") ?>"></script>
</body>

</html>