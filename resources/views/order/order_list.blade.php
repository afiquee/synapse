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
                    <form id="filterForm" method="POST" onsubmit="event.preventDefault(); filterOrder()">
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

    <div class="row center">
        <div class="col-xsm">
            <div class="card">
                <div class="card-content">
                    <h2>Customers</h2>
                    <h1 id="total_customer"></h1>
                </div>
            </div>
        </div>
        <div class="col-xsm">
            <div class="card">
                <div class="card-content">
                    <h2>Orders</h2>
                    <h1 id="total_order"></h1>
                </div>
            </div>
        </div>
        <div class="col-xsm">
            <div class="card">
                <div class="card-content">
                    <h2>Items</h2>
                    <h1 id="total_item"></h1>
                </div>
            </div>
        </div>
        <div class="col-xsm">
            <div class="card">
                <div class="card-content">
                    <h2>Value</h2>
                    <h1 id="total_value"></h1>
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
    const filterOrder = () => {
        let formData = $("#filterForm").serializeArray();
        console.log(formData)
        fetchData(formData)
    }

    const searchCustomer = () => {
        let formData = {};
        let customer = document.getElementById('customer').value;
        if (customer.length == 0) {
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

        fetchData();
    });

    const fetchData = (formData = null) => {
        $.ajax({
            type: 'POST',
            data: formData,
            url: 'order/viewAll',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let data = response.data;
                    document.getElementById('tableData').innerHTML = data.table;
                    document.getElementById('total_customer').innerHTML = data.total_customer;
                    document.getElementById('total_order').innerHTML = data.total_order;
                    document.getElementById('total_item').innerHTML = data.total_item;
                    document.getElementById('total_value').innerHTML = `RM ${data.total_value}`;
                    let dataTable = $('#userTable').DataTable({});
                }
            },
            error: function(data) {}
        });
    }

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