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
        {$login_notice}
        <div class="card">
          <div class="card-body">
            <h3 class="fw-semibold mb-3">Welcome to NCSE Transit Manager!</h3>
            <p class="mb-0">This is a platform for downstream create and manage transit session on Internaet eXchange.
            </p>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title">Session</h5>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">{$session_count}</h5>
                      <p class="card-text">session(s) created.</p>
                      <a href="./session.php" class="btn btn-primary">View Sessions</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title">Prefix</h5>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">{$prefix_count}</h5>
                      <p class="card-text">Prefix(es) added.</p>
                      <a href="./prefix.php" class="btn btn-primary">View Prefixes</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="card">
                    <div class="card-header">
                      <h5 class="card-title">Network (ASN)</h5>
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">{$network_count}</h5>
                      <p class="card-text">Network(s) registered.</p>
                      <a href="./network.php" class="btn btn-primary">View Networks</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card mb-0">
          <div class="card-body">
            <form>
              <fieldset disabled>
                <legend class="text-dark">User Infomation</legend>
                <div class="mb-3">
                  <p class="mb-0">If you need any assistance about this platform, we may ask the info below.</p>
                </div>
                <div class="mb-3">
                  <label for="disabledTextInput" class="form-label">User ID</label>
                  <input type="text" id="userid" class="form-control" value="{$userid}">
                </div>
                <div class="mb-3">
                  <label for="disabledTextInput" class="form-label">Email</label>
                  <input type="text" id="email" class="form-control" value="{$email}">
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  {include file="./script.tpl"}
</body>

</html>