# Hippomundo Coding Test

Hi! Welcome to the Hippomundo Coding Test project, which is used to evaluate 
code quality and efficiency in engineering candidates for the Hippomundo team.
The code in this project is not perfect, and there are some bugs and improvements
to be made. The code is MIT licensed, do with it whatever you want!

## Requirements
- Docker (https://docs.docker.com/install/)

## Installation of the test project
```
cp .env.example .env
docker compose build
docker compose run web composer install
docker compose run web npm install
docker compose run web php artisan key:generate
docker compose run web php artisan migrate --seed
docker compose up -d
```

You should now be able to browse to http://localhost:8000 and see the project.
Either you can register a new account in the system, or you can use the following 
credentions to log in (or any of the others generated in the UserSeeder):
```
Email: Farmboy2Jedi@TheForce.net
Pass:  password
```

Note: Make sure that the port 8000 and 5173 are available on your machine. 


## The test

Below are the requirements for the test. You can use any tools or libraries you want, 
but make sure to document your choices in the CHANGES.md file.

- Send us a message on the recruitment platform to let us know that you're starting the test.

- Create a new private repository with this repo as the content

- Add a way to edit existing cards (Change the name, assignee, or phase)

- Add a card count to the column header, but get the card count from the database (don't
 just count the cards in the UI or Javascript)

- Add a feature to mark one or more columns (phases) as being a "completion" phase. 
When a card is moved to one of the phases marked as such, the card should automatically
 get a `completed_at` datetime value, which can otherwise default to `null`. This should 
 only happen when the card is moved to the phase, not when it is created, and we only 
 want the datetime to be set once, so that it doesn't change if the card is moved back 
 and forth between the phases.
 Completed cards should be visually distinct from non-completed cards.

- Share your project with us by adding us (Github user "hippomundo") as a collaborator 
 to your forked repository, or send us the ZIP file of your project without the vendor or 
 node_modules folders.

## Fully optional, opportunity to impress us even more 

- Allow the user to delete an entire column, and all cards in it

- Maybe you can find bugs or make performance improvements, or improve the UX?

- Add single-column vertical scroll to the board, so that the board can be longer than 
the screen without adding a scrollbar to the entire page

- Create an extra page in the application that display some statistics, for example:
    - Number of cards assigned for each user
    - Number of cards completed this week
    - Number of cards completed this month

- Maybe you just want to make us say "wow" by adding a feature that you think would be 
 cool to have in a project like this. It can be anything you want. For example, you 
 could add a way to add a due date to a card, and then highlight cards that are overdue. 
 Or you could add a way to add a description to a card, and then show the description 
 when the card is clicked. Or you could add a way to add a background image to a card. 
 Maybe you want to add validation to the input forms? etc. etc. etc. Be creative!
