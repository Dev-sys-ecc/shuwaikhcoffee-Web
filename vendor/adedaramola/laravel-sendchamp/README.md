## Laravel Sendchamp

Laravel package to seamlessly integrate [Sendchamp API](https://sendchamp.com)

## Table of contents

- [Installation](#installation)
- [Basic Usage](#basic-usage)
- [SMS](#sms)
- [Voice](#voice)
- [Wallet](#wallet)
- [Verification](#verification)
- [Whatsapp](#whatsapp)
- [Contributing](#contributing)
- [Todo List](#todo-list)

## Installation

You can install the package via composer:
```bash
composer require adedaramola/laravel-sendchamp
```
Publish the config file
```bash
php artisan vendor:publish --config=
```
Be sure to set the following variables in your `.env` file
```env
SENDCHAMP_PUBLIC_KEY=
```

## Basic Usage

The package automaticaly assumes a test mode enviroment for the API, you can change this by setting `SENDCHAMP_MODE=true` in your `.env` file.

### SMS

```php
use Adedaramola\Sendchamp\Facades\Sendchamp;
use Adedaramola\Sendchamp\Http\Requests\SendSmsRequest;
use Adedaramola\Sendchamp\Http\Requests\CreateSenderIdRequest;

// Send an sms
Sendchamp::sms()->send(new SendSmsRequest(
    $to,
    $message,
    $sender_name,
    $route
));

// Create a new sender ID
Sendchamp::sms()->createSenderID(new CreateSenderIdRequest(
    $name,
    $sample,
    $use_case
));

// Get sms delivery report
Sendchamp::sms()->getDeliveryReport($sms_uid);

// Get bulk sms delivery report
Sendchamp::sms()->getBulkDeliveryReport($bulksms_uid);

```
### Voice
```php
use Adedaramola\Sendchamp\Facades\Sendchamp;
use Adedaramola\Sendchamp\Http\Requests\TextToSpeechRequest;
use Adedaramola\Sendchamp\Http\Requests\FileToVoiceRequest;

// text-to-speech
Sendchamp::voice()->textToSpeech(new TextToSpeechRequest(
    $customer_mobile_number,
    $message,
    $type,
    $repeat
));

// file-to-voice
Sendchamp::voice()->fileToVoice(new FileToVoiceRequest(
    $customer_mobile_number,
    $path,
    $type,
    $repeat
));

// Get delivery report
Sendchamp::voice()->getDeliveryReport();
```

### Verification
```php
use Adedaramola\Sendchamp\Facades\Sendchamp;
use Adedaramola\Sendchamp\Http\Requests\SendOtpRequest;

// send otp
Sendchamp::verification()->sendOtp(new SendOtpRequest(
    $channel,
    $sender,
    $token_type,
    $token_length
));

// verify otp
Sendchamp::verification()->confirmOtp(
    $verification_reference, $verification_code
);
```

### Whatsapp
```php
use Adedaramola\Sendchamp\Facades\Sendchamp;

Sendchamp::whatsapp()->sendText();
Sendchamp::whatsapp()->sendVideo();
Sendchamp::whatsapp()->sendAudio();
Sendchamp::whatsapp()->sendSticker();
```

### Wallet
```php
use Adedaramola\Sendchamp\Facades\Sendchamp;

// get your sendchamp wallet balance
Sendchamp::wallet()->getBalance();
```

## Todo List

* [ ] Email Resource
* [ ] Customer Resource

## Contributing

PRs are greatly appreciated, help us build this hugely needed tool so anyone else can easily integrate sendchamp into their Laravel based projects and applications.
<br/>
1. Create a fork
2. Create your feature branch: git checkout -b my-feature
3. Commit your changes: git commit -am 'Add some feature'
4. Push to the branch: git push origin my-new-feature
5. Submit a pull request 🚀

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.