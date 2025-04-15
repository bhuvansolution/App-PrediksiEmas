<nav class="navbar navbar-expand navbar-light shadow senkatech-navbar mb-4 static-top">
    <!-- Sidebar Toggle (senkatech-navbar) -->
    <button id="sidebarToggle" class="btn btn-link  rounded-circle">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav mr-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img src="assets/images/navbar/menu-navbar.png" class="senkatech-ikon">&nbsp;Menu
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2">
                            <span class="text-uppercase "><img src="assets/images/navbar/menu.png"
                                    class="senkatech-ikon">&nbsp;Menu 1</span>
                            <div class="dropdown-divider"></div>
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="dropdown-item" href="form_v1.html"><img
                                            src="assets/images/navbar/list.png">&nbsp;Form V1</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="form_v2.html"><img
                                            src="assets/images/navbar/list.png">&nbsp;Form V2</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dropdown-item" href="form_v3.html"><img
                                            src="assets/images/navbar/list.png">&nbsp;Form V3</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <div class="senkatech-navbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Sukma Mangar SP</span>
                <img class="img-profile rounded-circle" src="assets/images/user.png">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="list_permission.html.html">
                    <i class="far fa-list-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Perms List
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="create_permission.html">
                    <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                    Perms Form
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="list_group.html">
                    <i class="far fa-list-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Group List
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="create_group.html">
                    <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                    Group Form
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="list_user.html">
                    <i class="far fa-list-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    User List
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="create_user.html">
                    <i class="fas fa-edit fa-sm fa-fw mr-2 text-gray-400"></i>
                    User Form
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-red-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
