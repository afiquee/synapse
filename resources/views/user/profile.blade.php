@extends('layouts.app')

@section('content')
<div class="containers">
    <div class="cards cards-sm">
        <div class="cards-header">
            <h4 class="align-left">{{ __('Profile') }}</h4>
        </div>
        <div class="cards-content table-content">
            <div class="forms-wrap">
                <div class="rows">
                    <div class="cols">
                        <label class="input-label" for="planet">Old Password</label>
                        <input name="old_password" id="old_password" class="input-text @if ($errors->any()) is-invalid  @endif"
                            value="{{ old('old_password') }}" type="text" placeholder="Old Password" required />
                        @if ($errors->any())
                        <label class="label-error"> {{ $errors->first() }} </label>
                        @endif
                    </div>
                </div>
                <div class="rows">
                    <div class="cols">
                        <label class="input-label">New Password</label>
                        <input name="password1" id="password1" class="input-text  @if ($errors->any()) is-invalid  @endif"
                            type="password" placeholder="New Password" required />
                    </div>
                </div>
                <div class="rows">
                    <div class="cols">
                        <label class="input-label">Confirm Password</label>
                        <input name="password2" id="password2" class="input-text  @if ($errors->any()) is-invalid  @endif"
                            type="password" placeholder="Confirm Password" required />
                    </div>
                </div>
                <div class="full-input">
                    <button type="submit" id="resetpass" class="btn btn-green"> {{ __('Submit') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div id="myModal" class="modals">
    <div class="modals-container">
        <div class="modals-header">
            <h4 class="align-left">{{ __('Register User') }}</h4>
            <span class="close">&times;</span>
        </div>
        <div class="modals-content">
            <form method="POST">
                <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
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
                        <button type="button" id="butsave" class="btn btn-green"> {{ __('Register') }}</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</div> -->
@endsection


@section('scripts')

<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#resetpass').on('click', function() {
        var old_password = $('#old_password').val();
        var password1 = $('#password1').val();
        var password2 = $('#password2').val();
        if (name != "" && email != "" && role != "") {
            //   $("#butsave").attr("disabled", "disabled");
            $.ajax({
                url: 'Editprofile',
                type: 'POST',
                data: {
                    old_password: old_password,
                    password1: password1,
                    password2: password2,
                },
                success: function(response) {
                    if (response.successCode === 'success') {
                        Notiflix.Report.Success( 
                        'Success', 
                        'User register succesful', 
                        'Click' ); 
                        window.location.reload(); 
                    } else {
                        Notiflix.Report.Failure( 
                        'Failure', 
                        'Email already taken', 
                        'Click' );
                        window.location.reload(); 
                    }
                },
            });
        } else {
            alert('Please fill all the field !');
        }
    });    
});
</script>
@endsection