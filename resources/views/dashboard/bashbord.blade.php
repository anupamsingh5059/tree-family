@extends('layout.main')

@section('pc-container')
   <!-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/css/bootstrap.min.css' /> -->
  <link rel='stylesheet'
    href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css' />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.css" />
  

  <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Tree Family</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="add_employee_form" enctype="multipart/form-data">
        @csrf
      

        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="fname"> Name</label>
              <input type="text" name="name"  class="form-control" placeholder="Enter Name" >

               <span class="text-danger" id="name_error"></span>
            </div>
          
          </div>
         
          <div class="my-2">
            <label for="phone">Relation</label>
           <input type="text" name="relation"  class="form-control" placeholder="Relation" >
          </div>
          <span class="text-danger" id="relation_error"></span>
          <div class="my-2">
            <label for="post">Parents_ID</label>
            <input type="text" name="parent_id"  class="form-control" placeholder="Parent_id" >
          </div>
           <span class="text-danger" id="parent_id_error"></span>
          <div class="my-2">
            <label for="image">Select Image</label>
            <input type="file" name="image" class="form-control">
             <span class="text-danger" id="image_error"></span>
          </div>
          
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="add_employee_btn" class="btn btn-primary">Add Tree</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- add new employee modal end --}}
{{-- edit employee modal start --}}
<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel"
  data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Tree</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="#" method="POST" id="edit_employee_form" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="emp_id" id="emp_id">
        <input type="hidden" name="mem_image" id="mem_image">
        <div class="modal-body p-4 bg-light">
          <div class="row">
            <div class="col-lg">
              <label for="fname"> Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" required>
            </div>
          
          </div>
         
          <div class="my-2">
            <label for="phone">Relation</label>
            <input type="text" name="relation" id="relation" class="form-control" placeholder="Relation" required>
          </div>
          <div class="my-2">
            <label for="post">Parents_ID</label>
            <input type="text" name="parent_id" id="parent_id" class="form-control" placeholder="Parent_id" required>
          </div>
          <div class="my-2">
            <label for="avatar">Select Image</label>
            <input type="file" name="image" class="form-control">
          </div>
          <div class="mt-2" id="image">
          
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" id="edit_employee_btn" class="btn btn-success">Update Tree</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- edit Family modal end --}}
<body class="bg-light">
  <div class="container">
    <div class="row my-5">
      <div class="col-lg-12">
        <div class="card shadow">
          <div class="card-header bg-danger d-flex justify-content-between align-items-center">
            <h3 class="text-light">Manage Tree Family</h3>
            <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addEmployeeModal"><i
                class="bi-plus-circle me-2"></i>Add New Family</button>
          </div>
          <div class="card-body" id="show_all_employees">
            <h1 class="text-center text-secondary my-5">Loading...</h1>
          </div>
        </div>
      </div>
    </div>
  </div>







  @endsection

   
 <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.2/js/bootstrap.bundle.min.js'></script>
  <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.10.25/datatables.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    $(function() {
      // add new employee ajax request
      $("#add_employee_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        // $('#add_employee_form')[0].reset();
        //  $(".text-danger").text("");
        $("#add_employee_btn").text('Adding...');
        $.ajax({
          url: "{{ route('store') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Added!',
                'Family Added Successfully!',
                'success'
              )
              fetchAllEmployees();
            }
            $("#add_employee_btn").text('Add Family');
            $("#add_employee_form")[0].reset();
            $("#addEmployeeModal").modal('hide');
          },

           error: function(xhr) {
    if (xhr.status === 422) {
        $(".text-danger").text(""); // clear old errors
        let errors = xhr.responseJSON.errors;
        $.each(errors, function(key, value) {
            $("#" + key + "_error").text(value[0]);
        });
    }
}

        });
      });
      // edit employee ajax request
      $(document).on('click', '.editIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        $.ajax({
          url: "{{ route('edit') }}",
          method: 'get',
          data: {
            id: id,
            _token: '{{ csrf_token() }}'
          },
          success: function(response) {
             $("#name").val(response.name);
            // console.log(name);
            // alert(name);
            $("#relation").val(response.relation);
              $("#parent_id").val(response.parent_id);
               $("#image").html(
              `<img src="uploads/${response.image}" width="200" class="img-fluid img-thumbnail">`);
         
            $("#mem_image").val(response.image);
            $("#emp_id").val(response.id);
           
          }
        });
      });
      // update employee ajax request
      $("#edit_employee_form").submit(function(e) {
        e.preventDefault();
        const fd = new FormData(this);
        $("#edit_employee_btn").text('Updating...');
        $.ajax({
          url: "{{ route('update') }}",
          method: 'post',
          data: fd,
          cache: false,
          contentType: false,
          processData: false,
          dataType: 'json',
          success: function(response) {
            if (response.status == 200) {
              Swal.fire(
                'Updated!',
                'Updated Successfully!',
                'success'
              )
              fetchAllEmployees();
            }
            $("#edit_employee_btn").text('Update Employee');
            $("#edit_employee_form")[0].reset();
            $("#editEmployeeModal").modal('hide');
          }
        });
      });
      // delete employee ajax request
      $(document).on('click', '.deleteIcon', function(e) {
        e.preventDefault();
        let id = $(this).attr('id');
        let csrf = '{{ csrf_token() }}';
        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: "{{ route('delete') }}",
              method: 'delete',
              data: {
                id: id,
                _token: csrf
              },
              success: function(response) {
                console.log(response);
                Swal.fire(
                  'Deleted!',
                  'Your file has been deleted.',
                  'success'
                )
                fetchAllEmployees();
              }
            });
          }
        })
      });
      // fetch all employees ajax request
      fetchAllEmployees();
      function fetchAllEmployees() {
        $.ajax({
          url: "{{ route('fetchAll') }}",
          method: 'get',
          success: function(response) {
            $("#show_all_employees").html(response);
            $("table").DataTable({
              order: [0, 'desc']
            });
          }
        });
      }
    });
  </script>
