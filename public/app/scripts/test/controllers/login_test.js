/**
 * Created by myazdani on 7/20/2017.
 */
'use strict';

AnalyticsApp.controller('LoginTestCtrl', ['$scope', 'fileUpload', 'fileService', '$rootScope',
  '$localStorage', '$location', '$window', 'Server',
  function ($scope, fileUpload, fileService, $rootScope,
            $localStorage, $location, $window, Server) {

    $scope.token = "";

    $scope.autoLogin = function () {
      if ($scope.token) {
        var result = Server.autoLogin($scope.token)
          .then(function (data) {
            if (data.length > 1) {
              $scope.token = data;
              console.log(data);
              console.log("Transfer");
              $location.path("/catalog");
            }
          });
      }
    };
  }]);
