@extends('layouts.app')

@section('content')
<div class="containers">

    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <h4 class="align-left">{{ __('Filter') }}</h4>
                </div>
                <div class="card-content">
                    <form id="registerForm" method="POST" onsubmit="event.preventDefault(); registerUser()">
                        <input type="hidden" name="_token" id="csrf" value="{{Session::token()}}">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="input-label" for="role">Customer</label>
                                <input name="customer_id" id="customer_id" type="hidden" />
                                <input name="customer" oninput="searchCustomer()" onclick="resetCustomer()" id="customer" class="input-text" type="text" placeholder="Phone / Name" />
                                <div class="search-dropdown">
                                    <div id="customer_list"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="category">Category</label>
                                <select id="category" name="category" class="input-select">
                                    <option value="">Select Category</option>
                                    <option value="keychain">Keychain</option>
                                    <option value="medal">Medal</option>
                                    <option value="lanyard">Lanyard</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" id="butsave" class="btn btn-green float-right"> {{ __('Filter') }}</button>
                        <button type="submit" id="butsave" class="btn btn-green float-right"> {{ __('Clear') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <h4 class="align-left">{{ __('Users') }}</h4>
                    <a href="{{ route('addOrder') }}" class="btn btn-green">Add Order</a>
                </div>
                <div class="card-content table-content">
                    <div id="tableData">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection


@section('scripts')

<script>

    const updateUser = () => {
        var formData = $("#updateForm").serializeArray();
        for (let key in formData) {
            $(`#${formData[key].name}_error`).html('');
            $(`#${formData[key].name}`).removeClass('is-invalid');
        }
        $.ajax({
            url: "updateUser",
            type: "POST",
            data: formData,
            success: function(response) {
                console.log(response);
                Notiflix.Report.Success(
                    'Success',
                    'User update succesful',
                    'Click');
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

    const searchCustomer = () => {
        let formData = {};
        let customer = document.getElementById('customer').value;
        if(customer.length == 0) {
            $('#customer_list').fadeOut();
            return;
        }
        formData['customer'] = customer;
        $.ajax({
            url: "order/searchCustomer",
            type: "POST",
            data: formData,
            dataType: 'JSON',
            success: function(response) {
                console.log(response);
                $('#customer_list').fadeIn();
                $('#customer_list').html(response.data);
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    const resetCustomer = () => {
        document.getElementById('customer').value = "";
        document.getElementById('customer_id').value = "";
    }

    const selectCustomer = (obj) => {
        let formData = {};
        let customer = document.getElementById('customer');
        customer_id = obj.getAttribute('data-id');
        document.getElementById('customer_id').value = customer_id;
        customer.value = obj.innerHTML;
        $('#customer_list').fadeOut();
    }

    function deleteRow(obj) {
        let del_id = $(obj).data('id');
        Notiflix.Confirm.Show(
            'Confirmation',
            'Are you sure you want to delete?',
            'Yes', 'No',
            function() {
                var id = del_id;
                $.ajax({
                    url: "deleteUser",
                    type: "GET",
                    cache: false,
                    data: {
                        id: id,
                    },
                    success: function(response) {
                        location.reload();
                    }
                });
            },
            function() {}
        );
    }

    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'GET',
            url: 'order/viewAll',
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

    const openModal = (id) => {
        $(`#${id}`)
            .css("display", "flex")
            .hide()
            .fadeIn();
    }

    const closeModal = (id) => {
        $(`#${id}`).fadeOut();
    }
</script>
@endsection