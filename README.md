# Microsoft Graph OAuth2 Provider for Laravel Socialite

Inspired by <a href="https://github.com/SocialiteProviders/Microsoft-Azure">https://github.com/SocialiteProviders/Microsoft-Azure</a>


## Documentation


###INSTALLATION

####1. COMPOSER

>  This assumes that you have composer installed globally

```composer require knox2/msgraph```

####2. SERVICE PROVIDER

>Remove Laravel\Socialite\SocialiteServiceProvider from your providers[] array in config\app.php if you have added it already.

>Add \SocialiteProviders\Manager\ServiceProvider::class to your providers[] array in config\app.php.

For example:

```
'providers' => [
    // remove 'Laravel\Socialite\SocialiteServiceProvider',
    \SocialiteProviders\Manager\ServiceProvider::class, // add
];
```
>Note: If you would like to use the Socialite Facade, you need to install it.

####3. ADD THE EVENT AND LISTENERS

>Add SocialiteProviders\Manager\SocialiteWasCalled event to your listen[] array in <app_name>/Providers/EventServiceProvider.

>Add your listeners (i.e. the ones from the providers) to the SocialiteProviders\Manager\SocialiteWasCalled[] that you just created.

The listener that you add for this provider is 
```
'Knox\MSGraph\MSGraphExtendSocialite@handle'
```

>Note: You do not need to add anything for the built-in socialite providers unless you override them with your own providers.

For example:

```
/**
 * The event handler mappings for the application.
 *
 * @var array
 */
protected $listen = [
    \SocialiteProviders\Manager\SocialiteWasCalled::class => [
        'Knox\MSGraph\MSGraphExtendSocialite@handle',
    ],
];
```

####4. ENVIRONMENT VARIABLES

add environment values to your .env

````
// other values above
MSGRAPH_KEY=yourkeyfortheservice
MSGRAPH_SECRET=yoursecretfortheservice
MSGRAPH_REDIRECT_URI=https://example.com/login   
````
add to config/services.php



```

'msgraph' => [

	'client_id' => env('MSGRAPH_KEY'),

    'client_secret' => env('MSGRAPH_SECRET'),
    
    'redirect' => env('MSGRAPH_REDIRECT_URI'),  
    
], 

```

###REFERENCE

####USAGE

You should now be able to use it like you would regularly use Socialite (assuming you have the facade installed):

```
return Socialite::with('msgraph')->redirect();

```

####LUMEN SUPPORT

You can use Socialite providers with Lumen. Just make sure that you have facade support turned on and that you follow the setup directions properly.

>Note: If you are using this with Lumen, all providers will automatically be stateless since Lumen does not keep track of state.

>Also, configs cannot be parsed from the services[] in Lumen. You can only set the values in the .env file as shown exactly in this document. If needed, you can also override a config (shown below).

####STATELESS

You can set whether or not you want to use the provider as stateless. Remember that the OAuth provider (Twitter, Tumblr, etc) must support whatever option you choose.
Note: If you are using this with Lumen, all providers will automatically be stateless since Lumen does not keep track of state.

>to turn off stateless

```
return Socialite::with('msgraph')->stateless(false)->redirect();

```

>to use stateless

```
return Socialite::with('msgraph')->stateless()->redirect();

```

####OVERRIDING A CONFIG

If you need to override the provider’s environment or config variables dynamically anywhere in your application, you may use the following:

```

$clientId = "secret";
$clientSecret = "secret";
$redirectUrl = "http://yourdomain.com/api/redirect";
$additionalProviderConfig = ['site' => 'meta.stackoverflow.com'];
$config = new \SocialiteProviders\Manager\Config($clientId, $clientSecret, $redirectUrl, $additionalProviderConfig);
return Socialite::with('msgraph')->setConfig($config)->redirect();

```
####RETRIEVING THE ACCESS TOKEN RESPONSE BODY

Laravel Socialite by default only allows access to the access\_token. Which can be accessed via the

 ```
 \Laravel\Socialite\User->token
 ``` 
 
 public property. Sometimes you need access to the whole response body which may contain items such as a refresh_token.

You can get the access token response body, after you called the user() method in Socialite, by accessing the property
 ```
 $user->accessTokenResponseBody
 ```

```
$user = Socialite::driver('msgraph')->user();

$accessTokenResponseBody = $user->accessTokenResponseBody;

```
