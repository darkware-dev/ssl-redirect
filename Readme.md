# SSL Redirect for WordPress

SSL Redirect is a very simple plugin that will trigger browser redirects to HTTPS-secured 
equivalent URLs within a WordPress blog.

The code is not terribly complex (yet, at least), but it covers a number of features that 
I didn't find in many other existing plugins.

* Redirections occur using HTTP 301 responses, rather than javascript or META redirects.
* The redirections occur within WordPress code, rather than assuming the use of .htaccess
  files. This means this plugin happily works with:
  * Hosting providers that either do not give you access to the filesystem
  * WordPress instances running under Nginx or another non-Apache webserver
  * WordPress Multisite installs where server-based configuration would be globally applied
* The redirection can occur on a configured set of domain names, addressing the issue where 
  your site might have multiple domain names mapped to it, but only some of them are 
  configured with SSL certificates.
  
## To Do List

* Convert the textarea/self-formatted-list into a proper table
* Support redirections for Dashboard URLs
