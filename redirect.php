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
                        Posting with CSV
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
                    <!-- BODY -->
                      <div id="generalContent">
                          <!-- Upload CSV -->
                            <div class="col-lg-12">
                              <h4 id="buttons" class="page-header">Posting from CSV</h4>
                              <form method="post" action="modules/redirects/redirect.php" enctype="multipart/form-data" id="testform">

                                <div class="form-group col-lg-4">
                                  <label>seleccisione el archivo a subir</label>
                                  <div class="form-group input-group">
                                    <input  type='file' value='' id='orden-prod' name='inputCsv'  class='btn' />
                                  </div>
                                  <p class="help-block">Example block-level help text here.</p>
                                </div>
                               
                               <div class="form-group col-lg-4">
                                  <label>Prefix</label>
                                  <div class="form-group input-group">
                                    <span class="input-group-addon">Prefix</span>
                                    <input type="text" class="form-control" value="" name="prefix" id='selectedQuantity' placeholder='ej: PROC-123_italia'>
                                  </div>
                                  <p class="help-block">Example block-level help text here.</p>
                                </div>

                                <div class="form-group col-lg-3">
                                   <input name="boton" type="submit" id="" value="Subir" class="btn btn-default btn-lg btn-block btn-danger" style="margin:20px">
                                </div>

                             </form>
                            </div>
                          <!-- //Upload CSV -->
                      </div>
                    <!-- BODY -->    
                    </div>   <!-- /.row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div>
    <!--// wrapper -->
    <?php include('template/footer_scripts.php'); ?>    
    </body>
</html>

