(function () {

    var injectParams = ['$scope','$routeParams', '$window', 'dataService'];

    var LicorneOrdersController = function ($scope, $routeParams, $window, dataService) {
        var vm = this,
            licorneId = ($routeParams.licorneId) ? parseInt($routeParams.licorneId) : 0;

        vm.licorne = {};
        vm.ordersTotal = 0.00;

        init();

        function init() {
            if (licorneId > 0) {
                dataService.getLicorne(licorneId)
                .then(function (licorne) {
                    vm.licorne = licorne;
                    $scope.$broadcast('licorne', licorne);
                }, function (error) {
                    if(error.status === 404)
                    $window.alert("Impossible de contacter le Webservice");
                    else
                    $window.alert("Sorry, an error occurred: " + error.message);
                });
            }
        }
    };

    LicorneOrdersController.$inject = injectParams;

    angular.module('licornesApp').controller('LicorneOrdersController', LicorneOrdersController);

}());