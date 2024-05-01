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
        <div class="card w-100">
          <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Your Network Information</h5>
            <!--<a href="./session.php?action=create"><button type="button"
                  class="btn btn-outline-secondary m-1">Edit AS-SET</button></a>-->
            <div class="table-responsive">
              <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                  <tr>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Network ID</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">ASN</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Name</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Action</h6>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  {foreach from=$network_list key=myId item=i}
                    <tr>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{$i.pdb_network_id}</h6>
                      </td>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{$i.asn}</h6>
                      </td>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{$i.name}</h6>
                      </td>
                      <td class="border-bottom-0">
                        <a href="https://www.peeringdb.com/net/{$i.pdb_network_id}"><button type="button" class="btn btn-outline-info m-1">PeeringDB</button></a>
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