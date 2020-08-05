@extends('layouts.app')

@section('content')
<div class="containers">
    <div class="row center">
        <div class="col-sm">
            <div class="card">
                <div class="card-header">
                    <h4 class="align-left">{{ __('Profile') }}</h4>
                </div>
                <div class="card-content table-content">
                    <form id="profileForm" method="POST" onsubmit="event.preventDefault(); resetPass()">
                        <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                        <div class="forms-wrap">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="input-label" for="planet">Old Password</label>
                                    <input name="old_password" id="old_password" class="input-text @if ($errors->any()) is-invalid  @endif" value="{{ old('old_password') }}" type="text" placeholder="Old Password" required />
                                    @if ($errors->any())
                                    <label class="label-error"> {{ $errors->first() }} </label>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="input-label">New Password</label>
                                    <input name="password1" id="password1" class="input-text  @if ($errors->any()) is-invalid  @endif" type="password" placeholder="New Password" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="input-label">Confirm Password</label>
                                    <input name="password2" id="password2" class="input-text  @if ($errors->any()) is-invalid  @endif" type="password" placeholder="Confirm Password" required />
                                    <div class="form-group">
                                    </div>
                                    <div class="full-input">
                                        <button type="submit" id="resetpass" class="btn btn-green">
                                            {{ __('Submit') }}</button>
                                    </div>
                                </div>
                    </form>
                </div>
            </div>
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
    });

    function resetPass() {
        var formData = $("#profileForm").serializeArray();

        for (let key in formData) {
            $(`#${formData[key].name}_error`).html('');
            $(`#${formData[key].name}`).removeClass('is-invalid');
        }
        $.ajax({
            url: 'Editprofile',
            type: 'POST',
            data: formData,
            success: function(response) {
                Notiflix.Report.Success(
                    'Success',
                    'Password Change successful',
                    'Click');
            },
            error: function(error) {
                console.log(error);
                var messages = error.responseJSON.msg;
                for (let field in messages) {
                    $(`#${field}_error`).html(messages[field]);
                    $(`#${field}`).addClass('is-invalid');
                }
            }
        });
    }
</script>
@endsection