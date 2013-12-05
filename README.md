AvBitlyBundle
=============

This bundle permits to use the bitly api V3


# Configuration
In your config.yml, add this parameters:

    av_bitly:
        bitly_token:  %bitly_token%  #mandatory
        bitly_api_address: '' #optional, default value = 'https://api-ssl.bitly.com'
        bitly_domain: yourdomain #optional, default value = ''

# Usage

    $bitlyService = $this->get('av_bitly.bitly_service');
    //generate the bitly url
    $shortUrl = $bitlyService->shorten($route);

# Fonctions
The functions availables are:

   -shorten
