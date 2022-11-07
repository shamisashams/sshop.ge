<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{$meta_title}}</title>
    <meta name="description"
          content="{{ $meta_description }}">
    <meta name="keywords" content="{{ $meta_keyword }}">
    <meta property="og:title" content="{{ $og_title }}">
    <meta property="og:description" content="{{ $og_description }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if($image)
        <meta property="og:image" content={{"/".$image->path."/".$image->title}}>
    @endif
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:type" content="page">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet"/>
    <meta name="google-site-verification" content="w6r4rFaWspHKKkz-AqaINXixTx03V6oW5Vzg5gHfiNs" />
    <script src="https://webstatic.bog.ge/bog-sdk/bog-sdk.js?client_id=16021"></script>
{{--    @if(app()->getLocale()=="ge")--}}
{{--        <link href="{{ mix('/css/AppGeo.css') }}" rel="stylesheet"/>--}}
{{--    @elseif(app()->getLocale()=="en")--}}
{{--        <link href="{{ mix('/css/AppEng.css') }}" rel="stylesheet"/>--}}
{{--    @endif--}}
    {{--    @dd($page["props"]["page"]["meta_title"])--}}
    <link rel="icon" type="image/jpeg" href="{{asset('/assets/images/favicon.jpg')}}" />
    @routes
    <!-- JQUERY JS -->
    <script src="{{asset('admin/assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <script>
        function __(key, sharedData, replace = {}) {
            let data = key.split('.');
            //console.log(sharedData);
            let translation = sharedData[data[1]] || key;

            Object.keys(replace).forEach(function (key) {
                translation = translation.replace(':' + key, replace[key])
            });

            //console.log(translation);
            return translation;

        }

        String.prototype.newLineToBr = function () {
            return this.replace(/(?:\r\n|\r|\n)/g, '<br>');
        };

        /*Array.prototype.remove = function() {
            var what, a = arguments, L = a.length, ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                    this.splice(ax, 1);
                }
            }
            return this;
        };*/
        const breadcrumb = function (path) {
            let rows = '';
            path.map(function (el, i) {
                if (i < path.length - 1) {
                    rows += el.title;
                    rows += ' / ';
                } else {
                    rows += el.title;
                }
            });
            return rows;
        };

        function translateDate(date){
            let date_arr = date.split('  ');

            let locale = '{{app()->getLocale()}}';
            let month = date_arr[1];
            console.warn(date_arr);
            let months = {
                en: {January: "January",February: "February",March: "March",April: "April",May:"May",June:"June",July:"July",August:"August",September:"September",October:"October",November:"November",December:"December"},
                ge: {January: "იანვარი",February: "თებერვალი",March: "მარტი",April: "აპრილი",May:"მაისი",June:"ივნისი",July:"ივლისი",August:"აგვისტო",September:"სექტემბერი",October:"ოქტომბერი",November:"ნოემბერი",December:"დექემბერი"}
            };
            let loc_month = months[locale][month];

            date_arr[1] = loc_month;
            return date_arr.join(' ');
        }

    </script>
    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '6279913775357690');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=6279913775357690&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Meta Pixel Code -->
</head>
<body>

<!-- Messenger Chat plugin Code -->
<div id="fb-root"></div>

<!-- Your Chat plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>


<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "105464005602533");
    chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v15.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
@inertia



</body>

</html>
