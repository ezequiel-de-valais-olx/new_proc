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

    <!-- LOCATION -->
      <div class="col-lg-12">
        <h4 id="buttons" class="page-header">Location</h4>
        <table class="table table-bordered table-hover table-striped tablesorter">
          <thead>
            <tr>
              <th>Country<i class="fa"></i></th>
              <th>State<i class="fa"></i></th>
              <th>Cities<i class="fa"></i></th>
              <th>Neighborhood<i class="fa"></i></th>
            </tr>
          </thead>
          <tbody>
            <tr class="active">
              <td>
                <div class="btn-group col-lg-12">
                  <button type="button" class="btn btn-primary" id="selectedCountry">chose one </button>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul id="CountryList" class="dropdown-menu">

                  </ul>
                </div><!-- /btn-group -->
              </td>
              <td>
                <div class="btn-group col-lg-12" id="contentSelectedState">
                  <button type="button" class="btn btn-primary" id="selectedState">chose one </button>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul id="stateList" class="dropdown-menu">
                                             
                  </ul>
                </div>
              </td>
              <td>
                <div class="btn-group col-lg-12" id="contentSelectedCities">
                  <button type="button" class="btn btn-primary" id="selectedCity">chose one </button>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul id="citiesList" class="dropdown-menu">

                  </ul>
                </div>                      
              </td>
              <td>
                <div class="btn-group col-lg-12" id="contentSelectedNeighborhood">
                  <button type="button" class="btn btn-primary" id="selectedNeighborhood">chose one </button>
                  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                  <ul id="neighborhoodList" class="dropdown-menu">

                  </ul>
                </div>                      
              </td>
            </tr>
          </tbody>
        </table>               
      </div>
    <!-- //LOCATION -->
    <!-- SETTING -->
      <h4 id="buttons" class="page-header col-lg-12">Settings</h4>              
        <div class="form-group col-lg-4">
          <label>email</label>
          <div class="form-group input-group">
            <span class="input-group-addon">@</span>
            <input type="text" class="form-control" value="bot@olx.com" id='selectedEmail'>
          </div>
          <p class="help-block">By default it is 'bot@olx.com'</p>
        </div>

          <div class="form-group col-lg-4">
            <label>cantidad</label>
            <div class="form-group input-group">
              <span class="input-group-addon">Q</span>
              <input type="text" class="form-control" value="5" id='selectedQuantity'>
            </div>
            <p class="help-block">Example block-level help text here.</p>
          </div>

          <div class="form-group col-lg-3">
            <button id="sendAll" type="button" class="btn btn-default btn-lg btn-block btn-danger" style="margin:20px">Post adds</button>
          </div>
    <!-- //SETTING --> 
    <!-- BODY -->
      <div id="generalContent">

          <!-- Upload CSV -->
            <div class="col-lg-12">
              <h4 id="buttons" class="page-header">Posting from CSV</h4>
              <form method="post" action="includes/print_tabla.php" enctype="multipart/form-data" id="testform">
                <div class=''>seleccisione el archivo a subir</div>
                <input  type='file' value='' id='orden-prod' name='archivo'  class='btn' />
                <input name="boton" type="submit" id="" value="Subir" class="btn btn-default btn-lg btn-block btn-danger" style="margin:20px">
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

