<?php include"header.php"; ?>
    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php include"leftSideBar.php";?>

            <div id="page-wrapper">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">26</div>
                                        <div>New Comments!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">12</div>
                                        <div>New Tasks!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-shopping-cart fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">124</div>
                                        <div>New Orders!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-support fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">13</div>
                                        <div>Support Tickets!</div>
                                    </div>
                                </div>
                            </div>
                            <a href="#">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>

                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
					
                        <div class="panel panel-default">
                             <div class="panel-heading">
                                 <h4><i class="fa fa-bar-chart-o fa-fw"></i> &nbsp; &nbsp;POLLS table (Generated By People)</h4>
                                <!--div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                                data-toggle="dropdown">
                                            Actions
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="#">Action</a>
                                            </li>
                                            <li><a href="#">Another action</a>
                                            </li>
                                            <li><a href="#">Something else here</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div-->
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                               
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Generator's name</th>
												<th>Problem</th>
                                                <th>Address</th>
                                                <th>Images</th>
                                                <th>Discription</th>
												<th>View / Edit</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd gradeX">
                                                <td>Rohit</td>
                                                <td>Road </td>
                                                <td>Canal road</td>
												 <td>Win 95+</td>
                                                <td class="center">4</td>
												<td class="center"><a href="" >Edit</a>&nbsp;|&nbsp;<a href="" >View</a>  </td>
                                                <td class="center"><button class="btn-success btn">Accept</button> |&nbsp;<button class="btn-danger btn">Delete</button></td>
                                            </tr>
                                           
                                          
                                           
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                           
                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
							   <div class="panel panel-default">
                             <div class="panel-heading">
                                 <h4><i class="fa fa-bar-chart-o fa-fw"></i> &nbsp; &nbsp;Users</h4>
                                <!--div class="pull-right">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default btn-xs dropdown-toggle"
                                                data-toggle="dropdown">
                                            Actions
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu pull-right" role="menu">
                                            <li><a href="#">Action</a>
                                            </li>
                                            <li><a href="#">Another action</a>
                                            </li>
                                            <li><a href="#">Something else here</a>
                                            </li>
                                            <li class="divider"></li>
                                            <li><a href="#">Separated link</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div-->
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                               
                                <div class="dataTable_wrapper">
                                    <table class="table table-striped table-bordered table-hover" id="userTable">
                                        <thead>
                                            <tr>
                                                <th>First Name</th>
												<th>Last Name</th>
                                                <th>Email</th>
                                                <th>Gender</th>
                                                <th>Number</th>
												<th>Address</th>
                                                <th>Profile Pic.</th>
												   <th>Email verified.</th>
												 <th>Joined Date</th>
												  <th>Edit / View</th>
												 <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="odd gradeX">
                                                <td>Rohit</td>
												 <td>Verma</td>
                                                <td>Road@gmail.com </td>
                                                <td>male</td>
												 <td>656877677</td>
												 <td>canal road</td>
												 <td>image</td>
												 <td>Email verified</td>
                                                <td class="center">4</td>
												<td class="center"><a href="editDetails.php" >Edit</a>&nbsp;|&nbsp;<a href="viewDetails.php" >View</a>  </td>
                                                <td class="center"><button class="btn-success btn">Accept</button> |&nbsp;<button class="btn-danger btn">Delete</button></td>
                                            </tr>
                                           
                                          
                                           
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                           
                            </div>
                            <!-- /.panel-body -->
                        </div>
                    </div>
                    <!-- /.col-lg-2 -->
                
                </div>
                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

      

        <!-- Metis Menu Plugin JavaScript -->
        <script src="../assets/js/metisMenu.min.js"></script>

        <!-- Morris Charts JavaScript -->
        <script src="../assets/js/raphael.min.js"></script>
       
        <!-- Custom Theme JavaScript -->
        <script src="../assets/js/startmin.js"></script>
 <!-- DataTables JavaScript -->
        <script src="../assets/js/dataTables/jquery.dataTables.min.js"></script>
        <script src="../assets/js/dataTables/dataTables.bootstrap.min.js"></script>
		  <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                        responsive: true
                });
            });
			 $(document).ready(function() {
                $('#userTable').DataTable({
                        responsive: true
                });
            });
        </script>
    </body>
</html>
