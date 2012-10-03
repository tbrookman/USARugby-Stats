## Thoughts

*  Currlently the design of this system is explicitly only for USA Rugby. Therefore there is really only one group of authenticated users that are managing data (likely from a group membership). Sould the app/config.php include the group UUID for controlling access?
*  Table: user Column: login is really now mail.
*  CDN-ify {bootstrap, jquery, ...} (assetic?)
*  Determine a good way to tell the user why they are not allowed to log in or why their login failed.
*  Move libraries off github as CDN?

## Deprecate

*  login.php
*  check.php
*  logout.php
*  include_js.php

