@extends('layout.master')
 
@section('content')
<?php 

 $project = \DB::table('projects')->where('id',$data->project_id)->first();
?>
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">{{ $title }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Add {{ $title }}</li>
          </ol>
          {{-- <h6 class="font-weight-bolder mb-0">Tables</h6> --}}
        </nav>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2 pb-2 text-white text-capitalize ps-3" style="width:100%;float:left">
                {{ $title }} Details
              </div>
            </div>
            <div class="card-body">
              <form action="{{ url('/')}}/store_sublayouts" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!} 
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="oldpassword">Main Layout Image<span style="color:red;" >*</span></label>
                            <p>
                                <img id="output_image1" height="200px" width="300px" src="{{ Config::get('DocumentConstant.MAIN_LAYOUT_VIEW') }}{{ $project->main_layout_image }}" />
                            </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="oldpassword">Sub Layout Image<span style="color:red;" >*</span></label>
                            <p>
                                <img id="output_image1" height="200px" width="300px" src="{{ Config::get('DocumentConstant.LAYOUT_VIEW') }}{{ $data->images }}" />
                                <input type="hidden" name="project_id" value="{{ $data->project_id }}">
                                <input type="hidden" name="layout_id" value="{{ $data->id }}">
                            </p>
                    </div>
                </div>
              </div>

               <div class="bg-gradient-primary shadow-primary border-radius-lg pt-2 pb-2 text-white text-capitalize ps-3" style="width:100%;float:left">
                More Layouts for Sub Layouts
               </div>
               <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="oldpassword">Layout Images<span style="color:red;" >*</span></label>
                          <p>
                          <img id="output_image1" height="200px" width="300px" src="{{asset('assets/img/top.jpeg')}}" />
                          </p>
                          <div class="input-group input-group-outline mb-3">
                          <input type="file"  name="sublayout_images[]" accept="image/*" required="true" multiple>
                          <input type="hidden" id="count" name="cnt">
                        </div>
                  </div>
              </div>
              </div>
              <div class="box-footer">
                    <button type="submit" class="btn btn-primary" style="float: right">Submit</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
<script>
// //to get count of rows
//   var count = 0;
//   var button = document.getElementById("addRowid");
//   button.addEventListener("click", function() {
//       count++;
//       document.getElementById("count").value=count;
//   });
//to add rows in table
  function addRow(id,field)
  {
    const table = document.getElementById('dynamic-table'+id).getElementsByTagName('tbody')[0];
    const newRow = table.insertRow(table.rows.length);
    const rowId = table.rows.length;
    const index = rowId-1;
    const cell1 = newRow.insertCell(0);
    const cell2 = newRow.insertCell(1);
    const cell3 = newRow.insertCell(2);

    // Add content to the new cells (you can customize this part as needed)
    cell1.innerHTML = '<div class="input-group input-group-outline mb-3"><input type="text" placeholder="Enter Value" name="'+field+'name[]" class="form-control"></div>';
    cell2.innerHTML = '<div class="input-group input-group-outline mb-3"><input type="file"  name="'+field+'images_'+index+'[]" accept="image/*" multiple></div>';
    cell3.innerHTML = '<button class="btn btn-danger" onclick="deleteRow(this,'+id+')">Remove</button>';
  }

  function deleteRow(button,id)
  {
    const row = button.parentNode.parentNode;
    const table = document.getElementById('dynamic-table'+id).getElementsByTagName('tbody')[0];
    table.deleteRow(row.rowIndex);
  }
</script>
@endsection