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
    <script src="{{ asset('/public/vendor/uikit/3.16.3/js/uikit.min.js')}}"></script>
    <script src="{{ asset('/public/vendor/uikit/3.16.3/js/uikit-icons.min.js')}}"></script>
    <!-- end template assets -->
    <!-- global assets -->
    @yield('global-assets')
    <!-- end global assets -->
    <!-- component assets -->
    @yield('component-assets')
    <!-- end component assets -->

    <!-- define js variables from component page -->
    @yield('script-definitions')
  </head>
  <body>

  <nav class="uk-navbar-container" uk-navbar>
  <div class="uk-navbar-left">
    <a class="uk-navbar-item uk-logo" href="#">Logo</a>
    <ul class="uk-navbar-nav uk-visible@m">
        @isset($topMenu)
            @foreach ($topMenu as $item)
            <li>
                <a href="{{$item->route}}">{{$item->name}}</a>
                @if (@filled($item->itemList))
                        <div class="uk-navbar-dropdown">
                            <ul class="uk-nav uk-navbar-dropdown-nav">
                                @foreach ($item->itemList as $subnav)
                                <li class="<?php $subnav->is_active ? "uk-active" : "" ;?>"><a href="{{ route($subnav->route) }}">{{ $subnav->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endif
                
            @endforeach
        @endisset
      <li class="uk-active"><a href="#">Home</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <button class="uk-button uk-button-default uk-hidden@m" type="button" uk-toggle="target: #offcanvas-flip"><span uk-icon="icon: menu"></span></button>
  </div>




    <div id="offcanvas-flip" uk-offcanvas="flip: true; overlay: true">
        <div class="uk-offcanvas-bar">

            <button class="uk-offcanvas-close" type="button" uk-close></button>

            <div class="uk-width-1-2@s uk-width-2-5@m">
                <ul class="uk-nav uk-nav-default">
                    <li class="uk-active"><a href="#">Active</a></li>
                    <li class="uk-parent">
                        <a href="#">Parent</a>
                        <ul class="uk-nav-sub">
                            <li><a href="#">Sub item</a></li>
                            <li>
                                <a href="#">Sub item</a>
                                <ul>
                                    <li><a href="#">Sub item</a></li>
                                    <li><a href="#">Sub item</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</nav>

<section>    
    @yield('page-menu')
</section>

<section>    
    @yield('page-content')
</section>    

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