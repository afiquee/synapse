@extends('layouts.app')

@section('content')
<div class="containers">

    <div class="row center">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">
                    <h4 class="align-left">{{ __('New Order') }}</h4>
                </div>
                <div class="card-content">
                    <form id="orderForm" method="POST" novalidate enctype="multipart/form-data">
                        @csrf
                        <h3><i class="fas fa-user"></i>Customer</h3>
                        <hr class="hr-major">
                        <div class="row">
                            <div class="form-group">
                                <div class="row removePadding">
                                    <label class="input-label" for="phone">Phone Number *</label>
                                    <label id="customer_status" class="label-success"></label>
                                </div>
                                <!-- <input name="phone" id="phone" class="input-text @error('phone') is-invalid @enderror"
                                    value="{{ old('phone') }}" type="text" placeholder="Phone Number" required/> -->
                                <input name="phone" id="phone" class="input-text @error('phone') is-invalid @enderror" value="{{ old('phone') }}" type="text" placeholder="Phone Number" required onkeyup="checkExistingCustomer()" />
                                @error('phone')
                                <label class="label-error">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input name="isExisting" id="isExisting" type="text" style="visibility:hidden" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="input-label" for="name">Full Name *</label>
                                <input name="name" id="name" class="input-text @error('name') is-invalid @enderror" value="{{ old('name') }}" type="text" placeholder="Full Name" required />
                                @error('full_name')
                                <label class="label-error">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="email">Email</label>
                                <input name="email" id="email" class="input-text @error('email') is-invalid @enderror" value="{{ old('email') }}" type="text" placeholder="Email" required />
                                @error('email')
                                <label class="label-error">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label class="input-label" for="address">Address</label>
                                <input name="address" id="address" class="input-text @error('address') is-invalid @enderror" value="{{ old('address') }}" type="text" placeholder="Address" required />
                                @error('address')
                                <label class="label-error">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="row">

                            <div class="form-group">
                                <label class="input-label" for="postcode">Postcode</label>
                                <input name="postcode" id="postcode" class="input-text @error('full_name') is-invalid @enderror" value="{{ old('postcode') }}" type="text" placeholder="Postcode" required />
                                @error('postcode')
                                <label class="label-error">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="full_name">City</label>
                                <input name="city" id="city" class="input-text @error('city') is-invalid @enderror" value="{{ old('city') }}" type="text" placeholder="City" required />
                                @error('city')
                                <label class="label-error">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="state">State</label>
                                <select id="state" name="state" class="input-select">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h3><i class="fas fa-shopping-cart"></i>Order</h3>
                        <hr class="hr-major">
                        <div class="row">
                            <div class="form-group">
                                <label class="input-label" for="deadline">Project Deadline *</label>
                                <input name="deadline" id="deadline" class="input-text @error('deadline') is-invalid @enderror" value="{{ old('deadline') }}" type="date" placeholder="Project Deadline" required />
                                @error('deadline')
                                <label class="label-error">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="input-label" for="payment_type">Payment Type *</label>
                                <select id="payment_type" name="payment_type" class="input-select">
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
                        <hr class="hr-major">

                        <div class="row cb-row justify-start">
                            <div class="cb-group">
                                <input type="checkbox" onclick="toggleSection('keychain_container')" name="keychain_toggle" id="keychain_toggle" value="keychain" class="input-checkbox">
                                <label class="input-label" for="keychain_toggle">Keychain</label>
                            </div>
                            <div class="cb-group">
                                <input type="checkbox" onclick="toggleSection('medal_container')" name="medal_toggle" id="medal_toggle" value="medal" class="input-checkbox">
                                <label class="input-label" name="medal_toggle" id="medal_toggle" value="medal_toggle" for="medal_toggle">Medal</label>
                            </div>
                            <div class="cb-group">
                                <input type="checkbox" onclick="toggleSection('lanyard_container')" name="lanyard_toggle" id="lanyard_toggle" value="lanyard" class="input-checkbox">
                                <label class="input-label" name="lanyard_toggle" id="lanyard_toggle" value="lanyard" for="lanyard_toggle">Lanyard</label>
                            </div>
                            <div class="cb-group">
                                <input type="checkbox" onclick="toggleSection('custom_container')" name="custom_toggle" id="custom_toggle" value="custom" class="input-checkbox">
                                <label class="input-label" name="custom_toggle" id="custom_toggle" value="custom" for="custom_toggle">Custom</label>
                            </div>
                        </div>

                        <div id="keychain_container" style="transition: all 0.2s ease-in;" class="section-item">
                            <h4></i>Keychain</h4>
                            <hr class="hr-minor">
                            <div class="row">
                                <div class="form-group">
                                    <label class="input-label" for="type">Keychain Type</label>
                                    <select id="type" name="keychain_type" class="input-select">
                                        <option value="4cm Kayu">4cm Kayu</option>
                                        <option value="4cm Acrylic">4cm Acrylic</option>
                                        <option value="4cm Warna">4cm Warna</option>
                                    </select>
                                    @error('type')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="input-label" for="keychain_shape">Keychain Shape</label>
                                    <select id="keychain_shape" name="keychain_shape" class="input-select">
                                        <option value="Bulat">Bulat</option>
                                        <option value="Segi Empat">Segi Empat</option>
                                        <option value="Custo">Custo</option>
                                    </select>
                                    @error('type')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="input-label" for="quantity">Quantity *</label>
                                    <input name="keychain_quantity" id="quantity" class="input-text @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" type="text" placeholder="Quantity" required />
                                    @error('quantity')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="input-label" for="value"> Value *</label>
                                    <input name="keychain_value" id="value" class="input-text @error('value') is-invalid @enderror" value="{{ old('value') }}" type="text" placeholder="Order Value" required />
                                    @error('value')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="row cb-row">
                                <div class="cb-group">
                                    <input type="checkbox" value="keyring" name="keyring" id="keyring" class="input-checkbox">
                                    <label class="input-label" for="type">Include Keyring</label>
                                </div>
                                <div class="form-group">
                                    @error('type')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="cb-group">
                                    <input type="checkbox" value="heatpress" name="heatpress" id="heatpress" class="input-checkbox">
                                    <label class="input-label" for="type">Require Heatpress</label>
                                </div>
                                <div class="form-group">
                                    @error('type')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <div class="custom-file-upload">
                                        <label class="input-label" for="file">Keychain Files</label>
                                        <input type="file" id="keychain_files[]" name="keychain_files[]" multiple />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="medal_container" class="section-item">
                            <h4></i>Medal</h4>
                            <hr class="hr-minor">
                            <div class="row">
                                <div class="form-group">
                                    <label class="input-label" for="type">Medal Type</label>
                                    <select id="medal_type" name="medal_type" class="input-select">
                                        <option value="4cm Kayu">4cm Kayu</option>
                                        <option value="4cm Acrylic">4cm Acrylic</option>
                                        <option value="4cm Warna">4cm Warna</option>
                                    </select>
                                    @error('type')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="input-label" for="quantity">Quantity *</label>
                                    <input name="medal_quantity" id="medal_quantity" class="input-text @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" type="text" placeholder="Quantity" required />
                                    @error('quantity')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="input-label" for="value"> Value *</label>
                                    <input name="medal_value" id="medal_value" class="input-text @error('value') is-invalid @enderror" value="{{ old('value') }}" type="text" placeholder="Order Value" required />
                                    @error('value')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="form-group">
                                    <div class="custom-file-upload">
                                        <label class="input-label" for="file">Medal Files</label>
                                        <input type="file" id="keychain_files" name="keychain_files[]" multiple />
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div id="lanyard_container" class="section-item">
                            <h4></i>Lanyard</h4>
                            <hr class="hr-minor">
                            <div class="row">
                                <div class="form-group">
                                    <label class="input-label" for="type">Lanyard Type</label>
                                    <select id="type" name="lanyard_type" class="input-select">
                                        <option value="4cm Kayu">4cm Kayu</option>
                                        <option value="4cm Acrylic">4cm Acrylic</option>
                                        <option value="4cm Warna">4cm Warna</option>
                                    </select>
                                    @error('type')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="input-label" for="quantity">Quantity *</label>
                                    <input name="lanyard_quantity" id="quantity" class="input-text @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" type="text" placeholder="Quantity" required />
                                    @error('quantity')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="input-label" for="value"> Value *</label>
                                    <input name="lanyard_value" id="value" class="input-text @error('value') is-invalid @enderror" value="{{ old('value') }}" type="text" placeholder="Order Value" required />
                                    @error('value')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="form-group">
                                    <div class="custom-file-upload">
                                        <label class="input-label" for="file">Lanyard Files</label>
                                        <input type="file" id="keychain_files" name="keychain_files[]" multiple />
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div id="custom_container" class="section-item">
                            <h4></i>Custom</h4>
                            <hr class="hr-minor">
                            <div class="row">
                                <div class="form-group">
                                    <label class="input-label" for="type">Lanyard Type</label>
                                    <select id="custom_type" name="custom_type" class="input-select">
                                        <option value="4cm Kayu">4cm Kayu</option>
                                        <option value="4cm Acrylic">4cm Acrylic</option>
                                        <option value="4cm Warna">4cm Warna</option>
                                    </select>
                                    @error('type')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="input-label" for="quantity">Quantity *</label>
                                    <input name="custom_quantity" id="quantity" class="input-text @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}" type="text" placeholder="Quantity" required />
                                    @error('quantity')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="input-label" for="value"> Value *</label>
                                    <input name="custom_value" id="value" class="input-text @error('value') is-invalid @enderror" value="{{ old('value') }}" type="text" placeholder="Order Value" required />
                                    @error('value')
                                    <label class="label-error">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="form-group">
                                    <div class="custom-file-upload">
                                        <label class="input-label" for="file">Custom Files</label>
                                        <input type="file" id="keychain_files" name="keychain_files[]" multiple />
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="row">
                            <button type="submit" class="btn btn-green"> {{ __('Submit') }}</button>
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
    function toggleSection(section) {
        $(`#${section}`).toggleClass('section-active');
    }

    $('#orderForm').on('submit', function(event) {
        event.preventDefault();
        var formData = $("#orderForm").serializeArray();
        //formData = [...formData, keychain_files[]];
        console.log(formData);

        for (let key in formData) {
            $(`#${formData[key].name}_error`).html('');
            $(`#${formData[key].name}`).removeClass('is-invalid');
        }

        $.ajax({
            url: "orderForms",
            enctype: 'multipart/form-data',
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response);
                Notiflix.Report.Success(
                    'Success',
                    'Order succesful',
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

    });


    function ordersForm() {
        let keychain_files = {
            'name': 'keychain_files',
            'value': document.getElementById('keychain_files').files
        };
       

    }

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