Keezer
======

Web front end and flow meter daemon code for my Mario keezer

Setup
=====
Wire your flow meters to your raspberry pi to GPIO pins cooresponding to your tap number + 1 (i.e. tap 1 is on GPIO pin 2)

Remove the .example from the seekrits.php.example and seekrits.py.example files and edit to fit your environment

Run the two .sql files in the /sql directory to create your database and populate it with three records of example data. If you have more or less taps, add or delete rows accordingly

Run the filemon.py file to monitor for website changes (creates a file in the /keezerd/pid folder) to send a signal to keezerd.py to reload from DB

Run the /keezerd/keezerd.py file with your tap number and optionally a --verbose option to get output to the screen
i.e. python /var/www/keezerd/keezerd.py 1 [--verbose]
