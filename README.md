# pfsense-start-quota
pfSense 2.3.x package that reports on data &amp; quota usage for Start Communications customers.

This package provides two elements:

  1. A detailed data usage overview page that provides details and pie charts showing your data usage and available quota (if not on an unlimited data plan).  This information is available under the Status menu. ![status screenshot](https://github.com/Slugger/pfsense-start-quota/raw/media/media/start_quota.png)
  2. A widget that can be installed on your pfSense dashboard that provides the usage data without the pie charts.  A nice way to have a quick overview of your usage/quota data directly on your pfSense dashboard. ![widget screenshot](https://github.com/Slugger/pfsense-start-quota/raw/media/media/start_widget.png)

# Installation

To install this package on your pfSense 2.3.x system, go to the [releases](https://github.com/Slugger/pfsense-start-quota/releases), download the latest to your pfSense system and then run the following command:

`pkg add pfSense-pkg-Start_Quota-x.y.z.txz`

Note that this package is not part of the pfSense ports repository and therefore you cannot install it from the pfSense package manager.  This also means the package will not auto update itself, etc.  The only way to install/update this package is to manually download releases from this project site and then manually install it using the command above.

# Upgrade

If you are upgrading from an older version, you can run the following command:

`pkg upgrade pfSense-pkg-Start_Quota-x.y.z.txz`

This command will remove the old version and upgrade you to the new one.

# Configuration

When you attempt to load the status page after installation it will recognize that the API key is not set and direct you to the configuration page.  Enter your Start API key and also tell the package what your monthly data quota is.  If you're on an unlimited plan set the quota value to 0.

**NOTE:** To obtain your API key, visit http://www.start.ca/support/usage/api

# Uninstall

`pkg delete pfSense-pkg-Start_Quota`

# Data Caching

As per Start's API spec, usage data is cached for 60 minutes at a time.  Additional requests for usage data simply reload the existing cached data for that full hour.  In other words, there is no point in constantly refreshing your dashboard or the status page as the data it's showing you is read from the local cache stored on the pfSense system.  Only after an hour will the Start servers be hit again for updated data.
