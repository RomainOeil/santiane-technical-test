# santiane-technical-test
GitHub Repo for the technical test of Santiane

The project have been made with LAMP and MySQL.

The main page display the list of journeys available, a form is available to add more journey.

Click on the name of a journey redirect the user to a new page were he can see all the stop of the journey and add more.
The details of the journey (place of departure and arrival, type and numbers of the transport and others) are displayed in a table.
The last column let the user select the stop he want to delete after clicking on "Delete selected stops".
In the right bottom corner, a button let the user delete the travel and the stops, on the first input, a second button ask if the user confirm the deletion to avoid accidental input.

The "Seat", "Gate" and "Baggage drop" data aren't mandatory, if not set, they will be NULL, all the others data are required, the form can't be validate without them.

The website will display an error message if it can't add a stop.
The case that block the adding of a stop are:
    -If "Type", "Number", "Departure" or "Arrival" aren't set (in case of a possible error let the user validate the form)
    -If an already set stop have the same departure or arrival

First push:
    Database created and filled with exemples data using the website.
    Core features created.

Second push:
    Added stops sort by departure/arrival.
    If a journey isn't completed, a warning is showed.

Third push:
    Ability to remove stops and journeys.

Fourth push:
    Graphical improvements

Fifth:
    Added unit test
    Separeted html code and php functions
