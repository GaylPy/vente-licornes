(function () {

    var nameCityStateFilter = function () {

        return function (licornes, filterValue) {
            if (!filterValue) return licornes;

            var matches = [];
            filterValue = filterValue.toLowerCase();
            for (var i = 0; i < licornes.length; i++) {
                var lic = licornes[i];
                if (lic.firstName.toLowerCase().indexOf(filterValue) > -1 ||
                    lic.lastName.toLowerCase().indexOf(filterValue) > -1 ||
                    lic.city.toLowerCase().indexOf(filterValue) > -1 ||
                    lic.state.name.toLowerCase().indexOf(filterValue) > -1) {

                    matches.push(lic);
                }
            }
            return matches;
        };
    };

    angular.module('licornesApp').filter('nameCityStateFilter', nameCityStateFilter);

}());