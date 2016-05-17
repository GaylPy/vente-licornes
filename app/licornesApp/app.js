(function () {

    var app = angular.module('licornesApp',
        ['ngRoute', 'ngAnimate', 'wc.directives', 'ui.bootstrap']);

    app.config(['$routeProvider', function ($routeProvider) {
        var viewBase = '/gdl/app/licornesApp/views/';

        $routeProvider
            .when('/licornes', {
                controller: 'LicornesController',
                templateUrl: viewBase + 'licornes/licornes.html',
                controllerAs: 'vm'
            })
            .when('/licorneorders/:licorneId', {
                controller: 'LicorneOrdersController',
                templateUrl: viewBase + 'licornes/licorneOrders.html',
                controllerAs: 'vm'
            })
            .when('/licorneedit/:licorneId', {
                controller: 'LicorneEditController',
                templateUrl: viewBase + 'licornes/licorneEdit.html',
                controllerAs: 'vm',
                secure: true //This route requires an authenticated user
            })
            .when('/orders', {
                controller: 'OrdersController',
                templateUrl: viewBase + 'orders/orders.html',
                controllerAs: 'vm'
            })
            .when('/about', {
                controller: 'AboutController',
                templateUrl: viewBase + 'about.html',
                controllerAs: 'vm'
            })
            .when('/login/:redirect*?', {
                controller: 'LoginController',
                templateUrl: viewBase + 'login.html',
                controllerAs: 'vm'
            })
            .otherwise({ redirectTo: '/licornes' });

    }]);

    app.run(['$rootScope', '$location', 'authService',
        function ($rootScope, $location, authService) {
            
            //Client-side security. Server-side framework MUST add it's 
            //own security as well since client-based security is easily hacked
            $rootScope.$on("$routeChangeStart", function (event, next, current) {
                if (next && next.$$route && next.$$route.secure) {
                    if (!authService.user.isAuthenticated) {
                        $rootScope.$evalAsync(function () {
                         //   authService.redirectToLogin();
                        });
                    }
                }
            });

    }]);

}());

