<?php

namespace Knox\MSGraph;

use SocialiteProviders\Manager\SocialiteWasCalled;

class MSGraphExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite(
            'msgraph', __NAMESPACE__.'\Provider'
        );
    }
}
