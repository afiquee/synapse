<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Synapsis') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/notiflix.css') }}" rel="stylesheet">



    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="{{ asset('js/dataTables.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/d45262bf36.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/notiflix.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

</head>

<body>
    <div class="page">
        <nav class="sidebar" id="sidebar">
            <div class="flex-close">
                <span class="sidebar-close sidebar-menu" onclick="toggleSidebar()"><i
                        class="fas fa-times sidebar-menu"></i></span>
            </div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a class="{{ Route::currentRouteNamed('dashboard') ? 'nav-active' : '' }}" href="{{ route('dashboard') }}"><i
                            class="far fa-chart-bar icon"></i>{{ __('Dashboard') }}</a>
                </li>
                <li class="nav-item">
                    <a class="{{ Route::currentRouteNamed('profile') ? 'nav-active' : '' }}"
                        href="{{ route('profile') }}"><i class="far fa-address-card icon"></i>{{ __('Profile') }}</a>
                </li>
                <li class="nav-item">
                    <a class="{{ Route::currentRouteNamed('user') ? 'nav-active' : '' }}" href="{{ route('user') }}"><i
                            class="fas fa-user-friends icon"></i>{{ __('User') }}</a>
                </li>
                <li class="nav-item">
                    <a class="{{ Route::currentRouteNamed('order') ? 'nav-active' : '' }}"
                        href="{{ route('order') }}"><i class="fas fa-shopping-cart icon"></i>{{ __('Order') }}</a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt icon"></i>{{ __('Logout') }}
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </ul>
            <div>
            </div>

        </nav>
        <div class="content">
            <div class="header">
                <div class="headerContent">
                    <span onclick="toggleSidebar()" class="sidebar-toggle"><i
                            class="fas fa-bars sidebar-menu"></i></span>
                </div>
            </div>
            <div class="container">
                @yield('content')

            </div>
        </div>
</body>

</html>

<script>
function toggleSidebar() {

    $('#sidebar').toggleClass('sidebar-active');
    console.log($('#sidebar').hasClass('sidebar-active'));

}

//Reference:
//https://www.onextrapixel.com/2012/12/10/how-to-create-a-custom-file-input-with-jquery-css3-and-php/
(function($) {
    // Browser supports HTML5 multiple file?
    var multipleSupport = typeof $("<input/>")[0].multiple !== "undefined",
        isIE = /msie/i.test(navigator.userAgent);

    $.fn.customFile = function() {
        return this.each(function() {
            var $file = $(this).addClass("custom-file-upload-hidden"), // the original file input
                $wrap = $('<div class="file-upload-wrapper">'),
                $input = $('<input type="text" class="file-upload-input" />'),
                // Button that will be used in non-IE browsers
                $button = $(
                    '<button type="button" class="file-upload-button">Select a File</button>'
                ),
                // Hack for IE
                $label = $(
                    '<label class="file-upload-button" for="' +
                    $file[0].id +
                    '">Select a File</label>'
                );

            // Hide by shifting to the left so we
            // can still trigger events
            $file.css({
                position: "absolute",
                left: "-9999px"
            });

            $wrap.insertAfter($file).append($file, $input, isIE ? $label : $button);

            // Prevent focus
            $file.attr("tabIndex", -1);
            $button.attr("tabIndex", -1);

            $button.click(function() {
                $file.focus().click(); // Open dialog
            });

            $file.change(function() {
                var files = [],
                    fileArr,
                    filename;

                // If multiple is supported then extract
                // all filenames from the file array
                if (multipleSupport) {
                    fileArr = $file[0].files;
                    for (var i = 0, len = fileArr.length; i < len; i++) {
                        files.push(fileArr[i].name);
                    }
                    filename = files.join(", ");

                    // If not supported then just take the value
                    // and remove the path to just show the filename
                } else {
                    filename = $file.val().split("\\").pop();
                }

                $input
                    .val(filename) // Set the value
                    .attr("title", filename) // Show filename in title tootlip
                    .focus(); // Regain focus
            });

            $input.on({
                blur: function() {
                    $file.trigger("blur");
                },
                keydown: function(e) {
                    if (e.which === 13) {
                        // Enter
                        if (!isIE) {
                            $file.trigger("click");
                        }
                    } else if (e.which === 8 || e.which === 46) {
                        // Backspace & Del
                        // On some browsers the value is read-only
                        // with this trick we remove the old input and add
                        // a clean clone with all the original events attached
                        $file.replaceWith(($file = $file.clone(true)));
                        $file.trigger("change");
                        $input.val("");
                    } else if (e.which === 9) {
                        // TAB
                        return;
                    } else {
                        // All other keys
                        return false;
                    }
                }
            });
        });
    };

    // Old browser fallback
    if (!multipleSupport) {
        $(document).on("change", "input.customfile", function() {
            var $this = $(this),
                // Create a unique ID so we
                // can attach the label to the input
                uniqId = "customfile_" + new Date().getTime(),
                $wrap = $this.parent(),
                // Filter empty input
                $inputs = $wrap
                .siblings()
                .find(".file-upload-input")
                .filter(function() {
                    return !this.value;
                }),
                $file = $(
                    '<input type="file" id="' +
                    uniqId +
                    '" name="' +
                    $this.attr("name") +
                    '"/>'
                );

            // 1ms timeout so it runs after all other events
            // that modify the value have triggered
            setTimeout(function() {
                // Add a new input
                if ($this.val()) {
                    // Check for empty fields to prevent
                    // creating new inputs when changing files
                    if (!$inputs.length) {
                        $wrap.after($file);
                        $file.customFile();
                    }
                    // Remove and reorganize inputs
                } else {
                    $inputs.parent().remove();
                    // Move the input so it's always last on the list
                    $wrap.appendTo($wrap.parent());
                    $wrap.find("input").focus();
                }
            }, 1);
        });
    }
})(jQuery);

$("input[type=file]").customFile();


</script>

@yield('scripts')