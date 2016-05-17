(function () {

    var injectParams = ['$filter', '$window', 'dataService'];

    var OrdersController = function ($filter, $window, dataService) {
        var vm = this;

        vm.licornes = [];
        vm.filteredLicornes;
        vm.filteredCount;

        //paging
        vm.totalRecords = 0;
        vm.pageSize = 10;
        vm.currentPage = 1;

        init();

        vm.pageChanged = function (page) {
            vm.currentPage = page;
            getLicornes();
        };

        vm.searchTextChanged = function () {
            filterLicornesProducts(vm.searchText);
        };

        function init() {
            //createWatches();
            getLicornes();
        }

        //function createWatches() {
        //    //Watch searchText value and pass it and the licornes to nameCityStateFilter
        //    //Doing this instead of adding the filter to ng-repeat allows it to only be run once (rather than twice)
        //    //while also accessing the filtered count via vm.filteredCount above

        //    //Better to handle this using ng-change on <input>. See searchTextChanged() function.
        //    $scope.$watch("searchText", function (filterText) {
        //        filterLicornesProducts(filterText);
        //    });
        //}

        function filterLicornesProducts(filterText) {
            vm.filteredLicornes = $filter("nameProductFilter")(vm.licornes, filterText);
            vm.filteredCount = vm.filteredLicornes.length;
        }

        function getLicornes() {
            dataService.getLicornes(vm.currentPage - 1, vm.pageSize)
                .then(function (data) {
                    vm.totalRecords = data.totalRecords;
                    vm.licornes = data.results;
                    filterLicornesProducts('');
                }, function (error) {
                    if(error.status === 404)        
                        $window.alert("Impossible de contacter le webservice");
                    else
                        $window.alert(error.message)
                });
        }
    };

    OrdersController.$inject = injectParams;

    angular.module('licornesApp').controller('OrdersController', OrdersController);

}());



