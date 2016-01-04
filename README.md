#WP Hipster


## Get up and running
1. Clone repo `git clone https://github.com/dejano/wphipster.git`
2. `git submodules init`
`git submodules update`
3. Setup environment
    1. Create virtual host.
    2. Environment is defined inside .htaccess `SetEnv APPLICATION_ENV "dev"` where `dev` is environment name. Change `WP_HOME` and `DB_*` constants inside `config/env/dev.php`.






*  Changing environment (setup your own env and add it to .gitignore)
	  * Set `SetEnv APPLICATION_ENV "envName"` inside .htaccess. 
	  * Create file inside `config/env/envName.php`.
    
    *Default config file is `config/env/local.php` and if it exists custom environment will be ignored.*
  
----------
    
## Directory structure

```
├── config/		    # configuration
├── public/
│   ├── content/	# themes, plugins, uploads
│   ├── ├── plugins/
│   ├── ├── themes/
│   ├── ├── ├── wphipster/
│   ├── ├── ├── ├── bower_components/
│   ├── ├── ├── ├── config/			# framework config files (theme specific)
│   ├── ├── ├── ├── framework/				
│   ├── ├── ├── ├── include/		# theme files
│   ├── ├── ├── ├── partials/		# view files
│   ├── ├── ├── ├── static/			# js, sass and css
│   ├── ├── uploads/
│   ├── site/		# wordpress files
```


----------
Demo content http://wptest.io/
