<?php

if(! function_exists('data')) {
  function data($key = null, $default = null) {
      if(is_null($key)) {
          return app('static-data');
      }

      if(is_string($key)) {
          $repo = app('static-data');

          return $repo->get($key, $default);
      }

      throw new InvalidArgumentException('data helper can only be called with a string value for the data key');

  }
};