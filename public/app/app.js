angular
    .module('productToolsApp', ['ngMaterial', 'ui.router','ngMessages'])

    .config(function ($mdThemingProvider, $mdIconProvider) {

        $mdThemingProvider.theme('default')
            .primaryPalette('indigo')
            .accentPalette('amber');

    })
    .config(['$httpProvider', function ($httpProvider) {
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
    }])

    .config(function ($stateProvider, $urlRouterProvider, $locationProvider) {

        //
        // For any unmatched url, redirect to /home
        $urlRouterProvider.otherwise(function ($injector, $location) {
            return "/product-tools";
        });


        //
        // Now set up the states
        $stateProvider

        /*-----------------------------
         |   HOME
         ----------------------------*/
            .state('home', {
                url: "/product-tools",
                templateUrl: "/product-tools/app/templates/home.html?v=" + randNumber()
            })
            .state('vend-accept', {
                url: "/product-tools/vend-accept",
                templateUrl: "/product-tools/app/templates/vendaccept.html?v=" + randNumber(),
                controller: function ($sce, user, vendAuth, vendCreds) {
                    this.user = user;
                    this.vendAuth = vendAuth;
                    this.vendCreds = vendCreds;
                    this.iframeSrc = $sce.trustAsResourceUrl('https://secure.vendhq.com/connect?response_type=code&client_id=' + this.vendCreds.client_id + '&redirect_uri=' + this.vendCreds.redirect_uri + '&state=' + this.user.id);
                },
                controllerAs: 'vendAuthCtrl',
                resolve: {
                    user: function (userService) {
                        return userService.getCurrentUser()
                    },
                    vendAuth: function (user, vendAuthService) {
                        var request = {};
                        request.user_id = user.id;
                        return vendAuthService.getUserVendAuth(request)
                    },
                    vendCreds: function (vendAuthService) {
                        return vendAuthService.getVendAppCreds();
                    }
                }
            })
            .state('vend-products', {
                url: "/product-tools/vend-products",
                templateUrl: "/product-tools/app/templates/vendproducts.html?v=" + randNumber(),
                controller: function ($rootScope, $sce, $filter) {
                    var self = this;

                    self.products = {};

                    $rootScope.$watch('products',function(){
                        self.products = $filter('filter')($rootScope.products, {'type': 'Internal Use'});
                    });
                },
                controllerAs: 'vpm',
                //resolve: {
                //    products: function (vendApiService) {
                //        return vendApiService.getAllProducts()
                //    }
                //}
            })
            .state('bom-create', {
                url: "/product-tools/bom/details",
                templateUrl: "/product-tools/app/templates/bomdetails.html?v=" + randNumber(),
                controller: function ($rootScope,$filter) {
                    var self = this;
                    self.products = {};
                    $rootScope.$watch('products',function(){
                        self.products = $filter('filter')($rootScope.products, {'type':'!Internal Use'});
                        console.log(self.products);
                    });
                },
                controllerAs: 'bdm',
            })


        $locationProvider
            .html5Mode({
                enabled: true,
                requireBase: false
            })
    })
    .controller('HomeController', function ($rootScope,userService, vendAuthService, $mdSidenav, vendApiService) {

        var homeModel = this;

        homeModel.user = {};
        homeModel.VendAuth = {};
        homeModel.VendCreds = {};
        homeModel.hasFreshVendToken = false;
        vendApiService.getAllVendProducts().then(function(response){
            $rootScope.products = response;
        });

        homeModel.toggleMenu = function(){
            console.log('asfd');
            $mdSidenav('left').toggle();
        };

        homeModel.init = function () {
            userService.getCurrentUser().then(function (response) {
                homeModel.user = response;
                homeModel.setVendAuth();
                homeModel.setVendCreds();
            })
        };

        homeModel.setVendAuth = function () {
            var request = {};
            request.user_id = homeModel.user.id;
            vendAuthService.getUserVendAuth(request).then(function (response) {
                homeModel.VendAuth = response;
                homeModel.hasFreshVendToken = homeModel.verifyVend();
            })
        };

        homeModel.setVendCreds = function () {
            vendAuthService.getVendAppCreds().then(function (response) {
                homeModel.VendCreds = response;
            })
        };

        homeModel.verifyVend = function () {
            var hasToken = (typeof homeModel.VendAuth.access_token != 'undefined');

            if (hasToken === false) {
                console.log('No vendAuth found');
                return false;
            }

            var isTokenExpired = (homeModel.VendAuth.expires < Math.floor(Date.now() / 1000));

            return !!(hasToken && isTokenExpired === false);
        };

        homeModel.init();
    })
    .filter('trust', [
        '$sce',
        function($sce) {
            return function(value, type) {
                // Defaults to treating trusted text as `html`
                return $sce.trustAs(type || 'html', value);
            }
        }
    ])
;


function randNumber() {
    return Math.floor((Math.random() * 10000) + 1);
}