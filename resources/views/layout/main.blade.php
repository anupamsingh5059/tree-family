<!DOCTYPE html>
<html lang="en">
  <!-- [Head] start -->
  <head>
    <title>Tree </title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Mantis is made using Bootstrap 5 design framework. Download the free admin template & use it for your project.">
    <meta name="keywords" content="Mantis, Dashboard UI Kit, Bootstrap 5, Admin Template, Admin Dashboard, CRM, CMS, Bootstrap Admin Template">
    <meta name="author" content="CodedThemes">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.svg')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/css/plugins/style.css')}}" >
    <!-- [Google Font] Family -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" id="main-font-link">
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{asset('assets/fonts/tabler-icons.min.css')}}" >
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{asset('assets/fonts/feather.css')}}" >
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{asset('assets/fonts/fontawesome.css')}}" >
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{asset('assets/fonts/material.css')}}" >
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}" id="main-style-link" >
    <link rel="stylesheet" href="{{asset('assets/css/style-preset.css')}}" >

  </head>
  <!-- [Head] end -->
  <!-- [Body] Start -->
  <body data-pc-preset="preset-1" data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header">
    <h4>  Family Tree  Admin</h4>
    </div>
    <div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item">
          <a href="#" class="pc-link">
            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
            <span class="pc-mtext">Dashboard</span>
          </a>
        </li>

        

        <li class="pc-item pc-caption">
          <label>Pages</label>
          <i class="ti ti-news"></i>
        </li>
        <li class="pc-item">
          <a href="{{url('fetchall-tree')}}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-lock"></i></span>
            <span class="pc-mtext">Show Tree</span>
          </a>
        </li>
        <!-- <li class="pc-item">
          <a href="{{url('create-tree')}}" class="pc-link">
            <span class="pc-micon"><i class="ti ti-user-plus"></i></span>
            <span class="pc-mtext">Create Tree</span>
          </a>
        </li> -->

       
      </ul>
    
    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <!-- ======= Menu collapse Icon ===== -->
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="dropdown pc-h-item d-inline-flex d-md-none">
      <a
        class="pc-head-link dropdown-toggle arrow-none m-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <i class="ti ti-search"></i>
      </a>
      <div class="dropdown-menu pc-h-dropdown drp-search">
        <form class="px-3">
          <!-- <div class="form-group mb-0 d-flex align-items-center">
            <i data-feather="search"></i>
            <input type="search" class="form-control border-0 shadow-none" placeholder="Search here. . .">
          </div> -->
        </form>
      </div>
    </li>
   
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
   
    
  
   
   
    <li class="dropdown pc-h-item header-user-profile">
       <a  href="{{route('logout')}}"
        class="btn btn-info"
      
       
       
      >
       
        <span>Logout</span>
      </a> 
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header">
          <div class="d-flex mb-1">
            <div class="flex-shrink-0">
              <img src="../assets/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35">
            </div>
            <div class="flex-grow-1 ms-3">
              <h6 class="mb-1">Tree </h6>
              <span></span>
            </div>
            <a href="#!" class="pc-head-link bg-transparent"><i class="ti ti-power text-danger"></i></a>
          </div>
        </div>
        <ul class="nav drp-tabs nav-fill nav-tabs" id="mydrpTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button
              class="nav-link active"
              id="drp-t1"
              data-bs-toggle="tab"
              data-bs-target="#drp-tab-1"
              type="button"
              role="tab"
              aria-controls="drp-tab-1"
              aria-selected="true"
              ><i class="ti ti-user"></i> Profile</button
            >
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="drp-t2"
              data-bs-toggle="tab"
              data-bs-target="#drp-tab-2"
              type="button"
              role="tab"
              aria-controls="drp-tab-2"
              aria-selected="false"
              ><i class="ti ti-settings"></i> Setting</button
            >
          </li>
        </ul>
        <div class="tab-content" id="mysrpTabContent">
          <div class="tab-pane fade show active" id="drp-tab-1" role="tabpanel" aria-labelledby="drp-t1" tabindex="0">
            <a href="#!" class="dropdown-item">
              <i class="ti ti-edit-circle"></i>
              <span>Edit Profile</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-user"></i>
              <span>View Profile</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-clipboard-list"></i>
              <span>Social Profile</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-wallet"></i>
              <span>Billing</span>
            </a>
            <a href="{{ route('logout') }}" class="dropdown-item">
              <i class="ti ti-power"></i>
              <span>Logout</span>
            </a>
          </div>
          <div class="tab-pane fade" id="drp-tab-2" role="tabpanel" aria-labelledby="drp-t2" tabindex="0">
            <a href="#!" class="dropdown-item">
              <i class="ti ti-help"></i>
              <span>Support</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-user"></i>
              <span>Account Settings</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-lock"></i>
              <span>Privacy Center</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-messages"></i>
              <span>Feedback</span>
            </a>
            <a href="#!" class="dropdown-item">
              <i class="ti ti-list"></i>
              <span>History</span>
            </a>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>
 </div>
</header>
<!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <section class="pc-container">
       @yield('pc-container')
      <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
          <div class="page-block">
            <div class="row align-items-center">
              <div class="col-md-12">
                <ul class="breadcrumb">
                  <!-- <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                  <li class="breadcrumb-item"><a href="javascript: void(0)">Table</a></li>
                  <li class="breadcrumb-item" aria-current="page">Render Column Cells</li> -->
                </ul>
              </div>
              <!-- <div class="col-md-12">
                <div class="page-header-title">
                  <h2 class="mb-0">Family Tree</h2>
                </div>
              </div> -->
            </div>
          </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
          <!-- [ basic-table ] start -->
          
          <!-- [ basic-table ] end -->
        </div>
        <!-- [ Main Content ] end -->
      </div>
    </section>
    <!-- [ Main Content ] end -->
    <footer class="pc-footer">
      <div class="footer-wrapper container-fluid">
        <div class="row">
          <div class="col-sm my-1">
            
          </div>
          <!-- <div class="col-auto my-1">
            <ul class="list-inline footer-link mb-0">
              <li class="list-inline-item"><a href="../index.html">Home</a></li>
              <li class="list-inline-item"><a href="https://codedthemes.gitbook.io/mantis-bootstrap" target="_blank">Documentation</a></li>
              <li class="list-inline-item"><a href="https://codedthemes.authordesk.app/" target="_blank">Support</a></li>
            </ul>
          </div> -->
        </div>
      </div>
    </footer> <!-- Required Js -->
<script src="{{asset('assets/js/plugins/popper.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/simplebar.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/fonts/custom-font.js')}}"></script>
<script src="{{asset('assets/js/pcoded.js')}}"></script>
<script src="{{asset('assets/js/plugins/feather.min.js')}}"></script>





<!-- <script>layout_change('light');</script>




<script>change_box_container('false');</script>



<script>layout_rtl_change('false');</script>


<script>preset_change("preset-1");</script>


<script>font_change("Public-Sans");</script> -->

    
 <!-- <div class="offcanvas pct-offcanvas offcanvas-end" tabindex="-1" id="offcanvas_pc_layout">
  <div class="offcanvas-header bg-primary">
    <h5 class="offcanvas-title text-white">Mantis Customizer</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="pct-body" style="height: calc(100% - 60px)">
    <div class="offcanvas-body">
      <ul class="list-group list-group-flush">
        <li class="list-group-item">
          <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse1">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="avtar avtar-xs bg-light-primary">
                  <i class="ti ti-layout-sidebar f-18"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-1">Theme Layout</h6>
                <span>Choose your layout</span>
              </div>
              <i class="ti ti-chevron-down"></i>
            </div>
          </a>
          <div class="collapse show" id="pctcustcollapse1">
            <div class="pct-content">
              <div class="pc-rtl">
                <p class="mb-1">Direction</p>
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" role="switch" id="layoutmodertl">
                  <label class="form-check-label" for="layoutmodertl">RTL</label>
                </div>
              </div>
            </div>
          </div>
        </li>
        <li class="list-group-item">
          <a class="btn border-0 text-start w-100" data-bs-toggle="collapse" href="#pctcustcollapse2">
            <div class="d-flex align-items-center">
              <div class="flex-shrink-0">
                <div class="avtar avtar-xs bg-light-primary">
                  <i class="ti ti-brush f-18"></i>
                </div>
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-1">Theme Mode</h6>
                <span>Choose light or dark mode</span>
              </div>
              <i class="ti ti-chevron-down"></i>
            </div>
          </a>
          <div class="collapse show" id="pctcustcollapse2">
            <div class="pct-content">
              <div class="theme-color themepreset-color theme-layout">
                <a href="#!" class="active" onclick="layout_change('light')" data-value="false"
                  ><span><img src="../assets/images/customization/default.svg" alt="img"></span><span>Light</span></a
                >
                <a href="#!" class="" onclick="layout_change('dark')" data-value="true"
                  ><span><img src="../assets/images/customization/dark.svg" alt="img"></span><span>Dark</span></a
                >
              </div>
            </div>
          </div>
        </li>
       
        
        
      
      </ul>
    </div>
  </div>
</div> -->

    <!-- [Page Specific JS] start -->
    <!-- <script src="{{asset('assets/js/plugins/simple-datatables.js')}}"></script> -->
    <!-- <script>
      const data = {
        headings: ['ID', 'Drink', 'Price', 'Caffeinated', 'Profit'],
        data: [
          [574, 'latte', 4.0, false, 0.0],
          [984, 'herbal tea', 3.0, false, 0.56],
          [312, 'green tea', 3.0, true, 1.72],
          [312, 'latte', 3.0, true, -1.21],
          [312, 'green tea', 3.0, false, 0.0],
          [312, 'green tea', 3.0, false, 0.0],
          [312, 'green tea', 3.0, true, 1.72],
          [312, 'latte', 3.0, true, 1.72],
          [312, 'green tea', 3.0, true, -1.21],
          [312, 'green tea', 3.0, false, 0.0],
          [312, 'green tea', 3.0, true, 1.72],
          [312, 'green tea', 3.0, true, 1.72],
          [312, 'latte', 3.0, false, 0.0],
          [312, 'latte', 3.0, true, 1.72],
          [312, 'green tea', 3.0, false, 0.0],
          [312, 'green tea', 3.0, true, 1.72],
          [312, 'latte', 3.0, false, 0.0],
          [312, 'latte', 3.0, true, -1.21],
          [312, 'latte', 3.0, true, 1.72],
          [312, 'latte', 3.0, false, 0.0],
          [312, 'latte', 3.0, false, 0.0],
          [312, 'latte', 3.0, true, 1.72],
          [312, 'green tea', 3.0, true, -1.21],
          [312, 'green tea', 3.0, true, -1.21],
          [312, 'green tea', 3.0, true, -1.21]
        ]
      };
      // Add Icon
      const renderIcon = function (data, _cell, _dataIndex, _cellIndex) {
        if (data == 'latte') {
          return `🔥 ${data}`;
        }
        return `🌿 ${data}`;
      };
      // Price column cell manipulation
      const renderButton = function (data, cell, dataIndex, _cellIndex) {
        cell.childNodes.push({
          nodeName: 'BUTTON',
          attributes: {
            'data-row': dataIndex,
            class: 'btn btn-success btn-sm ms-3'
          },
          childNodes: [
            {
              nodeName: '#text',
              data: 'Buy Now'
            }
          ]
        });
      };
      // Caffeinated column cell manipulation
      const renderYesNo = function (data, cell, _dataIndex, _cellIndex) {
        if ([true, false].includes(data)) {
          cell.childNodes = [
            {
              nodeName: 'B',
              childNodes: [
                {
                  nodeName: '#text',
                  data: data === true ? ' Yes ' : ' No '
                }
              ]
            }
          ];
        }
      };

      // numbers
      const renderHighLow = function (data, cell, _dataIndex, _cellIndex) {
        const cellTextNode = cell.childNodes[0];
        const currencyNode = {
          nodeName: 'SPAN',
          attributes: {
            class: 'currency '
          },
          childNodes: [cellTextNode]
        };
        cell.childNodes = [currencyNode];

        if (data < 0) {
          currencyNode.attributes.class += 'text-danger';
        } else if (data > 0) {
          currencyNode.attributes.class += 'text-success';
        } else if (data == 0) {
          currencyNode.attributes.class += 'text-body';
        }
      };
      new window.simpleDatatables.DataTable('#pc-dt-render-column-cells', {
        data,
        perPage: 25,
        rowRender: (row, tr, _index) => {
          if ([true, false].includes(row[3].data)) {
            if (!tr.attributes?.class) {
              if (!tr.attributes) {
                tr.attributes = {};
              }
              tr.attributes.class = row[3].data === true ? 'text-success' : 'text-danger';
            } else {
              tr.attributes.class += row[3].data === true ? 'text-success' : 'text-danger';
            }
          }
        },
        columns: [
          {
            select: 0,
            hidden: true,
            type: 'number'
          },
          {
            select: 1,
            render: renderIcon,
            type: 'string'
          },
          {
            select: 2,
            render: renderButton,
            type: 'number'
          },
          {
            select: 3,
            render: renderYesNo,
            type: 'boolean'
          },
          {
            select: 4,
            render: renderHighLow,
            type: 'number'
          }
        ]
      });
    </script> -->

    <!-- [Page Specific JS] end -->
  </body>
  <!-- [Body] end -->
</html>
