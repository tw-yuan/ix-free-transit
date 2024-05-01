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
              <h5 class="card-title fw-semibold mb-4">BGP Session</h5>
              <a href="?action=create"><button type="button"
                  class="btn btn-dark m-1">Create</button></a>
              <div class="table-responsive">
                <table class="table text-nowrap mb-0 align-middle">
                  <thead class="text-dark fs-4">
                    <tr>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">IX ID</h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Your ASN</h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Your IP</h6>
                      </th>
                      <th class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">Status</h6>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    {foreach from=$session_list key=myId item=i}
                      <tr>
                        <td class="border-bottom-0">
                          <h6 class="fw-semibold mb-1">{$i.pdb_ix_id}</h6>
                        </td>
                        <td class="border-bottom-0">
                          <h6 class="fw-semibold mb-1">{$i.asn}</h6>
                        </td>
                        <td class="border-bottom-0">
                          <h6 class="fw-semibold mb-1">{$i.ip}</h6>
                        </td>
                        <td class="border-bottom-0">
                          <div class="d-flex align-items-center gap-2">
                            {if $i.status == 'configured'}
                              <span class="badge bg-success rounded-3 fw-semibold">Configured</span>
                            {else}
                              <span class="badge bg-warning rounded-3 fw-semibold">Pending</span>
                            {/if}
                          </div>
                        </td>
                      </tr>
                    {/foreach}
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        <div class="card">
          <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Our Information</h5>
            <p class="mb-3"> There are our information about the internet exchange.
            </p>
            <div class="table-responsive">
              <table class="table text-nowrap mb-0 align-middle">
                <thead class="text-dark fs-4">
                  <tr>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">IX ID</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">IX Name</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Our ASN</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Our IPv4</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Our IPv6</h6>
                    </th>
                    <th class="border-bottom-0">
                      <h6 class="fw-semibold mb-0">Speed</h6>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  {foreach from=$ix_list key=myId item=i}
                    <tr>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{$i.pdb_ix_id}</h6>
                      </td>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{$i.name}</h6>
                      </td>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{$asn}</h6>
                      </td>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{$i.ix_lan_v4}</h6>
                      </td>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{$i.ix_lan_v6}</h6>
                      </td>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-1">{$i.speed} Mbps</h6>
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