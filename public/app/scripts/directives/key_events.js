/**
 * Created by myazdani on 7/11/2017.
 */

'use strict';

var enter_key = 13;

AnalyticsApp.directive('onEnter', function () {
  return function (scope, element, attrs) {
    element.bind("keydown keypress", function (event) {
      if (event.which === enter_key) {
        scope.$apply(function () {
          scope.$eval(attrs.onEnter);
        });

        event.preventDefault();
      }
    });
  };
});
