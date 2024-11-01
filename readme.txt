=== Plugin Name ===
Contributors: panglea
Donate Link: http://www.peteranglea.com/wpsermons/
Tags: sermons, church, mp3, upload
Requires at least: 2.0
Tested up to: 2.1.3
Stable tag: 0.8.1

WordPress plugin for publishing recorded mp3 sermons on the web via a church website.

== Description ==

wpSermons is a WordPress plugin which was created to enable churches with WordPress websites to easily and effortlessly upload MP3 sermons onto their websites for all to hear and download.

== Installation ==

Installing the Plugin

* Extract the zipped folder and all its contents into your plugins folder.
* In your WordPress administration panel, click on "Plugins."
* wpSermons should appear in the list of plugins. Click "Activate" to use.
* If you see a message saying that the plugin was successfully activated, it is now ready for use!!
* Again, in your WordPress panel, click on "Manage", then on "Sermons" under that. Sermons tab

Uploading/Editing Sermons

* When you upload a sermon, specify the title, the speaker's name, and the date of the sermon. You may also type additional notes (this could include the Scripture passage or even a full sermon outline if you're ambitious). Be sure to check the "shown" box to specify if the sermon should be shown on the site and this point and time.
* In the View/Edit/Delete pane, you can Edit or Delete each sermon listing as well as update which sermons you want to have shown on the web.

Displaying your Sermons

* To show sermons on a WordPress page, simply type [sermons] in the text field and save the page.
* If everything worked correctly, you should see all of your sermons neatly arranged on the page you specified. Sermons showcased

Description of the Files Included

* uploads [folder]: This is where all mp3 files will be uploaded to.
* wpsermons.php: This is the main plugin file that will be used for activating the plugin
* installsql.php: This contains the PHP code that will install the database table for wpSermons
* managesermons.php: This is the page used in the administration panel for uploading, editing, etc.
* showsermons.php: This page displays the sermons on the page. THIS IS THE ONLY FILE YOU SHOULD EDIT (and only if you know what you're doing) if you want to manipulate how the sermons are displayed on the page.
* loading.gif: A loading icon which will appear when you upload a sermon. (Firefox has been known to be a bit glitchy with this item)
* player.swf: A small flashplayer that provides a nice, neat way of allowing visitors to listen to your uploaded sermons.


== Frequently Asked Questions ==

= Why does my sound file play in fast-forward like "chipmunks"? =

This is a problem with the flash player. The flash mp3 player was developed by 1PixelOut. Support regarding this issue can be found at their website - http://www.1pixelout.net/code/audio-player-wordpress-plugin/

= How do I upgrade? = 

First, download the latest version of the plugin. Then delete all of the files in the wpsermons folder except for the uploads folder (so you don't lose your uploaded sound files). Then replace the files you deleted with the new files you just downloaded.

== Screenshots ==

No screenshots yet.