<?php
/**
 * The Header
 *
 * Displays all of the <head> section and everything up till <main>
 *
 * @package Esotera
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<?php cryout_meta_hook(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php endif; ?>
<?php
	cryout_header_hook();
	wp_head();
?>
</head>

<body <?php body_class(); cryout_schema_microdata( 'body' );?>>
	<?php do_action( 'wp_body_open' ); ?>
	<?php cryout_body_hook(); ?>
	<div id="site-wrapper">

	<header id="masthead" class="cryout" <?php cryout_schema_microdata( 'header' ) ?>>

		<div id="site-header-main">

<!--			<div class="site-header-top">-->
<!---->
<!--				<div class="site-header-inside">-->
<!---->
<!--					--><?php //do_action( 'cryout_top_section_hook' ) ?>
<!---->
<!--					<div id="top-section-menu" role="navigation" aria-label="--><?php //esc_attr_e( 'Top Menu', 'esotera' ) ?><!--" --><?php //cryout_schema_microdata( 'menu' ); ?>
<!--						--><?php //cryout_topmenu_hook(); ?>
<!--					</div>-->
<!--					<button class="top-section-close"><i class="icon-cancel icon-cancel-hamburger"></i></button>-->
<!---->
<!--				</div>-->
<!---->
<!--			</div>-->

			<?php if ( has_nav_menu( 'primary' ) || ( true == cryout_get_option('theme_pagesmenu') ) ) { ?>
			<nav id="mobile-menu">
				<?php cryout_mobilemenu_hook(); ?>
				<button id="nav-cancel"><i class="icon-cancel"></i></button>
			</nav> <!-- #mobile-menu -->
			<?php } ?>

<!--			<div class="site-header-bottom">-->
<!---->
<!--				<div class="site-header-bottom-fixed">-->
<!---->
<!--					<div class="site-header-inside">-->
<!---->
<!--						<div id="branding">-->
<!--							--><?php //cryout_branding_hook();?>
<!--						</div> #branding -->
<!---->
<!--						--><?php //if ( has_nav_menu( 'primary' ) || ( true == cryout_get_option('theme_pagesmenu') ) ) { ?>
<!--						<button type="button" id="nav-toggle"><i class="icon-menu"></i></button>-->
<!---->
<!--						<nav id="access" aria-label="--><?php //esc_attr_e( 'Primary Menu', 'esotera' ) ?><!--" --><?php //cryout_schema_microdata( 'menu' ); ?><!-->-->
<!--							--><?php //cryout_access_hook();?>
<!--						</nav>-->
<!--						--><?php //} ?>
<!---->
<!--					</div>-->
<!---->
<!--				</div>-->
<!---->
<!--			</div>-->

		</div><!-- #site-header-main -->

<!--		<div id="header-image-main">-->
<!--			<div id="header-image-main-inside">-->
<!--				--><?php //cryout_headerimage_hook(); ?>
<!--			</div>-->
<!--		</div>-->

	</header><!-- #masthead -->

	<?php cryout_breadcrumbs_hook(); ?>

	<?php cryout_absolute_top_hook(); ?>

	<div id="content" class="cryout">
		<?php cryout_main_hook(); ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="csrf-token" content="U2mmCEq2A50JrtKTQ9ZVqYvQ69Muv89uHNls4oxA">

            <!-- <title>Laravel | Employee Engagement & Rewards</title> -->

            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,200,300,400,500,600,700">
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/tus-js-client@latest/dist/tus.min.js" async></script>
            <script src="https://player.vimeo.com/api/player.js" async></script>

            <script async src="https://www.googletagmanager.com/gtag/js?id=UA-196609813-1"></script>


            <style type="text/css">
                @import  url(https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap);
                @import  url(https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,500;0,600;0,700;0,800;0,900;1,500;1,600;1,700;1,800;1,900&display=swap);
                @import  url(https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap);
                @import  url(https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,500;0,600;0,700;0,800;0,900;1,500;1,600;1,700;1,800;1,900&display=swap);
                @import  url(https://fonts.googleapis.com/css2?family=Architects+Daughter&display=swap);
                @import  url(https://fonts.googleapis.com/css2?family=Annie+Use+Your+Telescope&display=swap);
                @import  url(https://fonts.googleapis.com/css2?family=Handlee&display=swap);
                @import  url(https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap);
                @import  url(https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap);
            </style>


            <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>

            <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
            <link href="/css/owl.carousel.css" type="text/css" rel="stylesheet">
            <link href="/css/owl.theme.default.css" type="text/css" rel="stylesheet">
            <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
            <link rel="stylesheet" type="text/css" href="/quill/quill-emoji.css">
            <script src="/quill/quill-emoji.js" async></script>
            <script src="/js/owl.carousel.js" async></script>


            <!-- <link rel="stylesheet" href="https://code.getmdl.io/1.1.3/material.blue_grey-light_blue.min.css" /> -->
            <script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>

            <link rel="shortcut icon" href="/other/perksweet-favicon.png">
            <!-- Styles -->
            <link rel="stylesheet" href="/css/app.css">
            <script src="/js/app.js" defer></script>
            <script defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>
            <script src="https://js.stripe.com/v3/"></script>

            <script>
                window.dataLayer = window.dataLayer || [];

                function gtag() {
                    dataLayer.push(arguments);
                }

                gtag('js', new Date());

                gtag('config', 'UA-196609813-1');
            </script>


            <style type="text/css">
                /* Scroll bar stylings */
                ::-webkit-scrollbar {
                    width: 14px;
                    height: 14px;
                }

                /* Track */
                /*::-webkit-scrollbar-track {*/
                /*    background: var(--lightestgrey);*/
                /*}*/

                /* Handle */
                ::-webkit-scrollbar-thumb {
                    background: #c7cbd1;
                    border-radius: 4px;
                }

                /* Handle on hover */
                ::-webkit-scrollbar-thumb:hover {
                    background: #9CA3AF;
                }

                /* Tooltip */
                .wrapper {
                    position: relative;
                    -webkit-transform: translateZ(0); /* webkit flicker fix */
                    -webkit-font-smoothing: antialiased; /* webkit text rendering fix */
                }

                .wrapper .tooltip {
                    text-align: center;
                    background: #000000;
                    bottom: 100%;
                    color: #fff;
                    display: block;
                    left: -25px;
                    margin-bottom: 9px;
                    opacity: 0;
                    padding: 5px 10px;
                    pointer-events: none;
                    position: absolute;
                    border-radius: 5px;
                    width: 80px;
                    z-index: 1000000000;
                    -webkit-transform: translateY(10px);
                    -moz-transform: translateY(10px);
                    -ms-transform: translateY(10px);
                    -o-transform: translateY(10px);
                    transform: translateY(10px);
                    -webkit-transition: all .25s ease-out;
                    -moz-transition: all .25s ease-out;
                    -ms-transition: all .25s ease-out;
                    -o-transition: all .25s ease-out;
                    transition: all .25s ease-out;
                    -webkit-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
                    -moz-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
                    -ms-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
                    -o-box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
                    box-shadow: 2px 2px 6px rgba(0, 0, 0, 0.28);
                }

                /* This bridges the gap so you can mouse into the tooltip without it disappearing */
                .wrapper .tooltip:before {
                    bottom: 0px;
                    content: " ";
                    display: block;
                    height: 0px;
                    left: 0;
                    position: absolute;
                    width: 100%;
                }

                /* CSS Triangles - see Trevor's post */
                .wrapper .tooltip:after {
                    border-left: solid transparent 10px;
                    border-right: solid transparent 10px;
                    border-top: solid #000000 10px;
                    bottom: -5px;
                    content: " ";
                    height: 0;
                    left: 50%;
                    margin-left: -13px;
                    position: absolute;
                    width: 0;
                    z-index: 1000000000;
                }

                .wrapper:hover .tooltip {
                    opacity: 1;
                    pointer-events: auto;
                    -webkit-transform: translateY(0px);
                    -moz-transform: translateY(0px);
                    -ms-transform: translateY(0px);
                    -o-transform: translateY(0px);
                    transform: translateY(0px);
                    z-index: 1000000000;
                }

                /* IE can just show/hide with no transition */
                .lte8 .wrapper .tooltip {
                    display: none;
                }

                .lte8 .wrapper:hover .tooltip {
                    display: block;
                }
            </style>




            <meta property="og:title" content="PerkSweet | Employee Engagement &amp; Rewards Platform">
            <title>PerkSweet | Employee Engagement &amp; Rewards Platform</title>
            <meta property="og:description" content="PerkSweet gives your team a variety of ways to show appreciation. Show employees you value them with PerkSweet.">
            <meta name="description" content="PerkSweet gives your team a variety of ways to show appreciation. Show employees you value them with PerkSweet.">
            <script type="application/ld+json">
                {
                    "@context": "http://www.schema.org",
                    "@type": "article",
                    "name": "PerkSweet | Employee Engagement &amp; Rewards Platform",
                    "url": "https://www.perksweet.com",
                    "image": "/other/perksweet.png",
                    "logo": "/other/perksweet.png",
                    "description": "PerkSweet gives your team a variety of ways to show appreciation. Show employees you value them with PerkSweet.",
                    "address": "345 Harrison Ave, Boston, MA 02118",
                    "sameAs": [
                        "https://twitter.com/perk_sweet/",
                        "https://www.linkedin.com/company/perksweet/",
                        "https://www.instagram.com/perksweet/",
                        "https://slack.com/apps/A023E3TJ2B1-perksweet?tab=more_info",
                        "https://www.g2.com/products/perksweet/reviews",
                        "https://www.capterra.com/p/233514/PerkSweet/"
                    ]
                }


            </script>
        </head>

        <div class="font-sans text-gray-900 antialiased">
            <meta property="og:title" content="PerkSweet | TEST Employee Engagement & Rewards Platform">
            <title>Laravel | Employee Engagement & Rewards Platform</title>
            <meta property="og:description" content="Employee Engagement & Rewards Platform ">
            <meta name="description" content="Employee Engagement & Rewards Platform">

            <!-- NL Added Parallax -->
            <script type="text/javascript" async="" src="/js/parallax.min.js"></script>

            <link rel="stylesheet" href="/css/nl_backup_1.css"> <!-- Required -->
            <link href="/css/nl_backup_2.css" rel="stylesheet"> <!-- Required -->


            <script type="text/javascript" src="/js/nl_js_backup_1.js"></script>  <!-- Required -->

            <!-- <script type="text/javascript" src="./public_files/forms2.min.js.download"></script>
            <script type="text/javascript" src="./public_files/home.70618205.dist.js.download"></script> -->


            <script>
                var _rollbarConfig = {
                    accessToken: "bba78f5de7fb4e0a824e3f954b56b0f5",
                    captureUncaught: true,
                    captureUnhandledRejections: true,
                    payload: {
                        environment: "production"
                    }
                };
                // Rollbar Snippet - NL account
                !function(r){var e={};function o(n){if(e[n])return e[n].exports;var t=e[n]={i:n,l:!1,exports:{}};return r[n].call(t.exports,t,t.exports,o),t.l=!0,t.exports}o.m=r,o.c=e,o.d=function(r,e,n){o.o(r,e)||Object.defineProperty(r,e,{enumerable:!0,get:n})},o.r=function(r){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(r,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(r,"__esModule",{value:!0})},o.t=function(r,e){if(1&e&&(r=o(r)),8&e)return r;if(4&e&&"object"==typeof r&&r&&r.__esModule)return r;var n=Object.create(null);if(o.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:r}),2&e&&"string"!=typeof r)for(var t in r)o.d(n,t,function(e){return r[e]}.bind(null,t));return n},o.n=function(r){var e=r&&r.__esModule?function(){return r.default}:function(){return r};return o.d(e,"a",e),e},o.o=function(r,e){return Object.prototype.hasOwnProperty.call(r,e)},o.p="",o(o.s=0)}([function(r,e,o){"use strict";var n=o(1),t=o(5);_rollbarConfig=_rollbarConfig||{},_rollbarConfig.rollbarJsUrl=_rollbarConfig.rollbarJsUrl||"https://cdn.rollbar.com/rollbarjs/refs/tags/v2.21.0/rollbar.min.js",_rollbarConfig.async=void 0===_rollbarConfig.async||_rollbarConfig.async;var a=n.setupShim(window,_rollbarConfig),l=t(_rollbarConfig);window.rollbar=n.Rollbar,a.loadFull(window,document,!_rollbarConfig.async,_rollbarConfig,l)},function(r,e,o){"use strict";var n=o(2),t=o(3);function a(r){return function(){try{return r.apply(this,arguments)}catch(r){try{console.error("[Rollbar]: Internal error",r)}catch(r){}}}}var l=0;function i(r,e){this.options=r,this._rollbarOldOnError=null;var o=l++;this.shimId=function(){return o},"undefined"!=typeof window&&window._rollbarShims&&(window._rollbarShims[o]={handler:e,messages:[]})}var s=o(4),d=function(r,e){return new i(r,e)},c=function(r){return new s(d,r)};function u(r){return a((function(){var e=this,o=Array.prototype.slice.call(arguments,0),n={shim:e,method:r,args:o,ts:new Date};window._rollbarShims[this.shimId()].messages.push(n)}))}i.prototype.loadFull=function(r,e,o,n,t){var l=!1,i=e.createElement("script"),s=e.getElementsByTagName("script")[0],d=s.parentNode;i.crossOrigin="",i.src=n.rollbarJsUrl,o||(i.async=!0),i.onload=i.onreadystatechange=a((function(){if(!(l||this.readyState&&"loaded"!==this.readyState&&"complete"!==this.readyState)){i.onload=i.onreadystatechange=null;try{d.removeChild(i)}catch(r){}l=!0,function(){var e;if(void 0===r._rollbarDidLoad){e=new Error("rollbar.js did not load");for(var o,n,a,l,i=0;o=r._rollbarShims[i++];)for(o=o.messages||[];n=o.shift();)for(a=n.args||[],i=0;i<a.length;++i)if("function"==typeof(l=a[i])){l(e);break}}"function"==typeof t&&t(e)}()}})),d.insertBefore(i,s)},i.prototype.wrap=function(r,e,o){try{var n;if(n="function"==typeof e?e:function(){return e||{}},"function"!=typeof r)return r;if(r._isWrap)return r;if(!r._rollbar_wrapped&&(r._rollbar_wrapped=function(){o&&"function"==typeof o&&o.apply(this,arguments);try{return r.apply(this,arguments)}catch(o){var e=o;throw e&&("string"==typeof e&&(e=new String(e)),e._rollbarContext=n()||{},e._rollbarContext._wrappedSource=r.toString(),window._rollbarWrappedError=e),e}},r._rollbar_wrapped._isWrap=!0,r.hasOwnProperty))for(var t in r)r.hasOwnProperty(t)&&(r._rollbar_wrapped[t]=r[t]);return r._rollbar_wrapped}catch(e){return r}};for(var p="log,debug,info,warn,warning,error,critical,global,configure,handleUncaughtException,handleAnonymousErrors,handleUnhandledRejection,captureEvent,captureDomContentLoaded,captureLoad".split(","),f=0;f<p.length;++f)i.prototype[p[f]]=u(p[f]);r.exports={setupShim:function(r,e){if(r){var o=e.globalAlias||"Rollbar";if("object"==typeof r[o])return r[o];r._rollbarShims={},r._rollbarWrappedError=null;var l=new c(e);return a((function(){e.captureUncaught&&(l._rollbarOldOnError=r.onerror,n.captureUncaughtExceptions(r,l,!0),e.wrapGlobalEventHandlers&&t(r,l,!0)),e.captureUnhandledRejections&&n.captureUnhandledRejections(r,l,!0);var a=e.autoInstrument;return!1!==e.enabled&&(void 0===a||!0===a||"object"==typeof a&&a.network)&&r.addEventListener&&(r.addEventListener("load",l.captureLoad.bind(l)),r.addEventListener("DOMContentLoaded",l.captureDomContentLoaded.bind(l))),r[o]=l,l}))()}},Rollbar:c}},function(r,e,o){"use strict";function n(r,e,o,n){r._rollbarWrappedError&&(n[4]||(n[4]=r._rollbarWrappedError),n[5]||(n[5]=r._rollbarWrappedError._rollbarContext),r._rollbarWrappedError=null);var t=e.handleUncaughtException.apply(e,n);o&&o.apply(r,n),"anonymous"===t&&(e.anonymousErrorsPending+=1)}r.exports={captureUncaughtExceptions:function(r,e,o){if(r){var t;if("function"==typeof e._rollbarOldOnError)t=e._rollbarOldOnError;else if(r.onerror){for(t=r.onerror;t._rollbarOldOnError;)t=t._rollbarOldOnError;e._rollbarOldOnError=t}e.handleAnonymousErrors();var a=function(){var o=Array.prototype.slice.call(arguments,0);n(r,e,t,o)};o&&(a._rollbarOldOnError=t),r.onerror=a}},captureUnhandledRejections:function(r,e,o){if(r){"function"==typeof r._rollbarURH&&r._rollbarURH.belongsToShim&&r.removeEventListener("unhandledrejection",r._rollbarURH);var n=function(r){var o,n,t;try{o=r.reason}catch(r){o=void 0}try{n=r.promise}catch(r){n="[unhandledrejection] error getting `promise` from event"}try{t=r.detail,!o&&t&&(o=t.reason,n=t.promise)}catch(r){}o||(o="[unhandledrejection] error getting `reason` from event"),e&&e.handleUnhandledRejection&&e.handleUnhandledRejection(o,n)};n.belongsToShim=o,r._rollbarURH=n,r.addEventListener("unhandledrejection",n)}}}},function(r,e,o){"use strict";function n(r,e,o){if(e.hasOwnProperty&&e.hasOwnProperty("addEventListener")){for(var n=e.addEventListener;n._rollbarOldAdd&&n.belongsToShim;)n=n._rollbarOldAdd;var t=function(e,o,t){n.call(this,e,r.wrap(o),t)};t._rollbarOldAdd=n,t.belongsToShim=o,e.addEventListener=t;for(var a=e.removeEventListener;a._rollbarOldRemove&&a.belongsToShim;)a=a._rollbarOldRemove;var l=function(r,e,o){a.call(this,r,e&&e._rollbar_wrapped||e,o)};l._rollbarOldRemove=a,l.belongsToShim=o,e.removeEventListener=l}}r.exports=function(r,e,o){if(r){var t,a,l="EventTarget,Window,Node,ApplicationCache,AudioTrackList,ChannelMergerNode,CryptoOperation,EventSource,FileReader,HTMLUnknownElement,IDBDatabase,IDBRequest,IDBTransaction,KeyOperation,MediaController,MessagePort,ModalWindow,Notification,SVGElementInstance,Screen,TextTrack,TextTrackCue,TextTrackList,WebSocket,WebSocketWorker,Worker,XMLHttpRequest,XMLHttpRequestEventTarget,XMLHttpRequestUpload".split(",");for(t=0;t<l.length;++t)r[a=l[t]]&&r[a].prototype&&n(e,r[a].prototype,o)}}},function(r,e,o){"use strict";function n(r,e){this.impl=r(e,this),this.options=e,function(r){for(var e=function(r){return function(){var e=Array.prototype.slice.call(arguments,0);if(this.impl[r])return this.impl[r].apply(this.impl,e)}},o="log,debug,info,warn,warning,error,critical,global,configure,handleUncaughtException,handleAnonymousErrors,handleUnhandledRejection,_createItem,wrap,loadFull,shimId,captureEvent,captureDomContentLoaded,captureLoad".split(","),n=0;n<o.length;n++)r[o[n]]=e(o[n])}(n.prototype)}n.prototype._swapAndProcessMessages=function(r,e){var o,n,t;for(this.impl=r(this.options);o=e.shift();)n=o.method,t=o.args,this[n]&&"function"==typeof this[n]&&("captureDomContentLoaded"===n||"captureLoad"===n?this[n].apply(this,[t[0],o.ts]):this[n].apply(this,t));return this},r.exports=n},function(r,e,o){"use strict";r.exports=function(r){return function(e){if(!e&&!window._rollbarInitialized){for(var o,n,t=(r=r||{}).globalAlias||"Rollbar",a=window.rollbar,l=function(r){return new a(r)},i=0;o=window._rollbarShims[i++];)n||(n=o.handler),o.handler._swapAndProcessMessages(l,o.messages);window[t]=n,window._rollbarInitialized=!0}}}}]);
                // End Rollbar Snippet
            </script>

            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="canonical" href="/">
            <link rel="shortcut icon" type="image/x-icon" href="/other/perksweet.png">
            <!-- For iPhone -->
            <link rel="apple-touch-icon-precomposed" href="/other/perksweet.png">
            <!-- For iPhone 4 Retina display -->
            <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/other/perksweet.png">
            <!-- For iPad -->
            <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/other/perksweet.png">
            <!-- For iPad Retina display -->
            <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/other/perksweet.png">







            <meta name="twitter:card" content="summary">
            <meta name="twitter:site" content="@perk_sweet">
            <meta name="twitter:creator" content="@perk_sweet">

            <meta property="og:type" content="article">
            <meta property="og:url" content="https://www.perksweet.com/">
            <meta property="og:image" content="/other/perksweet.png">
            <meta property="og:site_name" content="PerkSweet">



            <script type="application/ld+json">
                {
                    "@context":"http://schema.org",
                    "@type":"ItemList",
                    "itemListElement":[
                        {
                            "@type":"ListItem",
                            "position":1,
                            "url":"/rewards-process"
                        },
                        {
                            "@type":"ListItem",
                            "position":2,
                            "url":"/group-cards"
                        },
                        {
                            "@type":"ListItem",
                            "position":3,
                            "url":"/perksweet-connect"
                        },
                        {
                            "@type":"ListItem",
                            "position":4,
                            "url":"/appreciation"
                        },
                        {
                            "@type":"ListItem",
                            "position":5,
                            "url":"/stay-connected"
                        },
                        {
                            "@type":"ListItem",
                            "position":6,
                            "url":"/inclusion"
                        },
                        {
                            "@type":"ListItem",
                            "position":7,
                            "url":"/contact"
                        },
                        {
                            "@type":"ListItem",
                            "position":8,
                            "url":"/pricing"
                        },
                        {
                            "@type":"ListItem",
                            "position":9,
                            "url":"/slack"
                        }
                    ]
                }

            </script>
            </head>

            <body class="vsc-initialized">
            <a href="#skipToContent" class="acc-out-of-view">Skip to Content</a>
            <header class="bg-white Navbar js-nav" role="navigation">
                <div class="Navbar__container js-nav-main">
                    <div class="NavbarMain">
                        <div class="NavbarMain__left NavbarMain__wrapper NavbarMain__wrapper--left js-nav-logo">


                            <a class="NavbarMain__logoWrapper" href="/">
                                <image src="/other/perksweet.png" class="h-12 lg:h-14" >
                            </a>


                        </div>
                        <div class="text-gray-600 NavbarMain__middle NavbarMain__wrapper NavbarMain__wrapper--middle">
                            <div class="NavbarMain__tabContainer">
                                <div class="ps_nav_tab_wrap ps_nav_open_drop_push">
                                    <div class="NavbarMain__tab">Our Platform</div>
                                    <ul class="bg-gray-100 custom-nav-bg-gray NavbarDrop NavbarDrop--2 js-nav-drop-block">
                                        <div
                                            class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--2 NavbarDrop2--default ps-nav-drop2495-block-def-two">
                                            <div
                                                class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--default ps-nav-4945-info-5iti-block-def-three">
                                                <h4 class="text-gray-900 NavbarDrop2__infoHeading">Our Platform</h4>
                                                <p class="text-gray-900 NavbarDrop2__info">Learn how Laravel helps build amazing
                                                    teams.</p>
                                            </div>
                                        </div>
                                        <li class="bg-white NavbarDrop__linkWrap NavbarDrop__linkWrap--2 js-nav-drop2-block-opener">
                                            <a class="text-gray-500 NavbarDrop__link NavbarDrop__link--first NavbarDrop__link--noArrow"
                                               href="/rewards-process">Seamless Rewards Process</a>
                                            <div
                                                class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--small js-nav-drop2-block">
                                                <div class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--small js-nav-info-block">
                                                    <h4 class="text-gray-900 NavbarDrop2__infoHeading">Seamless Rewards
                                                        Process</h4>
                                                    <p class="text-gray-900 NavbarDrop2__info">Intuitive, engaging, and
                                                        collaborative rewards process with select incentives to show employees you
                                                        value them beyond a paycheck.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="bg-white NavbarDrop__linkWrap NavbarDrop__linkWrap--2 js-nav-drop2-block-opener">
                                            <a class="text-gray-500 NavbarDrop__link NavbarDrop__link--noArrow"
                                               href="/group-cards">Robust Group Card Solution </a>
                                            <div
                                                class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--small js-nav-drop2-block">
                                                <div class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--small js-nav-info-block">
                                                    <h4 class="text-gray-900 NavbarDrop2__infoHeading">Robust Group Card
                                                        Solution</h4>
                                                    <p class="text-gray-900 NavbarDrop2__info"> Laravel allows you to build Group
                                                        Cards for any occasion. Whether it's a colleagues
                                                        birthday, wedding day, or congratulations are in order— Laravel Group
                                                        Cards can
                                                        deliver a powerful message.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="bg-white NavbarDrop__linkWrap NavbarDrop__linkWrap--2 js-nav-drop2-block-opener">
                                            <a class="text-gray-500 NavbarDrop__link NavbarDrop__link--noArrow"
                                               href="/perksweet-connect">Opt-in Automated Networking Capability</a>
                                            <div
                                                class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--small js-nav-drop2-block">
                                                <div class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--small js-nav-info-block">
                                                    <h4 class="text-gray-900 NavbarDrop2__infoHeading">Opt-in Automated
                                                        Networking Capability</h4>
                                                    <p class="text-gray-900 NavbarDrop2__info">Laravel Connect enables users to
                                                        opt-in to set up one-on-one meetings with another member of your company entirely via email calendar invitations. </p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="bg-white NavbarDrop__linkWrap NavbarDrop__linkWrap--2 js-nav-drop2-block-opener NavbarDrop__linkWrap--last">
                                            <a class="text-gray-500 NavbarDrop__link NavbarDrop__link--noArrow"
                                               href="/pricing">Pricing</a>
                                            <div
                                                class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--small js-nav-drop2-block">
                                                <div class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--small js-nav-info-block">
                                                    <h4 class="text-gray-900 NavbarDrop2__infoHeading">Pricing</h4>
                                                    <p class="text-gray-900 NavbarDrop2__info">Straight forward pricing structure
                                                        with no surprise fees and zero commitment. Allows you to reward the
                                                        wonderful people at your company who deserve it most.</p>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>


                                <div class="ps_nav_tab_wrap ps_nav_open_drop_push">
                                    <div class="NavbarMain__tab">Why Perksweet</div>
                                    <ul class="bg-gray-100 custom-nav-bg-gray NavbarDrop NavbarDrop--2 js-nav-drop-block">
                                        <div
                                            class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--2 NavbarDrop2--default ps-nav-drop2495-block-def-two">
                                            <div
                                                class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--default ps-nav-4945-info-5iti-block-def-three">
                                                <h4 class="text-gray-900 NavbarDrop2__infoHeading">Why Laravel</h4>
                                                <p class="text-gray-900 NavbarDrop2__info">A few good reasons to choose Laravel
                                                    for your business.</p>
                                            </div>
                                        </div>
                                        <li class="bg-white NavbarDrop__linkWrap NavbarDrop__linkWrap--2 js-nav-drop2-block-opener">
                                            <a class="text-gray-500 NavbarDrop__link NavbarDrop__link--first NavbarDrop__link--noArrow"
                                               href="/appreciation">Show Appreciation</a>
                                            <div
                                                class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--small js-nav-drop2-block">
                                                <div class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--small js-nav-info-block">
                                                    <h4 class="text-gray-900 NavbarDrop2__infoHeading">Show
                                                        Appreciation</h4>
                                                    <p class="text-gray-900 NavbarDrop2__info">Employee rewards platform that allows
                                                        you to show your appreciation for those that go above and beyond
                                                        everyday.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="bg-white NavbarDrop__linkWrap NavbarDrop__linkWrap--2 js-nav-drop2-block-opener">
                                            <a class="text-gray-500 NavbarDrop__link NavbarDrop__link--noArrow"
                                               href="/inclusion">Create an Inclusive Culture</a>
                                            <div
                                                class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--small js-nav-drop2-block">
                                                <div class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--small js-nav-info-block">
                                                    <h4 class="text-gray-900 NavbarDrop2__infoHeading">Create an Inclusive
                                                        Culture</h4>
                                                    <p class="text-gray-900 NavbarDrop2__info">The Laravel platform allows every
                                                        member of your team feel valued.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="bg-white NavbarDrop__linkWrap NavbarDrop__linkWrap--2 js-nav-drop2-block-opener">
                                            <a class="text-gray-500 NavbarDrop__link NavbarDrop__link--noArrow"
                                               href="/reduce-turnover">Lower Voluntary Turnover</a>
                                            <div
                                                class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--small js-nav-drop2-block">
                                                <div class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--small js-nav-info-block">
                                                    <h4 class="text-gray-900 NavbarDrop2__infoHeading">Lower Voluntary Turnover</h4>
                                                    <p class="text-gray-900 NavbarDrop2__info">Research consistently shows that companies with employee recognition systems keep their best performing people the longest & create a positive environment for new top talent.</p>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>


                                <div class="ps_nav_tab_wrap ps_nav_open_drop_push">
                                    <div class="NavbarMain__tab">About Perksweet</div>
                                    <ul class="bg-gray-100 custom-nav-bg-gray NavbarDrop NavbarDrop--4 js-nav-drop-block">
                                        <div
                                            class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--4 NavbarDrop2--default ps-nav-drop2495-block-def-two">
                                            <div
                                                class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--small NavbarDrop2__infoWrap--default ps-nav-4945-info-5iti-block-def-three">
                                                <h4 class="text-gray-900 NavbarDrop2__infoHeading">About Laravel</h4>
                                                <p class="text-gray-900 NavbarDrop2__info">Learn about Laravel and its
                                                    origins!</p>
                                            </div>
                                        </div>
                                        <li class="bg-white NavbarDrop__linkWrap NavbarDrop__linkWrap--4 js-nav-drop2-block-opener">
                                            <a class="text-gray-500 NavbarDrop__link NavbarDrop__link--first NavbarDrop__link--noArrow"
                                               href="/about">About PerkSweet</a>
                                            <div
                                                class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--small js-nav-drop2-block">
                                                <div class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--small js-nav-info-block">
                                                    <h4 class="text-gray-900 NavbarDrop2__infoHeading">
                                                        About PerkSweet
                                                    </h4>
                                                    <p class="text-gray-900 NavbarDrop2__info">PerkSweet is a small team with a
                                                        goal to bring positivity to the workplace.</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="bg-white NavbarDrop__linkWrap NavbarDrop__linkWrap--4 NavbarDrop__linkWrap--smallLast js-nav-drop2-block-opener pb-12">
                                            <a class="text-gray-500 NavbarDrop__link NavbarDrop__link--smallLast NavbarDrop__link--noArrow"
                                               href="/contact">Contact</a>
                                            <div
                                                class="bg-gray-100 custom-nav-bg-gray NavbarDrop2 NavbarDrop2--small js-nav-drop2-block">
                                                <div class="NavbarDrop2__infoWrap NavbarDrop2__infoWrap--small js-nav-info-block">
                                                    <h4 class="text-gray-900 NavbarDrop2__infoHeading">Contact</h4>
                                                    <p class="text-gray-900 NavbarDrop2__info">Get in touch with a member of the
                                                        Laravel team!</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>

                        <div class="NavbarMain__wrapper NavbarMain__wrapper--right">
                            <a class="text-center Button Button--stroke Button--small NavbarMain__link js-nav-login"
                               href="/login" aria-label="Click to login">Log In</a>
                            <a class="text-center Button Button--small NavbarMain__link NavbarMain__link--button"
                               href="/register/company">Try It Free</a>
                        </div>
                    </div>
                </div>
        </div>
        <div class="NavbarMobileBar js-nav-mobile-bar" style="margin-bottom: 65px">
            <div class="NavbarMobileBar__container">


                <a class="NavbarMobileBar__logoLink" href="/">
                    <image src="/other/perksweet.png" class="h-12 lg:h-14" >
                </a>


                <svg class="NavbarMobileBar__hamburgerIcon js-nav-mobile-opener" width="30" height="30" viewBox="0 0 24 24"
                     stroke-width="2" stroke="currentcolor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <line x1="4" y1="6" x2="20" y2="6"/>
                    <line x1="4" y1="12" x2="20" y2="12"/>
                    <line x1="4" y1="18" x2="20" y2="18"/>
                </svg>

            </div>
        </div>
        </html>
