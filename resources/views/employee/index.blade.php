@extends('layouts.app')

@section('content')
<!-- Modal -->
<div class="modal fade" id="AddEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employee</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="AddEmployeeFORM" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
                <ul class="alert alert-warning d-none" id="save_errorList"></ul>
                <div class="form-group mb-3">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
  <!-- Edit Modal -->
  <div class="modal fade" id="EDITEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Employee</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form id="UpdateEmployeeFORM" method="POST" enctype="multipart/form-data">
            <div class="modal-body">

                <input type="hidden" name="emp_id" id="emp_id">
                <ul class="alert alert-warning d-none" id="update_errorList"></ul>
                <div class="form-group mb-3">
                    <label>Name</label>
                    <input type="text" name="name" id="edit_name" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label>Phone</label>
                    <input type="text" name="phone" id="edit_phone" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label>Image</label>
                    <input type="file" name="image" class="form-control">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
      </div>
    </div>
  </div>
    <!-- End Edit Modal -->

    <!--Delete Employee Modal-->
    <div class="modal fade" id="DELETEEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Employee</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">

                    <h4>Are you sure you want to delete this data?</h4>
                    <input type="hidden" id="deleting_emp_id">

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="delete_employee_btn btn btn-primary">Yes,Delete it</button>
                </div>
          </div>
        </div>
      </div>
      <!--End Delete Employee Modal-->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Employee Data
                        <a href="#" data-bs-toggle="modal" data-bs-target="#AddEmployeeModal" class="btn btn-primary btn-sm float-end">Add Employee</a>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Image</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        fetchEmployee();
        function fetchEmployee()
        {
            $.ajax({
                type: "GET",
                url: "/fetch-employee",
                dataType: "json",
                success: function (response) {
                    // console.log(response.employee);
                    $('tbody').html("");
                    $.each(response.employee, function (key, item) { 
                        $('tbody').append('<tr>\
                                    <td>'+item.id+'</td>\
                                    <td>'+item.name+'</td>\
                                    <td>'+item.phone+'</td>\
                                    <td><img src="uploads/employee/'+item.image+'" width="50px" height="50px" alt="image"></td>\
                                    <td><button type="button" value="'+item.id+'" class="edit_btn btn btn-success btn-sm">Edit</button></td>\
                                    <td><button type="button" value="'+item.id+'" class="delete_btn btn btn-danger btn-sm">Delete</button></td>\
                                </tr>');
                    });
                }
            });
        }

        $(document).on('click', '.delete_btn', function (e) {
            e.preventDefault();

            var emp_id = $(this).val();
            $('#DELETEEmployeeModal').modal('show');
            $('#deleting_emp_id').val(emp_id);
            
            
        });

        $(document).on('click','.delete_employee_btn',function (e) {
            e.preventDefault();

            var id = $('#deleting_emp_id').val();

            $.ajax({
                type: "DELETE",
                url: "/delete-employee/"+id,
                dataType: "json",
                success: function (response) {
                    if(response.status == 404)
                    {
                        alert(response.message);
                        $('#DELETEEmployeeModal').modal('hide');
                    }
                    else if(response.status == 200)
                    {
                        fetchEmployee();
                        $('#DELETEEmployeeModal').modal('hide');
                        alert(response.message);
                    }
                }
            });
        });

        $(document).on('click', '.edit_btn',function (e) {
            e.preventDefault();

            var emp_id = $(this).val();
            $('#EDITEmployeeModal').modal('show');
            // alert(emp_id);

            $.ajax({
                type: "GET",
                url: "/edit-employee/"+emp_id,
                success: function (response) {
                    if(response.status == 404)
                    {
                        alert(response.message);
                        $('#EDITEmployeeModal').modal('hide');
                    }
                    else
                    {
                        $('#edit_name').val(response.employee.name);
                        $('#edit_phone').val(response.employee.phone);
                        $('#emp_id').val(emp_id);
                    }
                }
            });
        });

        $(document).on('submit', '#UpdateEmployeeFORM',function (e) {
            e.preventDefault();

            var id = $('#emp_id').val();
            let EditformData = new FormData($('#UpdateEmployeeFORM')[0]);

            $.ajax({
                type: "POST",
                url: "update-employee/"+id,
                data: EditformData,
                contentType: false,
                processData:false,
                success: function (response) {
                    if(response.status == 400)
                    {
                        $('#update_errorList').html("");
                        $('#update_errorList').removeClass('d-none');
                        $.each(response.errors, function (key, err_value){
                            $('#update_errorList').append('<li>'+err_value+'</li>');
                        });
                    }
                    else if(response.status == 404)
                    {
                        alert(response.messages);
                    }
                    else if(response.status == 200)
                    {
                        $('#update_errorList').html("");
                        $('#update_errorList').addClass('d-none');

                        $('#EDITEmployeeModal').modal('hide');
                        $('.modal-backdrop').remove();
                        alert(response.messages);
                        fetchEmployee();
                    }
                }
            });
        });


        $(document).on('submit', '#AddEmployeeFORM', function(e){
            e.preventDefault();

            let formData = new FormData($('#AddEmployeeFORM')[0]);

            $.ajax({
                type: "POST",
                url: "/employee",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response){
                    if (response.hasOwnProperty('status') && response.status === 400)
                    {
                        $('#save_errorList').html("");
                        $('#save_errorList').removeClass('d-none');
                        $.each(response.errors, function (key, err_value){
                            $('#save_errorList').append('<li>'+err_value+'</li>');
                        });
                    }
                    else if(response.status == 200)
                    {
                        $('#save_errorList').html("");
                        $('#save_errorList').addClass('d-none');

                        $('#AddEmployeeFORM').find('input').val('');
                        $('#AddEmployeeModal').modal('hide');
                        $('.modal-backdrop').remove();
                        fetchEmployee();

                        alert(response.messages);
                    }
                }
            });
        });
    });

</script>

@endsection