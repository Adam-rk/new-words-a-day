# new-words-a-day

This is the API for the mobile app I've created in Flutter. The goal of this app is to give you a new word each time you want it. You can also access the history of all the words you previously received. 

After cloning the project, download all the dependencies of the project (```composer install```). Then, in your ```.env``` file, change this line so it can connect to your db: ```DATABASE_URL="mysql://root:root@127.0.0.1:8889/new_word_a_day"```. Finally, execute these two commands to create the db and the tables required ```symfony console doctrine:database:create``` ```symfony console doctrine:schema:update --force```.

After you have done all that, launch the local server ```symfony serve```. 

Now you can configure and launch the [flutter project](https://github.com/Adam-rk/new_words_a_day_mobile_flutter).
