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
                        Read CSV
                        <small>Preview</small>
                    </h1>
                    <!--
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Forms</a></li>
                        <li class="active">General Elements</li>
                    </ol>
                    -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Quick Example</h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form role="form" method="post" action="modules/read_csv/print_tabla.php" enctype="multipart/form-data" id="testform">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">File input</label>
                                            <input type='file' value='' id='orden-prod' name='archivo'  class='btn' />
                                            <p class="help-block">Example block-level help text here.</p>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div><!-- /.box -->

                        </div><!--/.col (left) -->

                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div>
    <!--// wrapper -->
    <?php include('template/footer_scripts.php'); ?>    
    </body>
</html>

