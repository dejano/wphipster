WP Hipster
======
#### Wordpress Theme


## Get up and running
---

1. Clone repo `git clone https://github.com/dejano/wphipster.git`
2. Get Wordpress from github repo
    ⋅⋅1. init `git submodules init`
    ⋅⋅2. update `git submodules init`
3. Setup environment
    ⋅⋅1. Create virtual host.
    ⋅⋅2. Environment is defined inside .htaccess `SetEnv APPLICATION_ENV "dev"` where `dev` is environment name.
    Change `WP_HOME` and `DB_*` constants to suit your setup.
    
+ Changing environment

    ⋅⋅*Set `SetEnv APPLICATION_ENV "envName"` inside .htaccess. 
    ⋅⋅*Create file inside `config/env/envName.php`.
    ⋅⋅⋅Default config file is `config/env/local.php` and if it exists custom environment will be ignored⋅⋅

    