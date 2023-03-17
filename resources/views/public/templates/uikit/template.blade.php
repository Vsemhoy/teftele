<!DOCTYPE html lang='en'>
<html>
  <head>
    <meta charset="UTF-8">
    <title>{{ isset($meta_title) ? $meta_title : "No title" }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ isset($meta_description) ? $meta_description : 'No description' }}">
    <meta name="keywords" content="{{ isset($meta_keywords) ? $meta_keywords : 'No keywords' }}">

    <!-- template assets -->
    <link rel="stylesheet" href="{{ asset('/public/vendor/uikit/3.16.3/css/uikit.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/vendor/uikit/css/custom.css') }}" />
    <script src="{{ asset('/public/vendor/uikit/3.16.3/js/uikit.min.js')}}"></script>
    <script src="{{ asset('/public/vendor/uikit/3.16.3/js/uikit-icons.min.js')}}"></script>
    <!-- end template assets -->
    <!-- global assets -->
    @yield('global-assets')
    <!-- end global assets -->
    <!-- component assets -->
    @yield('component-assets')
    <!-- end component assets -->

    @yield('system-scripts')
    <!-- define js variables from component page -->
    @yield('script-definitions')
  </head>
  <body class='u-custom-gradient-bg'>

  <nav class="uk-navbar-container u-custom-head" id='go_top' uk-navbar>
  <div class="uk-navbar-left">
    
    <div class="uk-navbar-item uk-logo u-custom-uk-logo" href="#">
@if (isset($component_sidebar_trigger) AND filled($component_sidebar_trigger))
    <div class='u-component-sidebar-trigger'>
        <span class="bi-layout-sidebar-inset"></span>
    </div>
@else
    <a href="#"><span class="bi-emoji-smile"></span></a>
@endif

</div>
    <ul class="uk-navbar-nav uk-visible@m">
        @isset($topMenu)
            @foreach ($topMenu as $item)
            <li class="<?php echo ($item->is_active ? "uk-active" : "") ;?> u-custom-menu-item">
                <a href="{{ route($item->route) }}">{{$item->name}}</a>
                @if (@filled($item->itemList))
                        <div class="uk-navbar-dropdown u-custom-up-menu">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                @foreach ($item->itemList as $subnav)
                                <li class="<?php echo ($subnav->is_active ? "uk-active" : "") ;?>"><a href="{{ route($subnav->route) }}">{{ $subnav->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
                
            @endforeach
        @endisset
      <li class=' u-custom-menu-item'><a href="#">Home</a></li>
      <li class=' u-custom-menu-item'><a href="#">Contact</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav uk-visible@m">
        <li ><a href="#">Home</a></li>
        <li><a href="#">Contact</a></li>
      </ul>
    <button class="uk-button uk-button-default uk-hidden@m" type="button" uk-toggle="target: #offcanvas-flip"><span uk-icon="icon: menu"></span></button>
  </div>



</nav>

    <div id="offcanvas-flip" uk-offcanvas="flip: true; overlay: true">
        <div class="uk-offcanvas-bar">

            <button class="uk-offcanvas-close" type="button" uk-close></button>

            <div class="uk-width-1-2@s uk-width-2-5@m">
                <ul class="uk-nav uk-nav-default">
                @isset($topMenu)
            @foreach ($topMenu as $item)
            <li class="<?php echo ($item->is_active ? "uk-active" : "") ;?>">
                <a href="{{ route($item->route) }}">{{$item->name}}</a>
                @if (@filled($item->itemList))
                        <div class="uk-navbar-dropdown u-custom-up-menu">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                @foreach ($item->itemList as $subnav)
                                <li class="<?php echo ($subnav->is_active ? "uk-active" : "") ;?>"><a href="{{ route($subnav->route) }}">{{ $subnav->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
                
            @endforeach
        @endisset
                </ul>
            </div>

        </div>
    </div>

<section>    
    @yield('page-menu')
</section>

<section>    
    @yield('page-content')
</section>

<div class='u-custom-nav-widget' id='u-custom-nav-widget'>
    <div class='u-custom-widget-buttons-start'>
        <a href='#go_top'>UP</a>
    </div>
    <div id='u-custom-nav-component-buttons'>
    </div>
    <div class='u-custom-widget-buttons-end'>
        <a href='#go_down'>DN</a>
    </div>
</div>
<div id='go_down'></div>

    @yield('component-scripts')
    @yield('page-scripts')
</body>
</html>





<?php
//@ y ield('public.page-scripts')
?>
<?php 
// $folder = $_SERVER["DOCUMENT_ROOT"] . "public" . DIRECTORY_SEPARATOR . "vendor" . DIRECTORY_SEPARATOR . "bootstrap". DIRECTORY_SEPARATOR . "bootstrap-icons-1.10.3";

// if ($handle = opendir($folder)) {

//     while (false !== ($entry = readdir($handle))) {

//         if ($entry != "." && $entry != "..") {
//             $file = file_get_contents($folder . DIRECTORY_SEPARATOR . $entry);
//             $reader = htmlentities( str_replace('"', "'", $file), ENT_QUOTES);
            
//             $result = "";
//             $result .= "
// .bi-" . pathinfo($entry, PATHINFO_FILENAME) . "::before {<br>
//     background-image: url(data:image/svg+xml,\"" . $reader . "\");
// <br>
// }
// ";
//             echo "$result\n</br>";
//         }
//     }

//     closedir($handle);
// }