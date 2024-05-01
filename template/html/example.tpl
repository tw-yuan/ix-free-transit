<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>NCSE Transit Manager</title>
  <link rel="shortcut icon" type="image/png" href="../template/assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="./template/assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    {include file="./sidebar.tpl"}
    <!--  Main wrapper -->
    <div class="body-wrapper">
      {include file="./header.tpl"}
      <div class="container-fluid">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Sample Page</h5>
            <p class="mb-0">This is a sample page </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  {include file="./script.tpl"}
</body>

</html>