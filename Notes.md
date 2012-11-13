## Thoughts

*  Currlently the design of this system is explicitly only for USA Rugby. Therefore there is really only one group of authenticated users that are managing data (likely from a group membership). Sould the app/config.php include the group UUID for controlling access?
*  Table: user Column: login is really now mail.
*  CDN-ify {bootstrap, jquery, ...} (assetic?).
*  Determine a good way to tell the user why they are not allowed to log in or why their login failed.
*  Possibly Move libraries off github as CDN?
*  Chosen enhancements
   *  Use AJAX callback for large search area
   *  Search based on aggregate group above, description, name, categorization
   *  Possibly replace with jquery UI functionality: https://github.com/ivaynberg/select2


## SportsML

*  [Getting started guide](http://dev.iptc.org/SportML-Getting-started)
*  [SportMLT](http://www.sportsdb.org/sm/sportsmlt)
   *  [sportsml2html.xsl](https://www.iptc.org/std/SportsML/1.0/examples/sportsml2html.xsl) (Note: 1.0 - deprecated?)


## Deprecate

*  login.php
*  check.php
*  logout.php
*  include_js.php

