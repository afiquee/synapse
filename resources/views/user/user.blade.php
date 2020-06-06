@extends('layouts.app')

@section('content')
<div class="containers">
    <div class="cards cards-lg">
        <div class="cards-header">
            <h4 class="align-left">{{ __('Users') }}</h4>
            <button class="btn btn-green" data-id="#myModal" onclick="openModal('registerModal')"><i
                    class="fas fa-plus"></i>Add
                User</button>
        </div>
        <div class="cards-content table-content">
            <div id="tableData">

            </div>
        </div>
    </div>
</div>

<div id="registerModal" class="modals">
    <div class="modals-container">
        <div class="modals-header">
            <h4 class="align-left">{{ __('Register User') }}</h4>
            <span onclick="closeModal('registerModal')" class="close">&times;</span>
        </div>
        <div class="modals-content">
            <form id="registerForm" method="POST" onsubmit="event.preventDefault(); registerUser()">
                <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                <div class="forms-wrap">
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="email">Email</label>
                            <input name="email" id="email" class="input-text" value="{{ old('email') }}" type="text"
                                placeholder="Email" required />
                            <label id="email_error" class="label-error"></label>
                        </div>
                    </div>
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="name">Name</label>
                            <input name="name" id="name" class="input-text" type="text" placeholder="Name" required />
                            <label id="name_error" class="label-error"></label>
                        </div>
                    </div>
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="role">Role</label>
                            <select id="role" name="role" class="input-select">
                                <option value="Production">Production</option>
                                <option value="Sales">Sales</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="rows">
                        <button type="submit" id="butsave" class="btn btn-green"> {{ __('Register') }}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>

<div id="updateModal" class="modals">
    <div class="modals-container">
        <div class="modals-header">
            <h4 class="align-left">{{ __('Update User') }}</h4>
            <span onclick="closeModal('updateModal')" class="close">&times;</span>
        </div>
        <div class="modals-content">
            <form method="POST" onsubmit="event.preventDefault(); updateUser()">
                <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                <input type="hidden" name="u_id" id="u_id">
                <div class="forms-wrap">
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="email">Email</label>
                            <input name="u_email" id="u_email" class="input-text" value="{{ old('email') }}" type="text"
                                placeholder="Email" required />
                        </div>
                    </div>
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="name">Name</label>
                            <input name="u_name" id="u_name" class="input-text" type="text" placeholder="Name"
                                required />
                        </div>
                    </div>
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="role">Role</label>
                            <select id="u_role" name="u_role" class="input-select">
                                <option value="Production">Production</option>
                                <option value="Sales">Sales</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="rows">
                        <button type="submit" class="btn btn-green"> {{ __('Update User') }}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection


@section('scripts')

<script>
function updateRow(obj) {

    var u_email = $(obj).data('email');
    var u_name = $(obj).data('name');
    var u_role = $(obj).data('role');
    var u_id = $(obj).data('id');

    $('#u_email').val(u_email);
    $('#u_name').val(u_name);
    $('#u_role').val(u_role);
    $('#u_id').val(u_id);

    openModal('updateModal');

}

function updateUser() {

    var id = $('#u_id').val();
    var name = $('#u_email').val();
    var email = $('#u_name').val();
    var role = $('#u_role').val();

    $.ajax({
        url: "updateUser",
        type: "POST",
        data: {
            id: id,
            name: name,
            email: email,
            role: role,
        },
        success: function(response) {
            console.log(response);
            Notiflix.Report.Success(
                'Success',
                'User update succesful',
                'Click');
        }
    });

}

function registerUser() {

    var formData = $("#registerForm").serializeArray(); 
    for(let key in formData) {
        $(`#${formData[key].name}_error`).html('');
        $(`#${formData[key].name}`).removeClass('is-invalid');
    }

    $.ajax({
        url: 'registerUser',
        type: 'POST',
        data: formData,
        success: function(response) {
            Notiflix.Report.Success(
                'Success',
                'User registration succesful',
                'Click');
            closeModal('registerModal');
        },
        error: function(error) {
            var messages = error.responseJSON.msg;
            for (let field in messages) {
                $(`#${field}_error`).html(messages[field]);
                $(`#${field}`).addClass('is-invalid');
            }
        }
    });
}


function deleteRow(obj) {

    var del_id = $(obj).data('id');

    $('#deleteRowBtn').on("click", function() {
        var id = del_id;
        var successCodes = 200;
        $.ajax({
            url: "deleteUser",
            type: "GET",
            cache: false,
            data: {
                id: id,
            },
            success: function(response) {
                if (response.successCode == successCodes) {
                    location.reload();
                }
            }
        });
    });
}

$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'GET',
        url: 'viewAll',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                let table = response.data;
                $('#tableData').html(table);
                var dataTable = $('#userTable').DataTable({});
            }
        },
        error: function(data) {}
    });



});

function openModal(id) {
    $(`#${id}`)
        .css("display", "flex")
        .hide()
        .fadeIn();
}

function closeModal(id) {
    $(`#${id}`).fadeOut();
}
</script>
@endsection