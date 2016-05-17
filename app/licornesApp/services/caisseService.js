(function () {

    var injectParams = ['$http', '$q'];

    var caisseFactory = function ($http, $q) {
        var serviceBase = '/api/caisseservice/',
                           factory = {};

        factory.insertOrders = function (order) {
            return $http.post(serviceBase + 'postOrder', order).then(function (results) {
                order.id = results.data.id;
                return results.data;
            });
        };


        factory.getBill = function (id) {
            //then does not unwrap data so must go through .data property
            //success unwraps data automatically (no need to call .data property)
            return $http.get(serviceBase + 'orderById/' + id).then(function (results) {
                return results.data;
            });
        };

        return factory;
    };

    caissesFactory.$inject = injectParams;

    angular.module('caissesApp').factory('caissesService', caissesFactory);

}());