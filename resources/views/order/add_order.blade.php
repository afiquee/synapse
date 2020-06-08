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
                <hr class="hr-major">
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
                            type="text" placeholder="Full Name" required />
                        @error('full_name')
                        <label class="label-error">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="cols">
                        <label class="input-label" for="email">Email</label>
                        <input name="email" id="email" class="input-text @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" type="text" placeholder="Email" required />
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
                            @foreach($states as $state)
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <h3><i class="fas fa-shopping-cart"></i>Order</h3>
                <hr class="hr-major">
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
                <hr class="hr-major">

                <div class="rows cb-rows justify-start">
                    <div class="cb-cols">
                        <input type="checkbox" onclick="toggleSection('keychain_container')" name="keychain_toggle"
                            class="input-checkbox">
                        <label class="input-label" for="keychain_toggle">Keychain</label>
                    </div>
                    <div class="cb-cols">
                        <input type="checkbox" onclick="toggleSection('medal_container')" name="medal_toggle"
                            class="input-checkbox">
                        <label class="input-label" for="medal_toggle">Medal</label>
                    </div>
                    <div class="cb-cols">
                        <input type="checkbox" onclick="toggleSection('lanyard_container')" name="lanyard_toggle"
                            class="input-checkbox">
                        <label class="input-label" for="lanyard_toggle">Lanyard</label>
                    </div>
                    <div class="cb-cols">
                        <input type="checkbox" onclick="toggleSection('custom_container')" name="custom_toggle"
                            class="input-checkbox">
                        <label class="input-label" for="custom_toggle">Custom</label>
                    </div>
                </div>

                <div id="keychain_container" style="transition: all 0.2s ease-in;" class="section-item">
                    <h4></i>Keychain</h4>
                    <hr class="hr-minor">
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="type">Keychain Type</label>
                            <select id="type" name="type" class="input-select">
                                <option value="Production">4cm Kayu</option>
                                <option value="Production">4cm Acrylic</option>
                                <option value="Sales">4cm Warna</option>
                            </select>
                            @error('type')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="cols">
                            <label class="input-label" for="type">Keychain Shape</label>
                            <select id="type" name="type" class="input-select">
                                <option value="Production">Bulat</option>
                                <option value="Production">Segi Empat</option>
                                <option value="Sales">Custo</option>
                            </select>
                            @error('type')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="cols">
                            <label class="input-label" for="quantity">Quantity *</label>
                            <input name="quantity" id="quantity"
                                class="input-text @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}"
                                type="text" placeholder="Quantity" required />
                            @error('quantity')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="cols">
                            <label class="input-label" for="value"> Value *</label>
                            <input name="value" id="value" class="input-text @error('value') is-invalid @enderror"
                                value="{{ old('value') }}" type="text" placeholder="Order Value" required />
                            @error('value')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="rows cb-rows">
                        <div class="cb-cols">
                            <input type="checkbox" class="input-checkbox">
                            <label class="input-label" for="type">Include Keyring</label>
                        </div>
                        <div class="cols">

                            @error('type')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="cb-cols">
                            <input type="checkbox" class="input-checkbox">
                            <label class="input-label" for="type">Require Heatpress</label>
                        </div>
                        <div class="cols">

                            @error('type')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="rows">
                        <div class="cols">
                            <div class="custom-file-upload">
                                <label class="input-label" for="file">Keychain Files</label>
                                <input type="file" id="keychain_files" name="keychain_files[]" multiple />
                            </div>
                        </div>
                    </div>
                </div>

                <div id="medal_container" class="section-item">
                    <h4></i>Medal</h4>
                    <hr class="hr-minor">
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="type">Medal Type</label>
                            <select id="type" name="type" class="input-select">
                                <option value="Production">4cm Kayu</option>
                                <option value="Production">4cm Acrylic</option>
                                <option value="Sales">4cm Warna</option>
                            </select>
                            @error('type')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="cols">
                            <label class="input-label" for="quantity">Quantity *</label>
                            <input name="quantity" id="quantity"
                                class="input-text @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}"
                                type="text" placeholder="Quantity" required />
                            @error('quantity')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="cols">
                            <label class="input-label" for="value"> Value *</label>
                            <input name="value" id="value" class="input-text @error('value') is-invalid @enderror"
                                value="{{ old('value') }}" type="text" placeholder="Order Value" required />
                            @error('value')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="rows">
                        <div class="cols">
                            <div class="custom-file-upload">
                                <label class="input-label" for="file">Medal Files</label>
                                <input type="file" id="keychain_files" name="keychain_files[]" multiple />
                            </div>
                        </div>
                    </div>
                </div>

                <div id="lanyard_container" class="section-item">
                    <h4></i>Lanyard</h4>
                    <hr class="hr-minor">
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="type">Lanyard Type</label>
                            <select id="type" name="type" class="input-select">
                                <option value="Production">4cm Kayu</option>
                                <option value="Production">4cm Acrylic</option>
                                <option value="Sales">4cm Warna</option>
                            </select>
                            @error('type')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="cols">
                            <label class="input-label" for="quantity">Quantity *</label>
                            <input name="quantity" id="quantity"
                                class="input-text @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}"
                                type="text" placeholder="Quantity" required />
                            @error('quantity')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="cols">
                            <label class="input-label" for="value"> Value *</label>
                            <input name="value" id="value" class="input-text @error('value') is-invalid @enderror"
                                value="{{ old('value') }}" type="text" placeholder="Order Value" required />
                            @error('value')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="rows">
                        <div class="cols">
                            <div class="custom-file-upload">
                                <label class="input-label" for="file">Lanyard Files</label>
                                <input type="file" id="keychain_files" name="keychain_files[]" multiple />
                            </div>
                        </div>
                    </div>
                </div>

                <div id="custom_container" class="section-item">
                    <h4></i>Custom</h4>
                    <hr class="hr-minor">
                    <div class="rows">
                        <div class="cols">
                            <label class="input-label" for="type">Lanyard Type</label>
                            <select id="type" name="type" class="input-select">
                                <option value="Production">4cm Kayu</option>
                                <option value="Production">4cm Acrylic</option>
                                <option value="Sales">4cm Warna</option>
                            </select>
                            @error('type')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="cols">
                            <label class="input-label" for="quantity">Quantity *</label>
                            <input name="quantity" id="quantity"
                                class="input-text @error('quantity') is-invalid @enderror" value="{{ old('quantity') }}"
                                type="text" placeholder="Quantity" required />
                            @error('quantity')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="cols">
                            <label class="input-label" for="value"> Value *</label>
                            <input name="value" id="value" class="input-text @error('value') is-invalid @enderror"
                                value="{{ old('value') }}" type="text" placeholder="Order Value" required />
                            @error('value')
                            <label class="label-error">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    <div class="rows">
                        <div class="cols">
                            <div class="custom-file-upload">
                                <label class="input-label" for="file">Custom Files</label>
                                <input type="file" id="keychain_files" name="keychain_files[]" multiple />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rows">
                    <button type="submit" class="btn btn-green"> {{ __('Submit') }}</button>
                    <button type="button" onclick="notify()" class="btn btn-green"> {{ __('ALert') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection


@section('scripts')

<script>
function notify() {
    Notiflix.Loading.Init({
        messageColor: '#fff',
        svgSize: '100px',
        clickToClose: true,
    });

    setTimeout(function() {
        Notiflix.Report.Success(
            'Successful',
            'Order created',
            'Okay',
            function() {

                //window.location.href = "{{ URL::to('addOrder') }}"
            },
            function() {
                // No button callback alert('If you say so...'); 
            }
        );
    }, 500);

}

function toggleSection(section) {
    $(`#${section}`).toggleClass('section-active');
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