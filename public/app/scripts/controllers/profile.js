/**
 * Created by myazdani on 6/19/2017.
 */

'use strict';

AnalyticsApp.controller('ProfileCtrl', function ($scope, $localStorage, upload) {

    $scope.files = [
      "BFSL NAV"
      //, "Drawn Capital"
    ];

    var upload_url = 'http://localhost/gatekeeper/index.php/ClientFiles/' + $localStorage.token + '/' + $localStorage.user;

    $scope.upload_file = function () {

    };
    $scope.start_engine = function () {

    };

    $scope.publish_report = function () {

    };

  });
