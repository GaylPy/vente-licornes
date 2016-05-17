(function () {

    var injectParams = ['$http', '$q'];

    var licornesFactory = function ($http, $q) {
        var serviceBase = '/api/licorneservice/',
            factory = {};

        factory.getLicornes = function (pageIndex, pageSize) {
            return getPagedResource('licornes', pageIndex, pageSize);
        };

        factory.getLicornesSummary = function (pageIndex, pageSize) {
            return getPagedResource('licornesSummary', pageIndex, pageSize);
        };

        factory.getStates = function () {
            return $http.get(serviceBase + 'states').then(
                function (results) {
                    return results.data;
                });
        };

        factory.checkUniqueValue = function (id, property, value) {
            if (!id) id = 0;
            return $http.get(serviceBase + 'checkUnique/' + id + '?property=' + property + '&value=' + escape(value)).then(
                function (results) {
                    return results.data.status;
                });
        };

        factory.insertLicorne = function (licorne) {
            return $http.post(serviceBase + 'postLicorne', licorne).then(function (results) {
                licorne.id = results.data.id;
                return results.data;
            });
        };

        factory.newLicorne = function () {
            return $q.when({id: 0});
        };

        factory.updateLicorne = function (licorne) {
            return $http.put(serviceBase + 'putLicorne/' + licorne.id, licorne).then(function (status) {
                return status.data;
            });
        };

        factory.deleteLicorne = function (id) {
            return $http.delete(serviceBase + 'deleteLicorne/' + id).then(function (status) {
                return status.data;
            });
        };

        factory.getLicorne = function (id) {
            //then does not unwrap data so must go through .data property
            //success unwraps data automatically (no need to call .data property)
            return $http.get(serviceBase + 'licorneById/' + id).then(function (results) {
                extendLicornes([results.data]);
                return results.data;
            });
        };

        function extendLicornes(licornes) {
            var licsLen = licornes.length;
            //Iterate through licornes
            for (var i = 0; i < licsLen; i++) {
                var lic = licornes[i];
                if (!lic.orders) continue;

                var ordersLen = lic.orders.length;
                for (var j = 0; j < ordersLen; j++) {
                    var order = lic.orders[j];
                    order.orderTotal = order.quantity * order.price;
                }
                lic.ordersTotal = ordersTotal(lic);
            }
        }

        function getPagedResource(baseResource, pageIndex, pageSize) {
            var order = { quantity:1,price:2};
            var state = { name :"france"};
            var licorne1 = { id : 1, firstName :"A", lastName:"B", city:"paris", gender:"male", order:order,state:state};
            var licorne2 = { id : 2, firstName :"C", lastName:"D",city:"paris", gender:"male",order:order,state:state};
            var licorne3 = { id : 3, firstName :"E", lastName:"F",city:"paris", gender:"female",order:order,state:state};
            var licorne4 = { id : 4, firstName :"G", lastName:"H",city:"paris",gender:"female",order:order,state:state};
            var licos = [];
            licos.push(licorne1);
            licos.push(licorne2);
            licos.push(licorne3);
            licos.push(licorne4);            
            
            for(var i = 5; i < 50; i++)
                licos.push({ id : i, firstName :"A", lastName:"B", city:"paris", gender:"male", order:order,state:state});
                
            var resource = baseResource;
            resource += (arguments.length == 3) ? buildPagingUri(pageIndex, pageSize) : '';
            return $http.get(serviceBase + resource).then(function (response) {
                var lics = response.data;
                extendLicornes(lics);
                return {
                    totalRecords: parseInt(response.headers('X-InlineCount')),
                    results: lics
                };
            },function(data){
                return {
                    totalRecords: 4,
                    results: licos
                };
            });
            

            
 
        }

        function buildPagingUri(pageIndex, pageSize) {
            var uri = '?$top=' + pageSize + '&$skip=' + (pageIndex * pageSize);
            return uri;
        }

        // is this still used???
        function orderTotal(order) {
            return order.quantity * order.price;
        };

        function ordersTotal(licorne) {
            var total = 0;
            var orders = licorne.orders;
            var count = orders.length;

            for (var i = 0; i < count; i++) {
                total += orders[i].orderTotal;
            }
            return total;
        };

        return factory;
    };

    licornesFactory.$inject = injectParams;

    angular.module('licornesApp').factory('licornesService', licornesFactory);

}());