# api-whatsapp-business

[![Latest Version on Packagist](https://img.shields.io/packagist/v/emiliopuljiz/api-whatsapp-business.svg?style=flat-square)](https://packagist.org/packages/emiliopuljiz/api-whatsapp-business)
[![Total Downloads](https://img.shields.io/packagist/dt/emiliopuljiz/api-whatsapp-business.svg?style=flat-square)](https://packagist.org/packages/emiliopuljiz/api-whatsapp-business)

---

api-whatsapp-business is a package for Laravel that allows you to send WhatsApp templates dynamically to specified phone numbers. With this package, you can send templates regardless of the number of variables you have in the created template, making it easier to personalize the message for each recipient regardless of the complexity of the template.

## Installation

You can install the package via composer:

```bash
composer require emiliopuljiz/api-whatsapp-business
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag=":package_slug-migrations"

php artisan migrate
```

## 🚀 **Initial Setup:**

1. **Register on Facebook Developers:**

    - Go to [Facebook Developers](https://developers.facebook.com/).
    - Obtain the following data:
        - App Identifier: XXXXXXXXXXXXXXX (Obtained once you enter the app in the upper left part of the menu).
        - Phone Number Identifier: XXXXXXXXXXXXXXX (Obtained in the left menu WhatsApp > API Settings > below the selected phone number for sending the test).
        - App Secret Key: XXXXXXXXXXXXXXXX (Obtained in the left side menu App Settings > Basic).

2. **Database Configuration:**
    - Insert the `whatsapp_configurations` table into your database using the data obtained above.

📝 **Creating WhatsApp Templates:**

-   Create a template in WhatsApp, for example:
    -   **Name:** new_user
    -   **Type:** Utility (if it's for clients or users) / Marketing (if it's for other purposes)
-   Example template body:
    Header: (Welcome to My Application)

    Body:
    Hello {{1}}, here is your access information:

    User: {{2}}
    Password: {{3}}
    Access My Application: {{4}}

    Footer: (Greetings from the My Application team)

This process will allow you to configure your package to send dynamic and personalized WhatsApp templates to your recipients.

## Usage

-   You should create a job. Then dispatch the work from the place where you will use it in your app
-   Keep in mind that within the class you must make the call to use SendWhatsapp (The trait that we have in the package)

```php
<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use EmilioPuljiz\ApiWhatsappBusiness\Traits\SendWhatsapp;

class SendWhatsAppJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, SendWhatsapp;

    protected $phoneNumber;
    protected $templateName;
    protected $variables;

    /**
     * Create a new job instance.
     *
     * @param string $phoneNumber
     * @param string $templateName
     * @param array $variables
     * @return void
     */
    public function __construct($phoneNumber, $templateName, $variables)
    {
        $this->phoneNumber = $phoneNumber;
        $this->templateName = $templateName;
        $this->variables = $variables;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Call the SendWhatsappNotification method from the trait
        $this->SendWhatsappNotification(
            $this->phoneNumber,
            $this->templateName,
            $this->variables
        );
    }
}

```

-   Controller usage

```php
use App\Jobs\SendWhatsAppJob;

// Somewhere in your code...
$phoneNumber = '5493624380272';
$templateName = 'new_user';
$variables = ['Emilio', '+5493624380272', 'Emilio*1234', 'myapp.com'];

// Call Job to send WhatsApp message
SendWhatsAppJob::dispatch($phoneNumber, $templateName, $variables);

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

-   [emiliopuljiz](https://github.com/EmilioPuljiz)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
