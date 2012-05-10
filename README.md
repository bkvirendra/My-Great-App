Today a lot of web apps/sites use Facebook for signing up users for
their websites. As users generally dont like to fill out registration
forms for every new site they visit. So here s a script that uses
Facebook Authentication to register users.

[Demo][]
========

[Download][]
============

Here s what you need to edit in the script First you need to create a
DB. Then create a table for signups.

Then you need to edit the following configurations in the "db/dbconfig.php" file

You need to have a Facebook App ID and App secret. You can create an Facebook App [here][]
So just add your app ID and app secret in the "index.php" & "home.php"

And finally add your Redirect URI in the "index.php" as show in the gist

If you have any concerns or issues you can send a Pull Request on [Github][]

  [Demo]: http://teckzone.in/myfbapps/mygreatapp/
  [Download]: #
  [here]: https://developers.facebook.com/apps
  [Github]: https://github.com/bkvirendra/My-Great-App