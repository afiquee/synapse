@extends('layouts.app')

@section('content')
<div class="containers">
    <div class="cards cards-lg">
        <div class="cards-header">
            <h4 class="align-left">{{ __('New Order') }}</h4>
        </div>
        <div class="cards-content">
            <form method="POST" action="{{ route('loginUser') }}">
                @csrf
                <h3><i class="fas fa-user"></i>Customer</h3>
                <hr>
                <div class="rows">
                    <div class="cols">
                        <div class="rows removePadding">
                            <label class="input-label" for="phone">Phone Number *</label>
                            <label id="customer_status" class="label-success"></label>
                        </div>
                        <input name="phone" id="phone" class="input-text @error('phone') is-invalid @enderror"
                            value="{{ old('phone') }}" type="text" placeholder="Phone Number" required
                            onkeyup="checkExistingCustomer()" />
                        @error('phone')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="cols">
                        <input name="isExisting" id="isExisting" type="text" style="visibility:hidden" />

                    </div>
                </div>
                <div class="rows">
                    <div class="cols">
                        <label class="input-label" for="full_name">Full Name *</label>
                        <input name="full_name" id="full_name"
                            class="input-text @error('full_name') is-invalid @enderror" value="{{ old('full_name') }}"
                            type="text" placeholder="Full Name" required disabled />
                        @error('full_name')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="cols">
                        <label class="input-label" for="email">Email</label>
                        <input name="email" id="email" class="input-text @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" type="text" placeholder="Email" required disabled />
                        @error('email')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="rows">
                    <div class="cols">
                        <label class="input-label" for="address">Address</label>
                        <input name="address" id="address" class="input-text @error('address') is-invalid @enderror"
                            value="{{ old('address') }}" type="text" placeholder="Address" required />
                        @error('address')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <div class="rows">

                    <div class="cols">
                        <label class="input-label" for="postcode">Postcode</label>
                        <input name="postcode" id="postcode" class="input-text @error('full_name') is-invalid @enderror"
                            value="{{ old('postcode') }}" type="text" placeholder="Postcode" required />
                        @error('postcode')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="cols">
                        <label class="input-label" for="full_name">City</label>
                        <input name="city" id="city" class="input-text @error('city') is-invalid @enderror"
                            value="{{ old('city') }}" type="text" placeholder="City" required />
                        @error('city')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="cols">
                        <label class="input-label" for="state">State</label>
                        <select id="type" name="type" class="input-select">
                            <option value="">Select State</option>
                            <option value="Johor">Johor</option>
                            <option value="Kedah">Kedah</option>
                        </select>
                    </div>
                </div>
                <h3><i class="fas fa-shopping-cart"></i>Order</h3>
                <hr>
                <div class="rows">
                    <div class="cols">
                        <label class="input-label" for="deadline">Project Deadline *</label>
                        <input name="deadline" id="deadline" class="input-text @error('deadline') is-invalid @enderror"
                            value="{{ old('deadline') }}" type="date" placeholder="Project Deadline" required />
                        @error('deadline')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="cols">
                        <label class="input-label" for="type">Payment Type *</label>
                        <select id="type" name="type" class="input-select">
                            <option value="50%">50%</option>
                            <option value="100%">100%</option>
                            <option value="PO">PO</option>
                        </select>
                        @error('type')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
                <h3><i class="fas fa-medal"></i>Item</h3>
                <hr>
                <div class="rows">
                    <div class="cols">
                        <label class="input-label" for="type">Type *</label>
                        <select id="type" name="type" class="input-select">
                            <option value="Production">Keychain</option>
                            <option value="Production">Medal</option>
                            <option value="Sales">Plaque</option>
                        </select>
                        @error('type')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="cols">
                        <label class="input-label" for="quantity">Quantity *</label>
                        <input name="quantity" id="quantity" class="input-text @error('quantity') is-invalid @enderror"
                            value="{{ old('quantity') }}" type="text" placeholder="Quantity" required />
                        @error('quantity')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="cols">
                        <label class="input-label" for="value">Order Value *</label>
                        <input name="value" id="value" class="input-text @error('value') is-invalid @enderror"
                            value="{{ old('value') }}" type="text" placeholder="Order Value" required />
                        @error('value')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                </div>
               
                <div class="rows">

                </div>
                <div class="rows">
                    <button type="submit" class="btn btn-green"> {{ __('Submit') }}</button>
                </div>
            </form>
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
                <div class="rows">
                    <label class="input-label" for="email">Email</label>
                    <input name="email" id="email" class="input-text" value="{{ old('email') }}" type="text"
                        placeholder="Email" required />
                </div>
                <div class="rows">
                    <label class="input-label" for="name">Name</label>
                    <input name="name" id="name" class="input-text" type="text" placeholder="Name" required />
                </div>
                <div class="rows">
                    <label class="input-label" for="role">Role</label>
                    <select id="role" name="role" class="input-select">
                        <option value="Production">Production</option>
                        <option value="Sales">Sales</option>
                        <option value="Admin">Admin</option>
                    </select>
                </div>
                <div class="rows">
                    <button type="submit" class="btn btn-green"> {{ __('Register') }}</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection


@section('scripts')

<script>
function checkExistingCustomer() {

    let phone = $('#phone').val();
    let formData = {
        'phone': phone
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        data: formData,
        url: 'getCustomerByPhone',
        dataType: 'json',
        success: function(response) {
            console.log(response);
            if (response.status === 'success') {
                let customer = response.data;
                if (customer === null) {
                    $('#customer_status').html('New Customer');

                } else {
                    $('#customer_status').html('Existing Customer');
                }
            }
        },
        error: function(data) {

        }
    });

}
</script>

@endsection