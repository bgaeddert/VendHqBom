angular.module('productToolsApp').service('userService',function($http,$q){

    this.getCurrentUser = function (request) {
        var defer = $q.defer();

        $http({
            method: "GET",
            url: '/product-tools/users/current'
        })
            .success(function (response) {
                defer.resolve(response.payload)
            })
            .error(function (error, status) {
                console.log(error);
                defer.reject();
            });

        return defer.promise;
    }
});

angular.module('productToolsApp').service('vendAuthService',function($http,$q){

    this.getUserVendAuth = function (request) {
        var defer = $q.defer();

        $http({
            method: "GET",
            url: '/product-tools/vend/auth/' + request.user_id
        })
            .success(function (response) {
                defer.resolve(response.payload)
            })
            .error(function (error, status) {
                console.log(error);
                defer.reject();
            });

        return defer.promise;
    };

    this.getVendAppCreds = function (request) {
        var defer = $q.defer();

        $http({
            method: "GET",
            url: '/product-tools/vend/public/credentials'
        })
            .success(function (response) {
                defer.resolve(response.payload)
            })
            .error(function (error, status) {
                console.log(error);
                defer.reject();
            });

        return defer.promise;
    }

});

angular.module('productToolsApp').service('vendApiService',function($http,$q){
    
    var self = this;

    self.getAllVendProducts = function(){
        var defer = $q.defer();

        $http({
            method: "GET",
            url: '/product-tools/vend/products'
        })
            .success(function (response) {
                defer.resolve(response.payload.products)
            })
            .error(function (error, status) {
                console.log(error);
                defer.reject();
            });

        return defer.promise;
    }

});