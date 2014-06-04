<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('template/head.php'); ?>
    </head>
    <body class="skin-black">

    <!-- header logo: style can be found in header.less -->
        <?php include('template/header.php'); ?>
    <!--// header logo: style can be found in header.less -->

    <!-- WRAPPER -->
        <div class="wrapper row-offcanvas row-offcanvas-left">

            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
            <!-- sidebar: style can be found in sidebar.less -->
                <?php include('template/menu.php'); ?>
            <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        General Form Elements
                        <small>Preview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Forms</a></li>
                        <li class="active">General Elements</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">                            
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Data Table With Full Features</h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <?php echo $_SESSION['datos_tabla']; ?>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
            </aside><!-- /.right-side -->
    <!--// wrapper -->
    <?php include('template/footer_scripts.php'); ?>    
    </body>
</html>
