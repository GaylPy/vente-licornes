(function () {

    var nameProductFilter = function () {

        function matchesProduct(licorne, filterValue) {
            if (licorne.orders) {
                for (var i = 0; i < licorne.orders.length; i++) {
                    if (licorne.orders[i].product.toLowerCase().indexOf(filterValue) > -1) {
                        return true;
                    }
                }
            }
            return false;
        }

        return function (licornes, filterValue) {
            if (!filterValue || !licornes) return licornes;

            var matches = [];
            filterValue = filterValue.toLowerCase();
            for (var i = 0; i < licornes.length; i++) {
                var lic = licornes[i];
                if (lic.firstName.toLowerCase().indexOf(filterValue) > -1 ||
                    lic.lastName.toLowerCase().indexOf(filterValue) > -1 ||
                    matchesProduct(lic, filterValue)) {

                    matches.push(lic);
                }
            }
            return matches;
        };
    };

    angular.module('licornesApp').filter('nameProductFilter', nameProductFilter);

}());