(function() {

    var injectParams = ['$scope'];

    var OrderChildController = function ($scope) {
        var vm = this;

        vm.orderby = 'product';
        vm.reverse = false;
        vm.ordersTotal = 0.00;
        vm.licorne;

        init();

        vm.setOrder = function (orderby) {
            if (orderby === vm.orderby) {
                vm.reverse = !vm.reverse;
            }
            vm.orderby = orderby;
        };

        function init() {
            if ($scope.licorne) {
                vm.licorne = $scope.licorne;
                updateTotal($scope.licorne);
            }
            else {
                $scope.$on('licorne', function (event, licorne) {
                    vm.licorne = licorne;
                    updateTotal(licorne);
                });
            }
        }

        function updateTotal(licorne) {
            var total = 0.00;
            for (var i = 0; i < licorne.orders.length; i++) {
                var order = licorne.orders[i];
                total += order.orderTotal;
            }
            vm.ordersTotal = total;
        }
    };

    OrderChildController.$inject = injectParams;

    angular.module('licornesApp').controller('OrderChildController', OrderChildController);

}());