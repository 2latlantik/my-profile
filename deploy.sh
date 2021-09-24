set -e

vendor/bin/simple-phpunit

(git push) || true

git checkout production
git merge main

git push origin production

git checkout master
