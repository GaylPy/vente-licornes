(function () {

    var injectParams = ['config', 'licornesService'];

    var dataService = function (config, licornesService) {
        return licornesService;
    };

    dataService.$inject = injectParams;

    angular.module('licornesApp').factory('dataService', dataService);

}());

