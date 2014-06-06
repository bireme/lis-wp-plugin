LIS WordPress plugin 
===================

##Introduction
This plugin create a search interface for Virtual Health Library LIS (Health Information Locator) information source.

## Install

0. [Download](https://github.com/bireme/lis-wp-plugin/archive/master.zip) the LIS Wordpress plugin.
0. Unzip the plugin under wp-content/plugins folder of your Wordpress and rename it to `lis`
0. Activate the LIS Wordpress plugin via the admin panel in WordPress.
    * For more information please see [this documentation](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

##Configuration
0. Go to `Settings` in the admin panel and click on the newly created `LIS` sublink.
    * `Service URL` is mandatory and is set to `http://fi-admin.bvsalud.org` by default and specify the webservice of FI-ADMIN system. 
    * `Plugin page` is mandatory and is set to `lis` by default and specify the URL of the search interface page.
    * `Search form` is a flag to control the display of the search box in the page.
    * `Disqus shortname` is optional and represent the integration of the comments service [Disqus](http://disqus.com/).
    * `AddThis profile ID` is optional and allow the integration with the sharing tools service [AddThis](http://www.addthis.com/).
    * `Google Analytics code` is optional and allow integration of analytics service from Google.
