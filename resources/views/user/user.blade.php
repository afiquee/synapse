@extends('layouts.app')

@section('content')
<div class="containers">
    <div class="cards">
        <div class="cards-header">
            <h4 class="align-left">{{ __('Users') }}</h4>
            <button class="btn btn-green" data-id="#myModal" id="myBtn">Add User</button>
        </div>
        <div class="cards-content table-content">
            <div id="tableData">

            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modals">
    <div class="modals-container">
        <div class="modals-header">
            <h4 class="align-left">{{ __('Register User') }}</h4>
            <span class="close">&times;</span>
        </div>
        <div class="modals-content">
            <form method="POST">
                <div class="forms-wrap">
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="email">Email</label>
                            <input name="email" id="email" class="input-text" value="{{ old('email') }}" type="text"
                                placeholder="Email" required />
                        </div>
                    </div>
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="name">Name</label>
                            <input name="name" id="name" class="input-text" type="text" placeholder="Name" required />
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
                        <button type="submit" class="btn btn-green"> {{ __('Register') }}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection


@section('scripts')

<script>
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
        error: function(data) {

        }
    });
});



var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function(e) {
    modal.style.display = "flex";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>

@endsection