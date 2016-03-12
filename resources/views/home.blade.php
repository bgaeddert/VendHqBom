<!DOCTYPE html>
<html lang="en">
<head>
    <title>Product Tools</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <link rel='stylesheet' href='http://fonts.googleapis.com/css?family=Roboto:400,500,700,400italic'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/angular-material/1.0.6/angular-material.css"/>
    {{--<link rel="stylesheet" href="app/assets/stylesheets/app.css?v={{time()}}"/>--}}

    <style type="text/css">
        /**
         * Hide when Angular is not yet loaded and initialized
         */
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
            display: none !important;
        }

       /* md-sidenav {
            width: 250px;
            max-width: 250px;
        }*/

        .mcg-list-icon {
            margin-left: 10px !important;
            margin-right: 10px !important;
        }
    </style>

</head>

<body ng-app="productToolsApp" ng-controller="HomeController as HomeCtrl" layout="column" ng-cloak>

<!--TOOLBAR--><!--TOOLBAR--><!--TOOLBAR-->
<md-toolbar layout="row">
    <div class="md-toolbar-tools">
        <md-button class="md-icon-button" aria-label="Settings">
            <md-icon ng-click="HomeCtrl.toggleMenu()"> menu</md-icon>
        </md-button>
        <h2>
            <a ui-sref="home">Productor</a>
        </h2>

        <!--SPACE FILLER-->
        <span flex></span>

        <span>Vend&nbsp;</span>

        <!--VEND VERIFIED-->
        <md-button class="md-icon-button" ng-show="HomeCtrl.hasFreshVendToken" ui-sref="vend-accept"
                   aria-label="More">
            <md-tooltip md-direction="botom">
                Your are connected to vend
            </md-tooltip>
            <md-icon>check_circle</md-icon>
        </md-button>

        <!--VEND ERROR-->
        <md-button class="md-icon-button" ng-show="!HomeCtrl.hasFreshVendToken" ui-sref="vend-accept"
                   aria-label="More">
            <md-tooltip md-direction="botom">
                Click to connect to vend.
            </md-tooltip>
            <md-icon>error</md-icon>
        </md-button>
    </div>
</md-toolbar>

<!--BODY--><!--BODY--><!--BODY-->
<div layout="row" flex>

    <!--SIDE BAR NAV-->
    <md-sidenav layout="column"
                class="site-sidenav md-sidenav-left md-whiteframe-z2"
                aria-label="Side Bar Navigation"
                md-is-locked-open="$mdMedia('gt-sm')"
                md-component-id="left"

    >
        <md-list>

            <md-list-item class="md-1-line" ui-sref="vend-products">
                <md-icon class="mcg-list-icon">assignment</md-icon>
                <div class="md-list-item-text">
                    <h4> Raw Materials </h4>
                </div>
            </md-list-item>

            <md-list-item class="md-1-line" ui-sref="bom-create">
                <md-icon class="mcg-list-icon">assignment</md-icon>
                <div class="md-list-item-text">
                    <h4> Bills of Material </h4>
                </div>
            </md-list-item>

        </md-list>

    </md-sidenav>

    <!--UI VIEW-->
    <md-content id="content" flex>
        {{--<div style="">
            <p>user = @{{HomeCtrl.user}}</p>
            <p>vendAuth = @{{HomeCtrl.VendAuth}}</p>
            <p>vendCreds = @{{HomeCtrl.VendCreds}}</p>
            <p>hasFreshVendToken = @{{HomeCtrl.hasFreshVendToken}}</p>
        </div>--}}
        <ui-view></ui-view>
    </md-content>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular-animate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular-aria.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-material/1.0.6/angular-material.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.18/angular-ui-router.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular-messages.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.5.0/angular-message-format.js"></script>


<script src="/product-tools/app/app.js"></script>
<script src="/product-tools/app/services/services.js"></script>


</body>
</html>