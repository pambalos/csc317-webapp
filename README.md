# csc317-webapp
Repository for CSC 317 webapp. This repository will represent the files sitting at directory /var/www/html/ on the virtual image.

## Structure
./ -> any HTML files

./resources -> any images, css, or other resource files

## Commit Process

### Please do not commit directly to the master branch. 

Open a new branch with: 

#### git checkout -b branchName

Then when you are ready to commit your changes, commit with a good message:

#### git commit -m 'your commit message, give details'

Then, you can push. 

#### git push

If this last command fails, it is because your local branch is not in the repo. It will suggest an alternate command, go ahead and run that command.

Then to merge your work into master, we will open a Pull Request from the Github UI, merging each piece in as we go.
This can be located at https://github.com/pambalos/csc317-webapp/pulls
