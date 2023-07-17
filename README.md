# victr
VUMC VICTR PHP Code Challenge
After cloning/downloading the project.
docker-compose up --build

Feaures:
on homepage/index page shows list of git projects.
Initially no projects will be shown , use refresh button to fetch repo details.
On successful fetch , repo details will be saved in db and shows in same page.
On every refresh button click it fetches again from git, if repo details already exist then it will update existing data, otherwise will
insert as new.
In case gets git fetch error. then please put a valid git access token in fetchfromgit.php line 6.
