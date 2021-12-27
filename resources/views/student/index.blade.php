@extends('layouts.custom')

@section('content')


<!--  Add student Modal -->
<div class="modal fade" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="studentModalLabel">Add Student</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <ul id="saveForm_errlist"></ul>
        <form>
            <div class="form-group mb-3">
                <label for="">Student Name</label>
                <input type="text" class="name form-control">
          </div>
          <div class="form-group mb-3">
                <label for="">Email</label>
                <input type="text" class="email form-control">
          </div>
          <div class="form-group mb-3">
            <label for="">Phone</label>
            <input type="text" class="phone form-control">
          </div>
          <div class="form-group mb-3">
            <label for="">Course</label>
            <input type="text" class="course form-control">
          </div>
          <div class="form-group mb-3">
            <label for="">Image</label>
            <input type="file" class="image form-control">
          </div>
        </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary add_student">Save  </button>
        </div>
      </div>
    </div>
  </div>
<!-- End Add student Modal -->


<div class="container py-5">
    <div class="row">
        <div class="col-md-12">

            <div id="success_message">

            </div>

            <div class="card">
                <div class="card-header">
                    <h4>
                        Student Data
                        <a href="#" data-bs-toggle="modal" data-bs-target="#studentModal" class="btn btn-primary float-end btn-sm">Add Student</a>
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Course</th>
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

@endsection

@section('scripts')

    <script>
        $(document).ready(function(){

            fetchStudent();

            function fetchStudent(){
                $.ajax({
                    type: 'GET',
                    url: '/fetch-student',
                    dataType: 'json',
                    success: function(response){
                        $('tbody').html("");
                        $.each(response.students, function(key, item){
                                $('tbody').append('<tr>\
                                                        <td>'+item.id+'</td>\
                                                        <td>'+item.name+'</td>\
                                                        <td>'+item.email+'</td>\
                                                        <td>'+item.phone+'</td>\
                                                        <td>'+item.course+'</td>\
                                                        <td> <button type="button" value="'+item.id+'" class="edit_student btn btn-primary btn-sm">Edit</td>\
                                                        <td> <button type="button" value="'+item.id+'" class="delete_student btn btn-danger btn-sm">Delete</td>\
                                                    </tr>');
                        });
                    }
                });
            }


            $(document).on('click', '.add_student',function(e) {
                e.preventDefault();

                var data = {
                    'name':$('.name').val(),
                    'email':$('.email').val(),
                    'phone':$('.phone').val(),
                    'course':$('.course').val()
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    type : "POST",
                    url : "/students",
                    data : data,
                    dataType: "json",
                    success : function (response) {
                        //console.log(response);
                        if(response.status == 400)
                        {
                            $('#saveForm_errlist').html('');
                            $('#saveForm_errlist').addClass('alert alert-danger');
                            $.each(response.errors, function(key, err_values){
                                $('#saveForm_errlist').append('<li>'+err_values+'<li>');
                            });
                        }
                        else
                        {
                            $('#saveForm_errlist').html('');
                            $('#success_message').text(response.message);
                            $('#success_message').addClass('alert alert-success');
                            $('#studentModal').modal('hide');
                            $('#studentModal').find('input').val("");
                            fetchStudent();
                        }
                    }

                });

               
            });

        });
    </script>
    
@endsection