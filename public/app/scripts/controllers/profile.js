/**
 * Created by myazdani on 6/19/2017.
 */

'use strict';

AnalyticsApp.controller('ProfileCtrl', ['$scope', 'FileUploader', function ($scope, FileUploader) {

    $scope.files = [
      "BFSL NAV"
      //, "Drawn Capital"
    ];

    var upload_url = 'http://localhost/gatekeeper/index.php/ClientFiles/' + $localStorage.token + '/' + $localStorage.user;

    $scope.upload_file = function () {
      var uploader = $scope.uploader = new FileUploader({
        url: upload_url
      });

      uploader.onProgressItem = function(fileItem, progress) {
        console.info('onProgressItem', fileItem, progress);
      };
      uploader.onProgressAll = function(progress) {
        console.info('onProgressAll', progress);
      };
      uploader.onSuccessItem = function(fileItem, response, status, headers) {
        console.info('onSuccessItem', fileItem, response, status, headers);
      };
      uploader.onErrorItem = function(fileItem, response, status, headers) {
        console.info('onErrorItem', fileItem, response, status, headers);
      };
    };

    $scope.start_engine = function () {

    };

    $scope.publish_report = function () {

    };

  }]);
