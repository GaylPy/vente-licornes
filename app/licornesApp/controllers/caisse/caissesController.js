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
        vm.cart = [];
        vm.ht = 0;
        vm.tva = 20;
        vm.ttc = 0;
        vm.cart.confirmed = false;
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
        vm.updateHtPrice = function(){
            vm.ht = 0;
            vm.cart.forEach(function(elem) {
                console.log(elem.quantity)
                vm.ht += elem.order.price*elem.quantity;
            }, this);
            return ;
        }
        vm.addToCart = function(licorne){
        if(!containsObject(licorne,vm.cart)){
            vm.cart.push(licorne); 
        }
            console.log(vm.cart);
                
        }
        vm.removeFromCart = function(licorne){
            var index = vm.cart.indexOf(licorne);
            if(index > -1){
                vm.cart.splice(index,1);
            }
        }
        
        function containsObject(obj, list) {
        var i;
        for (i = 0; i < list.length; i++) {
            if (list[i] === obj) {
                return true;
            }
        }
             return false;
        }
        
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
        
        vm.confirmSell = function(){
            // TODO Verification des stocks
            var idEcurie = 1;
            _.forEach(vm.cart, function(value) {
            console.log("quantity :" + value.quantity);
            console.log("ecurie :" + idEcurie);
            console.log("licorneId :" + value.id);
            });            
            console.log("num fid :" + vm.cart.numfid);
                
           // dataService.insertOrder(vm.order).then(processSuccess,processError);   
           processSuccess();
                
        };
        
        function processSuccess() {
            vm.cart.confirmed = true;    
        }

        function processError(error) {

        }
                
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

        vm.exportInvoice = function(){
        var header = '<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';  
        var table = document.getElementById('exportable').innerHTML;
        table.replace();
        var blob = new Blob([header + table], {
                type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;charset=utf-8"
            });
            saveAs(blob, "Report.xls");
        };            
        
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
