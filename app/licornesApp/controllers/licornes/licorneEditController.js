(function () {

    var injectParams = ['$scope', '$location', '$routeParams',
                        '$timeout', 'config', 'dataService', 'modalService'];

    var LicorneEditController = function ($scope, $location, $routeParams,
                                           $timeout, config, dataService, modalService) {

        var vm = this,
            licorneId = ($routeParams.licorneId) ? parseInt($routeParams.licorneId) : 0,
            timer,
            onRouteChangeOff;

        vm.licorne = {};
        vm.states = [];
        vm.title = (licorneId > 0) ? 'Edit' : 'Add';
        vm.buttonText = (licorneId > 0) ? 'Update' : 'Add';
        vm.updateStatus = false;
        vm.errorMessage = '';

        vm.isStateSelected = function (licorneStateId, stateId) {
            return licorneStateId === stateId;
        };

        vm.saveLicorne = function () {
            if ($scope.editForm.$valid) {
                if (!vm.licorne.id) {
                    dataService.insertLicorne(vm.licorne).then(processSuccess, processError);
                }
                else {
                    dataService.updateLicorne(vm.licorne).then(processSuccess, processError);
                }
            }
        };

        vm.deleteLicorne = function () {
            var custName = vm.licorne.firstName + ' ' + vm.licorne.lastName;
            var modalOptions = {
                closeButtonText: 'Cancel',
                actionButtonText: 'Delete Licorne',
                headerText: 'Delete ' + custName + '?',
                bodyText: 'Are you sure you want to delete this licorne?'
            };

            modalService.showModal({}, modalOptions).then(function (result) {
                if (result === 'ok') {
                    dataService.deleteLicorne(vm.licorne.id).then(function () {
                        onRouteChangeOff(); //Stop listening for location changes
                        $location.path('/licornes');
                    }, processError);
                }
            });
        };

        function init() {

            getStates().then(function () {
                if (licorneId > 0) {
                    dataService.getLicorne(licorneId).then(function (licorne) {
                        vm.licorne = licorne;
                    }, processError);
                } else {
                    dataService.newLicorne().then(function (licorne) {
                        vm.licorne = licorne;
                    });
                }
            });


            //Make sure they're warned if they made a change but didn't save it
            //Call to $on returns a "deregistration" function that can be called to
            //remove the listener (see routeChange() for an example of using it)
            onRouteChangeOff = $scope.$on('$locationChangeStart', routeChange);
        }

        init();

        function routeChange(event, newUrl, oldUrl) {
            //Navigate to newUrl if the form isn't dirty
            if (!vm.editForm || !vm.editForm.$dirty) return;

            var modalOptions = {
                closeButtonText: 'Cancel',
                actionButtonText: 'Ignore Changes',
                headerText: 'Unsaved Changes',
                bodyText: 'You have unsaved changes. Leave the page?'
            };

            modalService.showModal({}, modalOptions).then(function (result) {
                if (result === 'ok') {
                    onRouteChangeOff(); //Stop listening for location changes
                    $location.path($location.url(newUrl).hash()); //Go to page they're interested in
                }
            });

            //prevent navigation by default since we'll handle it
            //once the user selects a dialog option
            event.preventDefault();
            return;
        }

        function getStates() {
            return dataService.getStates().then(function (states) {
                vm.states = states;
            }, processError);
        }

        function processSuccess() {
            $scope.editForm.$dirty = false;
            vm.updateStatus = true;
            vm.title = 'Edit';
            vm.buttonText = 'Update';
            startTimer();
        }

        function processError(error) {
            vm.errorMessage = error.message;
            startTimer();
        }

        function startTimer() {
            timer = $timeout(function () {
                $timeout.cancel(timer);
                vm.errorMessage = '';
                vm.updateStatus = false;
            }, 3000);
        }
    };

    LicorneEditController.$inject = injectParams;

    angular.module('licornesApp').controller('LicorneEditController', LicorneEditController);

}());