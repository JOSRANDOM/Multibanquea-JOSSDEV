# Multibanquea

Base project for the exam preparation web platforms.

## Local development setup

### Clone the project

Clone this project and checkout the `main` branch.

For contributions, create a feature branch and open a pull request.

### Setup Homestead

1. Install [Laravel Homestead](https://laravel.com/docs/8.x/homestead).

2. Configure `Homestead.yaml`:
  
    1. Ensure that you have a ssh key in your computer and that the key path in the configuration file points to it.
    
    2. Add an entry to `folders`:
    
    ```yaml
    folders:
        - map: ~/local-path/multibanquea
          to: /home/vagrant/code/multibanquea
    ```
    
    3. Add an entry to `sites`:
    
    ```yaml
    sites:
        - map: multibanquea.test
          to: /home/vagrant/code/multibanquea/public
    ```
    
    4. Add an entry to `databases`:
    
    ```yaml
    databases:
        - multibanquea
    ```

3. Configure DNS resolution
    
    To access http://multibanquea.test while developing, ensure that your `hosts` file has an entry like this:
    
    ```
    192.168.10.10  multibanquea.test
    ```

4. Start and provision Homestead Vagrant box
    
    Go to your Homestead directory and run:
    
    ```
    vagrant up --provision
    ```
    
    The website should now be available locally on http://multibanquea.test. It'll show error messages due to missing files. That's fine right now.

### Install local SSL certificate

1. Go to your Homestead path and run `vagrant shh` to ssh into the Vagrant virtual box.

2. Navigate to **/etc/nginx/ssl**: `cd /etc/nginx/ssl`

3. Copy the certificate: `sudo cp multibanquea.dev.crt /home/vagrant/code/multibanquea`

4. On your local computer, navigate to the **multibanquea** directory and install the certificate in your computer. You can then safely delete it.

5. The project should be now accessible locally via https://multibanquea.test, which is necessary to login locally with Facebook OAuth.

### Install Composer dependencies

1. Go to your Homestead path and run `vagrant shh` to ssh into the Vagrant virtual box.

2. Go to your project directory: `cd code/multibanquea/`

3. Install the composer dependencies: `composer install`

### Install NPM dependencies

1. Go to your local clone of this project (not from inside the Vagrant box).

2. Install the NPM dependencies: `npm install && npm run prod`

### Configure .env file

1. Duplicate the `/.env.example` file and rename it to `.env`.

2. Replace the database configuration in your `.env` file to:
    
    ```yaml
    DB_DATABASE=multibanquea
    DB_USERNAME=homestead
    DB_PASSWORD=secret
    ```

3. Ask a project maintainer for the other environment secrets and update your `.env` file.

4. Visit https://multibanquea.test and click on the "Generate app key" button and refresh.

### Seed the database

1. Go to your Homestead path and run `vagrant shh` to ssh into the Vagrant virtual box.

2. Go to your project directory: `cd code/multibanquea/`

3. Seed the database: `php artisan migrate:refresh --seed`

## New domain setup

### Buy domain in Punto.pe

Register a domain in https://punto.pe.

### Add domain to ALL-INKL

1. Login to the ALL-INKL technical administration panel: https://kas.all-inkl.com/

2. Go to **Domain** and click on **Create new domain**.

3. Enter the domain, the destination (**Webspace**, `/`), the PHP version (latest), enable the DKMI signature and click on **Save**.

### Add emails in ALL-INKL

1. Login to the ALL-INKL technical administration panel: https://kas.all-inkl.com/

2. Go to **Email** and **Email Account** and click on **Create new mail account**.

3. Setup the required emails and save.

### Point DNS to ALL-INKL

1. Login to punto.pe: https://punto.pe

2. Go to **Dominios** and select the domain.

3. In the DNS configuration add `ns5.kasserver.com` and `ns6.kasserver.com` and save.

4. Confirm the change via email.

The DNS update may take up to 24 hours to propagate globally.

### Add domain to DigitalOcean

1. Login to DigitalOcean's domain administration panel: https://cloud.digitalocean.com/networking/domains

2. Under **Add a domain** enter the domain and confirm.

3. Add the following records:

    * **A** record on `@` to `104.248.30.229` (The IP of our Forge server).
    
    * **CNAME** record on `www` to `@`.
    
    * **CNAME** record on any other subdomain(s) to `@`.

### Add domain to Cloudflare

1. Login to the Cloudflare administration panel: https://dash.cloudflare.com/

2. Click on **Add site** and enter the domain.

3. Add the following DNS records:

    * **A** record on `@` to `104.248.30.229` (The IP of our Forge server).
    
    * **CNAME** record on `www` to `@`.
    
    * **CNAME** record on `mail` to `w012c887.kasserver.com` (The ALL-INKL server).
    
    * **CNAME** record on any other subdomain(s) to `@`.
    
    * **MX** record on `@` to `w012c887.kasserver.com` (The ALL-INKL server).
    
    * **TXT** record on `@` to `v=spf1 mx a ?all`.
    
    * **TXT** record on `_dmarc` to `v=DMARC1; p=none;`.

4. Copy Cloudflare's nameservers and replace them in the punto.pe administration panel: https://punto.pe/dominios.php

The DNS update may take up to 24 hours to propagate globally.

## New site setup

### Create site in Laravel Forge

Go to our Laravel Forge server and add a new site.

1. On **Root Domain**, enter the domain (for example "example.com").

2. On **Web Directory**, enter `/current/public`.

3. Select **Use Website Isolation** and enter a name similar to the domain but with dashed instead of dots (for example "example-com").

4. Select **Create Database** and enter a name similar to the domain but with underscores (for example "example").

5. On **Apps**, select Git repository and enter the repository and branch information, select **Install Composer Dependencies** and install it.

6. On **SSL**, ensure that a LetsEncrypt certificate is installed.

7. Copy your `.env.example` file and on **Environment**, paste it and update its content, and then save.

8. On **Deployments**, click on **Deploy now**.

### Configure deployment in Laravel Envoyer

Go to our Envoyer dashboard.

1. Click on **Add Project**.

2. On **App name** enter the URL (for example "example.com"). Also enter the repository and branch information.

3. Go to **Severs** and add a server with the following information:
    
    * Name: `Laravel Forge`
    
    * Hostname / IP Address: `104.248.30.229` (The IP of our Forge server)
    
    * Port: `22`
    
    * Connect as: Same as the name entered for "Website Isolation" in Forge
    
    * PHP Version: `PHP 7.4`
    
    * Select **Receives Code Deployments**
    
    * Project Path: `/home/ISOLATION_NAME/WEBSITE_NAME`

4. Click on the key icon and copy the **Public SSH Key**. Go back to the Forge server dashboard and on **SSH Keys** add a new one with the name **Laravel Envoyer - ISOLATION_NAME**, the user that corresponds to the isolation name, paste the key and click on **Add**. Go back to Envoyer and on **Connection Status** click on the refresh icon. It should say **Successful**.

5. Add hook to restart queue:
    
    * Go to **Deployment Hooks** and click on **Add Hook**:
        
        * Name: `Restart queue`
        
        * Run As: The name of the isolation user
        
        * Script:
        
            ```
            cd {{ release }}
            
            php artisan queue:restart
            ```
            
        * Select **Laravel Forge**
    
    * Move the hook just after **Activate New Release** and before **Purge Old Releases**

6. On **Notifications** add a channel with the following information:
    
    * Name: The name of the isolation user
    
    * Type: `Slack`
    
    * Slack Webhook: Create a Slack Webhook for the corresponding Channel (https://api.slack.com/apps/A01GHUR9GBF/incoming-webhooks?). Only an admin of the Slack organization may be able to do so.

7. Go to **Project Settings** and in **The Basics** enter the URL in **Health Check URL**.

8. Go back to the project and click on **Deploy**.

### Update the environment variables in Laravel Forge

Go to the Forge server dashboard and inside the created site, and go to **Environment**.

Update the variables and click on save.

Go back to Envoyer and deploy again.

### Setup queue in Laravel Forge

Go to the Forge server dashboard and inside the created site, and go to **Queue**.

Start a worker with the default configuration and **Run Worker As Daemon** selected.

Go back to Envoyer and deploy again.

### Setup database

1. SSH into the Forge server with the isolated user and run `php migrate:refresh`.

2. Connect to the database and fill it with data, or, for test sites, run `php migrate:refresh --seed` instead of step 1 and skip this step.

### Setup scheduler

Go to the Forge server dashboard and inside the created site, and go to **Scheduler**.

Add a new scheduled job with this information:

* Command: `php /home/PATH_TO_PROJECT/current/artisan schedule:run` (to get the path, SSH into the Forge server with the isolated user, go to the `current` directory and run `pwd`).
    
* User: The name of the isolation user
    
* Frequency: `Every Minute`

## Site customization

### Localizations

The localization strings are stored inside the `/resources/lang/es/` path.

Some strings require customization when used on a site. For that, replace the instances of `null` with the desired text strings.

### Images

Images are stored inside the `/public/img/` path.

Some images require customization when used on a site. For that, replace the files inside the `/public/img/sites/` directory with the appropriate files using the same dimensions and format.

### Excel Import Library for Laravel

Run the following command:

composer require maatwebsite/excel --ignore-platform-reqs

php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
