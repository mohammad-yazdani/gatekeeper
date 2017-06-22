/**
 * Created by myazdani on 6/19/2017.
 */

'use strict';

AnalyticsApp.controller('ProfileCtrl', ['$scope', 'fileUpload', function ($scope, fileUpload) {

    $scope.files = [
      "BFSL NAV"
      //, "Drawn Capital"
    ];

    var token = window.localStorage.getItem('token');
    var user = window.localStorage.getItem('user');

    var uploadUrl = 'http://localhost/gatekeeper/index.php/ClientFiles/' + token + '/' + user;

    console.log("Token: " + token);

    $scope.uploadFile = function () {
      var file = $scope.myFile;

      console.log('file is ' + file);

      return; // TODO : FOR TEST

      console.dir(file);

      fileUpload.uploadFileToUrl(file, uploadUrl);
    };

    $scope.start_engine = function () {

    };

    $scope.publish_report = function () {

    };

  }]);
