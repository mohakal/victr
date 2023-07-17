# victr
VUMC VICTR PHP Code Challenge <br>
After cloning/downloading the project. <br>
put a git token in fetchfromgit.php line 6. <br>
docker-compose up --build  <br>

Feaures: <br>
on homepage/index page shows list of git projects. <br>
Initially no projects will be shown , use refresh button to fetch repo details. <br>
On successful fetch , repo details will be saved in db and shows in same page. <br>
On every refresh button click it fetches again from git, if repo details already exist then it will update existing data, otherwise will
insert as new. <br>
Click on details in any record to see the details.
