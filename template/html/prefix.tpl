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
            <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
              <h5 class="card-title fw-semibold mb-4">Prefix(es) List</h5>
              <p class="mb-3"> All prefix(es) must provide LOA and matching IRR record.<br>If you need Vultr (AS20473)
                transit, please contact us and sign RPKI for AS204844.
              </p>
              <a href="?action=new"><button type="button" class="btn btn-dark m-3">Add New</button></a>
              <a href="https://jodies.de/ipcalc" target="_blank"><button type="button" class="btn btn-primary m-3">IP Calculator</button></a>
            </div>
            <div class="table-responsive">
              <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                  <tr>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Prefix(es)</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Max Length</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Status</h6>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  {foreach from=$prefix_list key=myId item=i}
                    <tr>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{$i.prefix}</h6>
                      </td>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{$i.maxLength}</h6>
                      </td>
                      <td class="border-bottom-0">
                        {if $i.status == 'accepted'}
                          <span class="badge bg-success rounded-3 fw-semibold">Accepted</span>
                        {else}
                          <span class="badge bg-warning rounded-3 fw-semibold">Pending</span>
                        {/if}
                      </td>
                    </tr>
                  {/foreach}
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {include file="./script.tpl"}
</body>

</html>