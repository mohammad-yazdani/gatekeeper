/**
 * Created by myazdani on 6/22/2017.
 */

'use strict';

AnalyticsApp.service('fileService', ['$rootScope', '$timeout', function ($rootScope, $timeout) {
  var files = [];
  files.push = function () {
    $rootScope.$broadcast('file_added');
    console.log("Broadcast addition");
    return Array.prototype.push.apply(this,arguments);
  };
  return files;
}]);
