/**
 * Created by myazdani on 6/19/2017.
 */

'use strict';

AnalyticsApp.controller('ProfileCtrl', function ($scope, fileUpload) {

    $scope.files = [
      "BFSL NAV",
      "Drawn Capital"
    ];

    $scope.upload_file = function () {
      var file = $scope.myFile;
      var uploadUrl = 'http://www.example.com/images';
      fileUpload.uploadFileToUrl(file, uploadUrl);

      console.log("file upload function finished.");
    };

    $scope.start_engine = function () {

    };

    $scope.publish_report = function () {

    };

  });
