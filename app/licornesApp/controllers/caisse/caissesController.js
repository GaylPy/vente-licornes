(function () {

    var injectParams = ['$location', '$filter', '$window',
                        '$timeout', 'authService', 'dataService', 'modalService'];

    var CaissesController = function ($location, $filter, $window,
        $timeout, authService, dataService, modalService) {

        var vm = this;

        vm.licornes = [];
        vm.filteredLicornes = [];
        vm.filteredCount = 0;
        vm.orderby = 'name';
        vm.reverse = false;
        vm.searchText = null;
        vm.cardAnimationClass = '.card-animation';

        //paging
        vm.totalRecords = 0;
        vm.pageSize = 10;
        vm.currentPage = 1;

        vm.pageChanged = function (page) {
            vm.currentPage = page;
            getLicornesSummary();
        };

        vm.DisplayModeEnum = {
            Card: 0,
            List: 1
        };

        vm.changeDisplayMode = function (displayMode) {
            switch (displayMode) {
                case vm.DisplayModeEnum.Card:
                    vm.listDisplayModeEnabled = false;
                    break;
                case vm.DisplayModeEnum.List:
                    vm.listDisplayModeEnabled = true;
                    break;
            }
        };

        vm.navigate = function (url) {
            $location.path(url);
        };

        vm.setOrder = function (orderby) {
            if (orderby === vm.orderby) {
                vm.reverse = !vm.reverse;
            }
            vm.orderby = orderby;
        };

        vm.searchTextChanged = function () {
            filterLicornes(vm.searchText);
        };

        function init() {
            //createWatches();
            getLicornesSummary();
        }

        //function createWatches() {
        //    //Watch searchText value and pass it and the licornes to nameCityStateFilter
        //    //Doing this instead of adding the filter to ng-repeat allows it to only be run once (rather than twice)
        //    //while also accessing the filtered count via vm.filteredCount above

        //    //Better to handle this using ng-change on <input>. See searchTextChanged() function.
        //    vm.$watch("searchText", function (filterText) {
        //        filterLicornes(filterText);
        //    });
        //}

        function getLicornesSummary() {
            dataService.getLicornesSummary(vm.currentPage - 1, vm.pageSize)
            .then(function (data) {
                vm.totalRecords = data.totalRecords;
                vm.licornes = data.results;
                filterLicornes(''); //Trigger initial filter

                $timeout(function () {
                    vm.cardAnimationClass = ''; //Turn off animation since it won't keep up with filtering
                }, 1000);

            }, function (error) {
                if(error.status === 404)
                    $window.alert("Impossible de contacter le Webservice")
                else
                    $window.alert('Sorry, an error occurred: ' + error.data.message);
            });
        }

        function filterLicornes(filterText) {
            vm.filteredLicornes = $filter("nameCityStateFilter")(vm.licornes, filterText);
            vm.filteredCount = vm.filteredLicornes.length;
        }

        function getLicorneById(id) {
            for (var i = 0; i < vm.licornes.length; i++) {
                var cust = vm.licornes[i];
                if (cust.id === id) {
                    return cust;
                }
            }
            return null;
        }

        init();
    };

    CaissesController.$inject = injectParams;

    angular.module('licornesApp').controller('CaissesController', CaissesController);

}());
