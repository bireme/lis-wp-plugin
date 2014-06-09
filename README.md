LIS WordPress plugin 
===================

##Introduction
This plugin creates a search interface for the [Virtual Health Library](http://modelo.bvsalud.org/en/) LIS (Health Information Locator) information source.

## Install

0. [Download](https://github.com/bireme/lis-wp-plugin/archive/master.zip) the LIS plugin for Wordpress;
0. Unzip the plugin below the `wp-content/plugins` folder of your Wordpress instance and rename it to `lis`;
0. Activate the LIS plugin through the administration panel of WordPress (dashboard).
    * For further information on installing plugins please see the [Manual Plugin Installation from Wordpress codex site](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

##Configuration
0. Go to `Settings` in the administration panel (dashboard) and click on the newly created `LIS` item.
    * `Service URL` is mandatory and is set to `http://fi-admin.bvsalud.org` by default. It specifies the webservice of FI-ADMIN system; 
    * `Plugin page` is mandatory and is set to `lis` by default. It defines the URL of the search interface page;
    * `Search form` is optional and defines a flag to control the display of the search box in the `LIS` homepage;
    * `Disqus shortname` is optional. If used, it requires a code for the integration with the associated comments service  [Disqus](http://disqus.com/). Notice this requires previous registration within the comments service;
    * `AddThis profile ID` is optional and is provided to allow the integration with sharing tools services [AddThis](http://www.addthis.com/). Notice this requires previous registration within the sharing tools service;
    * `Google Analytics code` is optional and allows the integration of website analytics services provided by Google. Notice this requires previous registration in Google.
